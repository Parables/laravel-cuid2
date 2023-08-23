<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Tests\Fixtures\CuidRouteBoundPost;
use Tests\Fixtures\CustomCastCuidPost;
use Tests\Fixtures\MultipleCuidPost;
use Tests\Fixtures\CustomCuidPost;
use Tests\Fixtures\CustomCuidRouteBoundPost;
use Tests\Fixtures\MultipleCuidRouteBoundPost;
use Tests\Fixtures\Post;
use Visus\Cuid2\Cuid2;

$factory->define(CustomCastCuidPost::class, function (Faker $faker) {
    return [
        'custom_cuid' => (new Cuid2())->toString(),
        'title' => $faker->sentence,
    ];
});

$factory->define(CustomCuidPost::class, function (Faker $faker) {
    return [
        'custom_cuid' => (new Cuid2())->toString(),
        'title' => $faker->sentence,
    ];
});

$factory->define(MultipleCuidPost::class, function (Faker $faker) {
    return [
        'cuid' => (new Cuid2())->toString(),
        'custom_cuid' => (new Cuid2())->toString(),
        'title' => $faker->sentence,
    ];
});

$factory->define(Post::class, function (Faker $faker) {
    return [
        'cuid' => (new Cuid2())->toString(),
        'title' => $faker->sentence,
    ];
});

$factory->define(CustomCuidRouteBoundPost::class, function (Faker $faker) {
    return [
        'cuid' => (new Cuid2())->toString(),
        'custom_cuid' => (new Cuid2())->toString(),
        'title' => $faker->sentence,
    ];
});

$factory->define(CuidRouteBoundPost::class, function (Faker $faker) {
    return [
        'cuid' => (new Cuid2())->toString(),
        'custom_cuid' => (new Cuid2())->toString(),
        'title' => $faker->sentence,
    ];
});

$factory->define(MultipleCuidRouteBoundPost::class, function (Faker $faker) {
    return [
        'cuid' => (new Cuid2())->toString(),
        'custom_cuid' => (new Cuid2())->toString(),
        'title' => $faker->sentence,
    ];
});
