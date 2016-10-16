<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Stats::class, function (Faker\Generator $faker) {

    $min = $faker->numberBetween(0,1000);
    $max = $faker->numberBetween($min,60000);
    return [
        'date' => $faker->date(),
        'min' => $min,
        'max' => $faker->numberBetween($min,60000),
        'avg' => function() use ($faker,$min,$max){
            $array[0] = $faker->numberBetween($min,$max);
            $array[1] = $faker->numberBetween($min,$max);
            $array[2] = $faker->numberBetween($min,$max);
            $array[3] = $faker->numberBetween($min,$max);
            return json_encode($array);
        }
    ];
});
