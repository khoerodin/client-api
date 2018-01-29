<?php

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

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Book::class, function (Faker $faker) {
    return [
        'title'       => ucfirst($faker->words(rand(1, 3), true)),
        'description' => ucfirst($faker->words(rand(1, 5), true)),
    ];
});

$factory->define(App\BookUser::class, function (Faker $faker) {
    return [
        'book_id' => function () {
            return factory(App\Book::class)->create()->id;
        },
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
    ];
});

$factory->define(App\Chapter::class, function (Faker $faker) {
    return [
        'title'   => ucfirst($faker->words(rand(1, 5), true)),
        'content' => $faker->realText(rand(10, 800)),
    ];
});
