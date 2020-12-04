<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Job;
use App\JobApplication;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('secret'), // password
        'type' => $faker->randomElement([User::STUDENT, User::EMPLOYER]),
        'verified' => $faker->randomElement([User::VERIFIED, User::UNVERIFIED]),
        'verification_token' => 'token'
    ];
});

$factory->define(Job::class, function (Faker $faker) {
    $employer = User::all()->where('type',User::EMPLOYER)->random();
    return [
        'title' => $faker->word,
        'description' => $faker->paragraph(1),
        'category' => $faker->randomElement(['Turizam','Fizički posao', 'Ljepota i njega', 'Ostalo']),
        'city' => $faker->randomElement(['Osijek', 'Zagreb', 'Rijeka']),
        'wage' => $faker->numberBetween(25,50),
        'requirements'=> $faker->paragraph(1),
        'user_id'=> $employer->id,
        'employer' => $faker->word,
        'notes' => $faker->paragraph(1)

    ];
});

$factory->define(JobApplication::class, function (Faker $faker) {
    $student = User::all()->where('type',User::STUDENT)->random();
    return [
        'user_id'=> $student->id,
        'job_id' => Job::all()->random()->id,
        'about_me' =>$faker->paragraph(2),
        'email' => $faker->email,
        'phone' =>$faker->phoneNumber
    ];
});




