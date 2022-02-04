<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $dateFormat = 'Y-m-d H:i:s.u';

    protected static $unguarded = true;

    const UPDATED_AT = null;

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }
}
