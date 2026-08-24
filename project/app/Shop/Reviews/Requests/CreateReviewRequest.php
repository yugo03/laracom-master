<?php

namespace App\Shop\Reviews\Requests;

use App\Shop\Base\BaseFormRequest;

class CreateReviewRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'rating' => ['required', 'in:up,down'],
            'comment' => ['required', 'string', 'max:1000'],
        ];
    }
}
