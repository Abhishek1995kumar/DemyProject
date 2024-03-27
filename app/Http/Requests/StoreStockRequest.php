<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreStockRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'product_id' => ['required', 'string', 'exists:products,id'],
            'packaging'  => ['sometimes','required'],
            'quantity'   => ['sometimes','required'],
            'store'      => ['sometimes','required'],
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'status' => false, 
            'message' => $validator->errors()
        ], 422));
    }
}
