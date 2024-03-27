<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreProductRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'type_id'         => ['required', 'integer'],
            'category_id'     => ['required', 'string', 'exists:categories,id'],
            'sub_category_id' => ['required', 'string', 'exists:sub_categories,id'],
            'brand_id'        => ['required', 'string', 'exists:product_brands,id'],
            'city_id'         => ['required', 'string', 'exists:cities,id'],
            'state_id'        => ['required', 'string', 'exists:states,id'],
            'country_id'      => ['required', 'string', 'exists:countries,id'],
            // 'product_sku '    => ['required', 'string'],
            'entry_by'        => ['required', 'string'],
            'product_price'   => ['required', 'numeric'],
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'status' => false, 
            'message' => $validator->errors()
        ], 422));
    }
}
