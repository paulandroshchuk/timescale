<?php

namespace Database\Seeders;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\LazyCollection;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Spatie\TemporaryDirectory\TemporaryDirectory;

abstract class TimescaleSeeder extends Seeder
{
    protected int $rowsToInsert = 1_000;

    protected int $uniqueRows = 1_000;

    protected int $workers = 1;

    protected TemporaryDirectory $temporaryDirectory;

    protected string $file;

    public function run()
    {
        app('db')->disableQueryLog();

        $this->createTemporaryDirectory()
            ->createFile()
            ->loadFileWithData()
            ->dropSecondaryIndexes()
            ->loadDatabase()
            ->addSecondaryIndexes()
            ->deleteTemporaryDirectory()
            ->analyzeTable();
    }

    protected function createTemporaryDirectory(): self
    {
        $this->temporaryDirectory = (new TemporaryDirectory())->create();

        return $this;
    }

    protected function deleteTemporaryDirectory(): self
    {
        $this->temporaryDirectory->delete();

        return $this;
    }

    protected function createFile(): self
    {
        $this->file = $this->temporaryDirectory->path('file.csv');

        return $this;
    }

    protected function loadFileWithData(): self
    {
        $this->command->getOutput()->info(sprintf('Creating file with %s rows...', number_format($this->uniqueRows)));

        $this->command->getOutput()->progressStart($this->uniqueRows);

        SimpleExcelWriter::create($this->file)
            ->addRows($this->getRows());

        $this->command->getOutput()->progressFinish();

        return $this;
    }

    protected function dropSecondaryIndexes(): self
    {
        Schema::table($this->getTable(), function(Blueprint $table) {
            $this->dropTableIndexes($table);
        });

        return $this;
    }

    protected function addSecondaryIndexes(): self
    {
        $this->command->getOutput()->info('Adding secondary indexes...');

        Schema::table($this->getTable(), function(Blueprint $table) {
            $this->addTableIndexes($table);
        });

        return $this;
    }

    protected function loadDatabase(): self
    {
        $this->command->getOutput()->info(sprintf('Loading %s rows into database based on file...', number_format($this->rowsToInsert)));

        $this->command->getOutput()->progressStart($this->rowsToInsert/$this->uniqueRows);

        app('db')->table($this->getTable())->truncate();

        for ($i = 0; $i < $this->rowsToInsert/$this->uniqueRows; $i++) {
            $this->loadFileIntoDatabase();

            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();

        return $this;
    }

    protected function loadFileIntoDatabase(): self
    {
        $options = [
            '--skip-header',
            '--skip-header',
            '--columns "'.join(',', array_keys($this->buildRow())).'"',
            '--connection "host=localhost user='.config('database.connections.pgsql.username').' sslmode=disable password='.config('database.connections.pgsql.password').'"',
            '--db-name '.config('database.connections.pgsql.database'),
            '--table '.$this->getTable(),
            '--file '.$this->file,
            '--workers '.$this->workers,
            '--copy-options "CSV"',
        ];

        shell_exec('timescaledb-parallel-copy '.join(' ', $options));

        return $this;
    }

    protected function getRows(): LazyCollection
    {
        $inserted = 0;

        return LazyCollection::make(function () use (&$inserted) {
            do {
                $this->command->getOutput()->progressAdvance();

                yield $this->buildRow();
            } while (++$inserted < $this->uniqueRows);
        });
    }

    public static function chance(int $chance): bool
    {
        return rand(1, 100) < $chance;
    }

    protected function analyzeTable(): self
    {
        return tap($this, function () {
            app('db')->statement('ANALYZE '.$this->getTable());
        });
    }

    abstract protected function getTable(): string;

    abstract protected function dropTableIndexes(Blueprint $table): void;

    abstract protected function addTableIndexes(Blueprint $table): void;

    abstract protected function buildRow(): array;
}
