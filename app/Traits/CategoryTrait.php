<?php

use Exception;
use App\Models\Admin;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

trait CategoryTrait {
    public function index() {
        
    }

    public function createCategory(StoreCategoryRequest $request) {
        try{
            $category = new Category();
            $category->category_name = $request->category_name;
            $category->category_slug = $request->category_slug;
            $category->category_image = $request->category_image;
            $category->tax = $request->tax;
            $category->save();
            if(!empty($category)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Category Created Successfully',
                ]);
            } else {
                return response()->json([
                 'status' => false,
                 'message' => 'Something went wrong',
                ]);
            }
        } catch(Exception $e){
            Log::info('Add category details '. $e->getMessage());
            throw new HttpResponseException (response()->json([
                'status' => false, 
                'message' => 'Error While Adding Category Details'
            ]));
        }
    }

    public function edit(Admin $admin) {

    }

    public function destroy(Admin $admin) {
        
    }
}
