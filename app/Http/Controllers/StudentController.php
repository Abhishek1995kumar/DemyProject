<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Traits\TemplateTrait;
class StudentController extends Controller {
    use TemplateTrait;
    public function index() {
        
    }

    public function store(Request $request) {
        return  $this->storeTemplateNameAndField($request);
    }

    // public function update(Request $request, Student $student) {
        
    // }

}
