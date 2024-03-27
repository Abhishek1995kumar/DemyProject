<?php

namespace App\Http\Controllers;


use Exception;
use Illuminate\Http\Request;
use App\Models\ProductBrand;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreProductBrandRequest;
use App\Http\Requests\UpdateProductBrandRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductBrandController extends Controller {
    public function showProductBrandApi(ProductBrand $productBrand) {
        
    }

    public function storeProductBrandApi(StoreProductBrandRequest $request) {
        // try{
            $productBrand = new ProductBrand();
            $productBrand->brand_name = $request->brand_name;
            $productBrand->description = $request->description;
            if(!empty($productBrand)) {
                $productBrand->save();
                return response()->json([
                    'status' => true,
                    'message' => 'Product brand Created Successfully',
                    'data' => $productBrand
                ]);
            } else {
                return response()->json([
                 'status' => false,
                 'message' => 'Something went wrong',
                ]);
            }
        // } catch(Exception $e){
        //     Log::info('Add Product brand details '. $e->getMessage());
        //     throw new HttpResponseException (response()->json([
        //         'status' => false, 
        //         'message' => 'Error While Adding product brand Details'
        //     ]));
        // }
    }

    public function updateProductBrandApi(UpdateProductBrandRequest $request, ProductBrand $productBrand) {
        try{
            $productBrand = ProductBrand::where('id', $request->id)->first();
            $productBrand->brand_name = $request->brand_name ?? $productBrand->brand_name;
            $productBrand->description = $request->description ?? $productBrand->description;
            if(!empty($productBrand)) {
                $productBrand->save();
                return response()->json([
                    'status' => true,
                    'message' => 'Product brand Updated Successfully',
                ]);
            } else {
                return response()->json([
                 'status' => false,
                 'message' => 'Something went wrong',
                ]);
            }
        } catch(Exception $e){
            Log::info('Add product brand details '. $e->getMessage());
            throw new HttpResponseException (response()->json([
                'status' => false, 
                'message' => 'Error While Adding product brand Details'
            ]));
        }
    }

    public function deleteProductBrandApi(Request $request) {
        try{
            $productBrandDetails = ProductBrand::where('id', $request->id)->first();
            if(!empty($productBrandDetails)) {
                $productBrandDetails->delete();
                if($productBrandDetails->deleted_at != null) { 
                    $productBrandDetails->update(['status' => 2]);
                }
                return response()->json([
                  'status' => true,
                  'message' => 'Product brand deleted successfully',
                ]);
            } else {
                return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                ]);
            }
        } catch(Exception $e) {
            Log::info('Add Product brand details '. $e->getMessage());
            throw new HttpResponseException (response()->json([
               'status' => false, 
               'message' => 'Error while deleting Product brand details'
            ]));
        }
    }

    public function restoreCategoryDetailsApi(Request $request) {
        try {
            $restoreproductBrand = ProductBrand::withTrashed()->where('id', $request->id)->first();
            if(!empty($restoreproductBrand)) {
                $restoreproductBrand->restore();
                if($restoreproductBrand->deleted_at == NULL) {
                    $restoreproductBrand->update(['status' => 1]);
                }
                return response()->json([
                 'status' => true,
                 'message' => 'Product brand restored successfully',
                 'data' => $restoreproductBrand
                ]);
            }
        } catch(Exception $e) {
            Log::info('Add Product brand details '. $e->getMessage());
            throw new HttpResponseException (response()->json([
              'status' => false, 
              'message' => 'Error While Restoring Product brand Details'
            ]));
        }
    }

}
