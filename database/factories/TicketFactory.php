<?php
/**
 * Date: 2018-03-28
 * Time: 01:17
 */

$factory->define('App\Models\Ticket', function (Faker\Generator $faker) {
    return [
        'email'     => $faker->email,
        'github_id' => $faker->randomNumber(),
    ];
});
