<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserDetailsRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'username' =>'string|min:5|max:255',
            'type_id' =>'required|numeric|max:10',
        ];
    }
}
