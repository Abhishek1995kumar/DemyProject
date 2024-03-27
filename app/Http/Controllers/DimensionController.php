<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Dimension;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreDimensionRequest;
use App\Http\Requests\UpdateDimensionRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
class DimensionController extends Controller {
    public function showProductDimensionApi() {
        
    }

    public function storeProductDimensionApi(StoreDimensionRequest $request) {
        try{
            $productDimension = new Dimension();
            $productDimension->product_id = $request->product_id;
            $productDimension->width      = $request->width;
            $productDimension->heigth     = $request->heigth;
            $productDimension->weigth     = $request->weigth;
            $productDimension->shape      = $request->shape;
            $productDimension->diameter   = $request->diameter;
            $productDimension->sphere     = $request->sphere;
            if(!empty($productDimension)) {
                $productDimension->save();
                return response()->json([
                    'status' => true,
                    'message' => 'Product Dimension Created Successfully',
                    'data' => $productDimension
                ]);
            } else {
                return response()->json([
                 'status' => false,
                 'message' => 'Something went wrong',
                ]);
            }
        } catch(Exception $e){
            Log::info('Add Product Dimension details '. $e->getMessage());
            throw new HttpResponseException (response()->json([
                'status' => false, 
                'message' => 'Error While Adding product Dimension Details'
            ]));
        }
    }

    public function updateProductDimensionApi(UpdateDimensionRequest $request) {
        try{
            $productDimension = Dimension::where('id', $request->id)->first();
            $productDimension->product_id = $request->product_id ?? $productDimension->product_id;
            $productDimension->width      = $request->width ?? $productDimension->width;
            $productDimension->heigth     = $request->heigth ?? $productDimension->heigth;
            $productDimension->weigth     = $request->weigth ?? $productDimension->weigth;
            $productDimension->shape      = $request->shape ?? $productDimension->shape;
            $productDimension->diameter   = $request->diameter ?? $productDimension->diameter;
            $productDimension->sphere     = $request->sphere ?? $productDimension->sphere;
            if(!empty($productDimension)) {
                $productDimension->save();
                return response()->json([
                    'status' => true,
                    'message' => 'Product Dimension Updated Successfully',
                ]);
            } else {
                return response()->json([
                 'status' => false,
                 'message' => 'Something went wrong',
                ]);
            }
        } catch(Exception $e){
            Log::info('Add product Dimension details '. $e->getMessage());
            throw new HttpResponseException (response()->json([
                'status' => false, 
                'message' => 'Error While Adding product Dimension Details'
            ]));
        }
    }

    public function deleteProductDimensionApi(Request $request) {
        try{
            $productDimensionDetails = Dimension::where('id', $request->id)->first();
            if(!empty($productDimensionDetails)) {
                $productDimensionDetails->delete();
                if($productDimensionDetails->deleted_at != null) { 
                    $productDimensionDetails->update(['status' => 2]);
                }
                return response()->json([
                  'status' => true,
                  'message' => 'Product Dimension deleted successfully',
                ]);
            } else {
                return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                ]);
            }
        } catch(Exception $e) {
            Log::info('Add Product Dimension details '. $e->getMessage());
            throw new HttpResponseException (response()->json([
               'status' => false, 
               'message' => 'Error while deleting Product Dimension details'
            ]));
        }
    }

    public function restoreProductDimensionDetailsApi(Request $request) {
        try {
            $restoreproductDimension = Dimension::withTrashed()->where('id', $request->id)->first();
            if(!empty($restoreproductDimension)) {
                $restoreproductDimension->restore();
                if($restoreproductDimension->deleted_at == NULL) {
                    $restoreproductDimension->update(['status' => 1]);
                }
                return response()->json([
                 'status' => true,
                 'message' => 'Product Dimension restored successfully',
                 'data' => $restoreproductDimension
                ]);
            }
        } catch(Exception $e) {
            Log::info('Add Product Dimension details '. $e->getMessage());
            throw new HttpResponseException (response()->json([
              'status' => false, 
              'message' => 'Error While Restoring Product Dimension Details'
            ]));
        }
    }

}
