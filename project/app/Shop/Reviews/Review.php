<?php

namespace App\Shop\Reviews;

use App\Shop\Customers\Customer;
use App\Shop\Products\Product;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public const RATING_UP = 'up';
    public const RATING_DOWN = 'down';

    protected $fillable = ['product_id', 'customer_id', 'rating', 'comment'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
