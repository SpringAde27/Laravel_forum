<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

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
    $activated = $faker->randomElement([0, 1]);

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => bcrypt('1111'),
        'remember_token' => Str::random(10),
        'activated' => $activated,
        'confirm_code' => $activated ? null : Str::random(60),
    ];
});

$factory->define(App\Article::class, function (Faker $faker) {
    $date = $faker->dateTimeThisMonth;
    $userId = App\User::pluck('id')->toArray();

    return [
        'title' => $faker->sentence(),
        'content' => $faker->paragraph(),
        'user_id' => $faker->randomElement($userId),
        'created_at' => $date,
        'updated_at' => $date,
    ];
});

$factory->define(App\Attachment::class, function (Faker $faker) {
    return [
        'filename' => sprintf("%s.%s",
            Str::random(),
            $faker->randomElement(config('project.mimes'))
        )
    ];
});

$factory->define(App\Comment::class, function (Faker $faker) {
    $articleIds = App\Article::pluck('id')->toArray();
    $userIds = App\User::pluck('id')->toArray();

    return [
        'content' => $faker->paragraph,
        'commentable_type' => App\Article::class,
        'commentable_id' => function () use($faker, $articleIds) {
            return $faker->randomElement($articleIds);
        },
        'user_id' => function () use($faker, $userIds) {
            return $faker->randomElement($userIds);
        },
    ];
});

$factory->define(App\Vote::class, function (Faker $faker) {
    $up = $faker->randomElement([true, false]);
    $down = ! $up;
    $userIds = App\User::pluck('id')->toArray();

    return [
        'up' => $up ? 1 : null,
        'down' => $down ? 1 : null,
        'user_id' => function () use($faker, $userIds) {
            return $faker->randomElement($userIds);
        },
    ];
});
