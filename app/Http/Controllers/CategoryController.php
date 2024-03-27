<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Traits\CategoryTrait;
use Illuminate\Support\Str;
use Exception;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Exceptions\HttpResponseException;
class CategoryController extends Controller {
    // use CategoryTrait;
    // public function createCategoryDetails(Request $request) {
    //     try{
    //         return createCategory($request);
    //     } catch(Exception $e){

    //     }
    // }


    public function createCategoryApi(StoreCategoryRequest $request) {
        try{
            $category = new Category();
            $category->category_name = $request->category_name;
            $category->category_slug = $request->category_slug;
            $category->tax = $request->tax;

            if ($request->hasFile('category_image')) {
                $file = $request->file('category_image');
                if ($file->isValid()) {
                    $photo_name = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('assets/images/categories'), $photo_name);
                    $category->category_image = $photo_name;
                } else {
                    return response()->json([
                        'status' => false,
                        'message', 'File upload failed.'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message', 'No file uploaded.'
                ]);
            }

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


    public function updateCategoryApi(UpdateCategoryRequest $request) {
        try{
            $category = Category::where('id', $request->id)->first();
            $category->category_name = $request->category_name ? $request->category_name : $category->category_name;
            $category->category_slug = $request->category_slug ?? $category->category_slug;
            $category->tax = $request->tax ?? $category->tax;
            if(!empty($request->category_image)) {
                $file = $request->file('category_image');
                if ($file->isValid()) {
                    if ($category->category_image) {
                        Storage::delete($category->category_image);
                    }
                    $photo_name = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('assets/images/categories'), $photo_name);
                    $category->category_image = $photo_name;
                } else {
                    return response()->json([
                        'status' => false,
                        'message', 'File upload failed.'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message', 'File upload failed.'
                ]);
            }
            
            $category->save();
            if(!empty($category)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Category Updated Successfully',
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


    public function deleteCategoryApi(Request $request) {
        try{
            $categoryDetails = Category::where('id', $request->id)->first();
            if(!empty($categoryDetails)) {
                if ($categoryDetails->category_image) {
                    Storage::delete($categoryDetails->category_image);
                }
                $categoryDetails->delete();
                if($categoryDetails->deleted_at != null) { 
                    $categoryDetails->update(['status' => 2]);
                }
                return response()->json([
                  'status' => true,
                  'message' => 'Category deleted successfully',
                ]);
            } else {
                return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                ]);
            }
        } catch(Exception $e) {
            Log::info('Add category details '. $e->getMessage());
            throw new HttpResponseException (response()->json([
               'status' => false, 
               'message' => 'Error while deleting category details'
            ]));
        }
    }

    public function restoreCategoryDetailsApi(Request $request) {
        try {
            $restoreCategory = Category::withTrashed()->where('id', $request->id)->first();
            if(!empty($restoreCategory)) {
                $restoreCategory->restore();
                if($restoreCategory->deleted_at == NULL) {
                    $restoreCategory->update(['status' => 1]);
                }
                return response()->json([
                 'status' => true,
                 'message' => 'Category restored successfully',
                ]);
            }
        } catch(Exception $e) {
            Log::info('Add category details '. $e->getMessage());
            throw new HttpResponseException (response()->json([
              'status' => false, 
              'message' => 'Error While Restoring Category Details'
            ]));
        }
    }

}
