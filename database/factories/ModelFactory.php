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
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt('heslo'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Task::class, function (Faker\Generator $faker) {
    $date = $faker->dateTimeBetween($startDate = 'now', $endDate = '+5 months');
    return [
        'name' => $faker->sentence(6),
        'description' => $faker->paragraph(10),
        'deadline' => date_format($faker->dateTimeBetween($startDate = 'now', $endDate = '+5 months'), 'd. m. Y'),
        'ordered_by' => 1,//factory(App\User::class)->create()->id,
        'accomplish_date' =>
            $date < new Carbon\Carbon('+2 months') ? $date : null
    ];
});
