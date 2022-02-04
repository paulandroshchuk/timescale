<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriberFactory extends Factory
{
    public function definition()
    {
        return [
            'account_id' => rand(1, 5_000),
            'mobile_id' => rand(1, 2_000_000),
            'name' => $this->faker->name,
        ];
    }
}
