<?php

namespace App\Shop\Products\Certificates;

use App\Shop\Products\Product;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'product_id',
        'appraiser_name',
        'grade',
        'serial_number',
        'appraised_at',
        'notes',
        'file',
    ];

    protected $dates = ['appraised_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
