<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Genero;
use Faker\Generator as Faker;

$factory->define(Genero::class, function (Faker $faker) {
    return [
       
            'name' => $faker->colorName,
            'is_active' => rand(1,10) % 2 == 0 ? true: false
    ];
});
