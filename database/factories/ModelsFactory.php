<?php

use Faker\Generator as Faker;

$factory->define(App\Movie::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'director' => $faker->name,
        'image_url' => $faker->imageUrl,
        'duration' => $faker->biasedNumberBetween($min = 1, $max = 4),
        // 'release_date' => $faker->dateTimeThisCentury($max = 'now', $timezone = date_default_timezone_get()),
        'release_date' => $faker->dateTime(),
        'genres' => $faker->words
    ];
});
