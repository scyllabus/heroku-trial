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
   	$firstname = $faker->firstname();
    return [
        'first_name' => $firstname, //$faker->firstName(),
        'last_name' => $faker->lastName(),
        'contact' => $faker->numerify('##########'),
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'account_type' => $faker->randomElement(['admin','student','instructor']),
        'remember_token' => str_random(10),
    ];
});
