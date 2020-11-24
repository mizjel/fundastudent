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
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('test'),
        'description' => $faker->realText(300),
        'date_of_birth' => $faker->date('Y-m-d'),
        'email_token' => str_random(10),
    ];
});

$factory->define(App\BankAccount::class, function (Faker\Generator $faker) {

    return [
        'status_id' => \App\Status::getStatusID(\App\Status::verified),
        'iban' => $faker->iban('NL'),
    ];
});

$factory->define(App\School::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->word,
        'address' => $faker->address,
        'residence' =>  $faker->word,
        'zip_code' =>  $faker->postcode,
        'phone' =>  $faker->randomNumber(),
    ];
});

$factory->define(App\AcademicYear::class, function (Faker\Generator $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'email_token' => str_random(10),
        'title' => $faker->realText(15),
        'short_description' => $faker->realText(50),
        'full_description' => $faker->paragraphs(20, true),
        'verified' => $faker->boolean(50),
    ];
});

$factory->define(App\AcademicYearGoal::class, function (Faker\Generator $faker) {
    return [
        'description' => $faker->realText(40),
        'amount' => $faker->randomFloat(2,500, 100000),
    ];
});

$factory->define(App\AcademicYearUpdate::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->words(6, true),
        'update' => $faker->paragraphs(10, true),
    ];
});

$factory->define(App\Donation::class, function (Faker\Generator $faker) {
    return [
        'payment_id' => $faker->uuid,
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'amount' => $faker->randomFloat(2, 5, 10000),
        'message' => $faker->realText(25),
        'token' => str_random(10),
        'paid' => $faker->boolean(),
    ];
});