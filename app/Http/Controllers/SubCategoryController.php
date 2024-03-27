<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreSubCategoryRequest;
use App\Http\Requests\UpdateSubCategoryRequest;
use App\Http\Resources\SubCategoryNameResource;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
class SubCategoryController extends Controller {
    public function showSubCategoryDetails(SubCategory $subCategory) {
        
    }
    public function storeSubCategoryApi(StoreSubCategoryRequest $request) {
        try{
            // $category = Category::first(); // ye tab use karenge jab request se category_id aur category table ki id same ho tab
            $subCategory = new SubCategory();
            // if($request->category_id == $category->id){
                $subCategory->category_id = $request->category_id;
                $subCategory->sub_category_name = $request->sub_category_name;
                $subCategory->sub_category_slug = $request->sub_category_slug;
                if ($request->hasFile('sub_category_image')) {
                    $file = $request->file('sub_category_image');
                    if ($file->isValid()) {
                        $photo_name = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('assets/images/categories'), $photo_name);
                        $subCategory->sub_category_image = $photo_name;
                    } else {
                        return redirect()->back()->with('message', 'File upload failed.');
                    }
                } else {
                    return redirect()->back()->with('message', 'No file uploaded.');
                }
    
                if(!empty($subCategory)) {
                    $subCategory->save();
                    return response()->json([
                        'status' => true,
                        'message' => 'Sub Category Created Successfully',
                        'data' => new SubCategoryNameResource($subCategory)
                    ]);
                } else {
                    return response()->json([
                     'status' => false,
                     'message' => 'Something went wrong',
                    ]);
                }
            // } else {
            //     return response()->json([
            //      'status' => false,
            //      'message' => 'Invalid Category Id',
            //     ]);
            // }
            
        } catch (Exception $e){
            Log::info('Add category details '. $e->getMessage());
            throw new HttpResponseException (response()->json([
              'status' => false, 
              'message' => 'Error While Store Sub Category Details'
            ]));
        }
    }

    public function updateSubCategoryApi(UpdateSubCategoryRequest $request, SubCategory $subCategory) {
        try{
            $subCategory = SubCategory::where('id', $request->id)->first();
            $subCategory->category_id = $request->category_id ?? $subCategory->category_id;
            $subCategory->sub_category_name = $request->sub_category_name ?? $subCategory->sub_category_name;
            $subCategory->sub_category_slug = $request->sub_category_slug ?? $subCategory->sub_category_slug;

            if ($request->hasFile('sub_category_image')) {
                $file = $request->file('sub_category_image');
                if ($file->isValid()) {
                    if ($subCategory->sub_category_image) {
                        Storage::delete($subCategory->sub_category_image);
                    }
                    $photo_name = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('assets/images/categories'), $photo_name);
                    $subCategory->sub_category_image = $photo_name;
                } else {
                    return response()->json([
                        'status' => false,
                        'message', 'File upload failed.'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message', 'No file uploaded'
                ]);
            }

            if(!empty($subCategory)) {
                $subCategory->save();
                return response()->json([
                    'status' => true,
                    'message' => 'Sub Category Created Successfully',
                    'data' => new SubCategoryNameResource($subCategory)
                ]);
            } else {
                return response()->json([
                 'status' => false,
                 'message' => 'Something went wrong',
                ]);
            }
        } catch (Exception $e){
            Log::info('Add category details '. $e->getMessage());
            throw new HttpResponseException (response()->json([
              'status' => false, 
              'message' => 'Error While Store Sub Category Details'
            ]));
        }
    }

    public function deleteSubCategoryApi(Request $request) {
        try{
            $subCategoryDetails = SubCategory::where('id', $request->id)->first();
            if(!empty($subCategoryDetails)) {
                if ($subCategoryDetails->sub_category_image) {
                    Storage::delete($subCategoryDetails->sub_category_image);
                }
                $subCategoryDetails->delete();
                if($subCategoryDetails->deleted_at != null) { 
                    $subCategoryDetails->update(['status' => 2]);
                }
                return response()->json([
                  'status' => true,
                  'message' => 'Sub category deleted successfully',
                  'data' => $subCategoryDetails,
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
               'message' => 'Error while deleting sub category details'
            ]));
        }
    }
    public function restoreSubCategoryApi(Request $request) {
        try {
            $restoreSubCategory = SubCategory::withTrashed()->where('id', $request->id)->first();
            if(!empty($restoreSubCategory)) {
                $restoreSubCategory->restore();
                if($restoreSubCategory->deleted_at == NULL) {
                    $restoreSubCategory->update(['status' => 1]);
                }
                return response()->json([
                 'status' => true,
                 'message' => 'Category restored successfully',
                 'data' => $restoreSubCategory
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
