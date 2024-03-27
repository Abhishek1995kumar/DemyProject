<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreDimensionRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'product_id'=>['required', 'numeric', 'exists:products,id'],
            'width'     =>['required'],
            'heigth'    =>['required'],
            'weigth'    =>['sometimes', 'required'],
            'shape'     =>['sometimes', 'required'],
            'diameter'  =>['sometimes', 'required'],
            'sphere'    =>['sometimes', 'required'],
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'status' => false, 
            'message' => $validator->errors()
        ], 422));
    }
}
