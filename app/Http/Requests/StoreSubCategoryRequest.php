<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreSubCategoryRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'category_id'       =>['required', 'numeric', 'exists:categories,id'],
            'sub_category_name' =>['required', 'string'],
            'sub_category_slug' =>['required', 'string'],
            'sub_category_image'=>['sometimes', 'required'],
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'status' => false, 
            'message' => $validator->errors()
        ], 422));
    }
}
