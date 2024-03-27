<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            // 'tax'           =>['required', 'string'],
            // 'category_name' =>['required', 'string'],
            // 'category_slug' =>['required', 'string'],
            // 'category_image'=>['sometimes', 'required'],
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'status' => false, 
            'message' => $validator->errors()
        ], 422));
    }
}
