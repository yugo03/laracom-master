<?php

namespace App\Shop\Carts\Requests;

use App\Shop\Base\BaseFormRequest;
use App\Shop\Products\Product;
use Gloudemans\Shoppingcart\Exceptions\InvalidRowIDException;
use Gloudemans\Shoppingcart\Facades\Cart;

class UpdateCartRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'quantity' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) {
                    try {
                        $item = Cart::get($this->route('cart'));
                    } catch (InvalidRowIDException $e) {
                        return;
                    }

                    $product = Product::find($item->id);

                    if ($product && $value > $product->quantity) {
                        $fail("There are only {$product->quantity} unit(s) of this product in stock.");
                    }
                }
            ]
        ];
    }
}
