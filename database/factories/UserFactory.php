<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/


//función para generar valores en la tabla de usuarios
$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => Str::random(10),
        //revisar documentacion de laravle, el primer valor asigna la cantidad de dígitos 
        //y el segundo confirma si es necesario que se cumpla la cantidad de dígitos
        'dni' => $faker->randomNumber(8, true),
        'address' => $faker->address,
        'phone' => $faker->e164PhoneNumber,
        'role' => $faker->randomElement(['patient', 'doctor'])
    ];
});

$factory->state(App\User::class, 'patient', [
    'role' => 'patient',
]);

$factory->state(App\User::class, 'doctor', [
    'role' => 'doctor',
]);