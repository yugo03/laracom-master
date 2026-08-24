<?php

namespace App\Shop\Coupons;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public const TYPE_FIXED = 'fixed';
    public const TYPE_PERCENT = 'percent';

    protected $fillable = ['code', 'type', 'value', 'expires_at', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $dates = ['expires_at'];

    /**
     * @return bool
     */
    public function isValid() : bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->expires_at !== null && $this->expires_at->isPast()) {
            return false;
        }

        return true;
    }

    /**
     * @param float $subtotal
     * @return float
     */
    public function calculateDiscount(float $subtotal) : float
    {
        $discount = $this->type === self::TYPE_PERCENT
            ? $subtotal * ($this->value / 100)
            : (float) $this->value;

        return round(min($discount, $subtotal), 2);
    }
}
