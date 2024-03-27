<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreProductAttributeRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'product_id'      => ['required', 'string', 'exists:products,id'],
            'color_name '     => ['required', 'string'],
            'color_code'      => ['required', 'string'],
            'product_video'   => ['sometimes','required'],
            'attribute_image' => ['sometimes','required'],
            'feature_image'   => ['sometimes','required'],
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'status' => false, 
            'message' => $validator->errors()
        ], 422));
    }
}
