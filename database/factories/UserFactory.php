<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use App\Consulta;
use App\Sector;
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

/*$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});*/

$factory->define(Consulta::class,function (Faker $faker) {
    //$sectores = Sector::all()->random(); 
    return [
        'sector_id' => $faker->numberBetween(1,3),
        'numero_consulta' => $faker->numberBetween(1,1000),
        'tema' => $faker->word,
        'descripcion' => $faker->paragraph(1),
        'palabras_clave' => $faker->word,
        'ejercicio' => $faker->numberBetween(2010,2021),
        'word' => 'prueba.docx',
        'pdf' => 'prueba.pdf',
        //'estatus' => $faker->numberBetween(0,1),
        'estatus' => 1,
    ];
});
