<?php

namespace App\Shop\Coupons\Requests;

use App\Shop\Base\BaseFormRequest;
use Illuminate\Validation\Rule;

class UpdateCouponRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => ['required', 'string', 'max:50', Rule::unique('coupons', 'code')->ignore(request()->segment(3))],
            'type' => ['required', 'in:fixed,percent'],
            'value' => ['required', 'numeric', 'min:0', 'max:1000000'],
            'expires_at' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
