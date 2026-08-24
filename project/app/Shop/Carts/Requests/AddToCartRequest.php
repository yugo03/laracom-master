<?php

namespace App\Shop\Carts\Requests;

use App\Shop\Base\BaseFormRequest;
use App\Shop\Products\Product;

class AddToCartRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product' => ['required', 'integer'],
            'quantity' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) {
                    $product = Product::find($this->input('product'));

                    if ($product && $value > $product->quantity) {
                        $fail("There are only {$product->quantity} unit(s) of this product in stock.");
                    }
                }
            ]
        ];
    }
}
