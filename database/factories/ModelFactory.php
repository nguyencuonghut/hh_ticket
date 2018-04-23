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

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'address' => $faker->secondaryAddress(),
        'work_number' => $faker->randomNumber(8),
        'personal_number' => $faker->randomNumber(8),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Client::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'vat' => $faker->randomNumber(8),
        'company_name' => $faker->company(),
        'address' => $faker->secondaryAddress(),
        'city' => $faker->city(),
        'zipcode' => $faker->postcode(),
        'primary_number' => $faker->randomNumber(8),
        'secondary_number' => $faker->randomNumber(8),
        'industry_id' => $faker->numberBetween($min = 1, $max = 25),
        'user_id' => $faker->numberBetween($min = 1, $max = 3),
        'company_type' => 'ApS',
    ];
});



$factory->define(App\Models\Task::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'user_created_id' => $faker->numberBetween($min = 1, $max = 3),
        'user_assigned_id' => $faker->numberBetween($min = 1, $max = 3),
        'client_id' => $faker->numberBetween($min = 1, $max = 50),
        'status' => $faker->numberBetween($min = 1, $max = 2),
        'deadline' => $faker->dateTimeThisYear($max = 'now'),
        'created_at' => $faker->dateTimeThisYear($max = 'now'),
        'updated_at' => $faker->dateTimeThisYear($max = 'now'),
    ];
});

$factory->define(App\Models\Lead::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'user_created_id' => $faker->numberBetween($min = 1, $max = 3),
        'user_assigned_id' => $faker->numberBetween($min = 1, $max = 3),
        'client_id' => $faker->numberBetween($min = 1, $max = 50),
        'status' => $faker->numberBetween($min = 1, $max = 2),
        'contact_date' => $faker->dateTimeThisYear($max = 'now'),
        'created_at' => $faker->dateTimeThisYear($max = 'now'),
        'updated_at' => $faker->dateTimeThisYear($max = 'now'),
    ];
});

$factory->define(App\Models\Ticket::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence,
        'deadline' => $faker->dateTimeThisYear($max = 'now'),
        'source_id' => $faker->numberBetween($min = 1, $max = 4),
        'what' => $faker->sentence,
        'why' => $faker->sentence,
        'when' => $faker->dateTimeThisYear($max = 'now'),
        'who' => $faker->name,
        'where' => $faker->city,
        'how_1' => $faker->sentence,
        'how_2' => $faker->sentence,
        'ticket_status_id' =>$faker->numberBetween($min = 1, $max = 2),
        'created_at' => $faker->dateTimeBetween($startDate = '-3 months', $endDate = 'now'),
        'updated_at' => $faker->dateTimeBetween($startDate = '-3 months', $endDate = 'now'),
        'creator_id' => $faker->numberBetween($min = 1, $max = 10),
        'department_id' => $faker->numberBetween($min = 1, $max = 10),
        'root_cause_type_id' => $faker->numberBetween($min = 1, $max = 6),
        'effectiveness_id' => $faker->numberBetween($min = 1, $max = 3),
    ];
});
