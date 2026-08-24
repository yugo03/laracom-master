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

use App\Shop\Products\Product;
use App\Shop\Customers\Customer;
use App\Shop\Reviews\Review;

$factory->define(Review::class, function (Faker\Generator $faker) {

    return [
        'product_id' => function () {
            return factory(Product::class)->create()->id;
        },
        'customer_id' => function () {
            return factory(Customer::class)->create()->id;
        },
        'rating' => Review::RATING_UP,
        'comment' => $faker->paragraph,
    ];
});
