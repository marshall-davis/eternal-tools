<?php
/**
 * Date: 2018-03-20
 * Time: 00:12
 */

use Faker\Generator as Faker;

$factory->define('App\Models\Map', function (Faker $faker) {
    return [
        'steps' => "[{\"position\":{\"x\":479,\"y\":279},\"size\":8,\"color\":\"#008000\"},{\"position\":{\"x\":475,\"y\":263},\"size\":8,\"color\":\"#008000\"}]"
    ];
});
