<?php
/**
 * Date: 2018-03-17
 * Time: 00:42
 */

use Faker\Generator as Faker;

$factory->define('App\Models\BackstoryAdjective', function (Faker $faker) {
    return [
        'text' => $faker->words(3, true),
    ];
});
$factory->define('App\Models\BackstoryNationality', function (Faker $faker) {
    return [
        'text' => $faker->words(3, true),
    ];
});
$factory->define('App\Models\BackstorySkill', function (Faker $faker) {
    return [
        'text' => $faker->words(3, true),
    ];
});
$factory->define('App\Models\BackstoryTrait', function (Faker $faker) {
    return [
        'text' => $faker->words(3, true),
    ];
});
