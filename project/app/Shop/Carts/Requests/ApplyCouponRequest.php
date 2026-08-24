<?php

namespace App\Shop\Carts\Requests;

use App\Shop\Base\BaseFormRequest;

class ApplyCouponRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => ['required', 'string', 'max:50']
        ];
    }
}
