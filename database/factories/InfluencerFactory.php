<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Influencer::class, function (Faker $faker) {
    $createdAt = $faker->dateTimeBetween('-1 year');

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'status' => $faker->randomElement([0,1]),
        'created_at' => $createdAt,
        'updated_at' => $createdAt,
    ];
});
