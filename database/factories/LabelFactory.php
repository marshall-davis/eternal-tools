<?php
/**
 * Date: 2018-03-28
 * Time: 01:09
 */

$factory->define('App\Models\Label', function (Faker\Generator $faker) {
    return [
        'name'        => $faker->word,
        'description' => $faker->words(3, true),
    ];
});
