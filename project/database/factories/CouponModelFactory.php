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

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Shop\Coupons\Coupon;

$factory->define(Coupon::class, function (Faker\Generator $faker) {

    return [
        'code' => strtoupper($faker->unique()->bothify('COUPON###')),
        'type' => Coupon::TYPE_FIXED,
        'value' => 10,
        'expires_at' => null,
        'is_active' => true,
    ];
});
