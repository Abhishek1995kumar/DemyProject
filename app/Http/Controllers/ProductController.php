<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Stock;
use App\Models\Product;
use App\Jobs\AutherJob;
use App\Models\Dimension;
use Illuminate\Http\Request;
use App\Jobs\AuthorDetailJob;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Resources\ProductResource;
use App\Models\Author;
use Illuminate\Support\Facades\DB;
class ProductController extends Controller {
    public function showProduct(Request $request) {
        $rules = [
            'product_min_price' => 'required|numeric|min:0',
            'product_max_price' => 'required|numeric|min:0|gt:product_min_price',
        ];
        $message = [
            'product_max_price.gt' => 'The maximum product price must be greater than the minimum product price.',
        ];
        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $categoryDetails = Product::when($request->has('category_id'), function ($query) use ($request) {
                                $query->whereHas('category', function ($q) use ($request) {
                                    $q->where('id', $request->category_id);
                                });
                            })->with('category.subCategory')

                            ->when($request->has('product_min_price','product_max_price'), function ($query) use ($request) {
                                if($request->product_max_price > $request->product_min_price) {
                                    $query->whereBetween('product_price', [$request->product_min_price, $request->product_max_price]);
                                }                       
                            })
                            // ->with('category:id,category_name,category_slug', 'category.subCategory:id,category_id,sub_category_name,sub_category_slug')
                            ->when($request->has('sub_category_id'), function ($query) use ($request) {
                                $query->whereHas('subCategory', function ($q) use ($request) {
                                    $q->where('sub_category_id', $request->sub_category_id);
                                });
                            })
                            // ->with('subCategory:id,category_id,sub_category_name,sub_category_slug', 'subCategory.categorySub:id,category_name,category_slug,tax')
                            ->with('subCategory.categorySub')

                            ->when($request->has('brand_id'), function($query) use ($request) {
                                $query->where('brand_id', $request->brand_id);
                            })
                            // ->with('brand:id,brand_name,description')
                            ->with('brand')

                            ->when($request->has('stock'), function($query) use ($request) {
                                $query->whereHas('stocks', function($row) use ($request) {
                                    // $row->where('total_product_quantity', '>', 0);
                                    if($request->stock > 0) {
                                        $row->where('total_product_quantity', $request->stock);
                                    } else {
                                        $row->where('total_product_quantity', $request->stock); 
                                    }
                                });
                            })->with('stocks')->get();
        return $categoryDetails;
        return response()->json([
            'status' => 'success',
            // 'message' => 'Product was successfully fetched',
            'data' => ProductResource::collection($categoryDetails)
        ]);
    }


    public function storeProduct(StoreProductRequest $request) {
        if($request->type_id == Product::SINGLE_UPLOAD) {
            try {
                $product = new Product();
                $product->category_id           = $request->category_id;
                $product->sub_category_id       = $request->sub_category_id;
                $product->brand_id              = $request->brand_id;
                $product->product_title         = $request->product_title;
                $product->product_sku           = $request->product_sku;
                $product->stock                 = $request->stock;
                $product->entry_by              = $request->entry_by;
                $product->warrenty_type         = $request->warrenty_type ?? NULL;
                $product->product_manufracturer = $request->product_manufracturer ?? NULL;
                $product->product_description   = $request->product_description ?? NULL;
                $product->product_quantity      = $request->product_quantity;
                $product->usagesduration        = $request->usagesduration ?? NULL;
                $product->product_notes         = $request->product_notes ?? NULL;
                $product->product_discount      = $request->product_discount ?? NULL;
                $product->product_material      = $request->product_material ?? NULL;
                $product->product_price         = $request->product_price;
                $product->city_id               = $request->city_id ?? NULL;
                $product->state_id              = $request->state_id ?? NULL;
                $product->country_id            = $request->country_id ?? NULL;

                if(!empty($product)) {
                    $product->save();
                }

                if($product->id) {
                    try{
                        $productDimension = new Dimension();
                        $productDimension->product_id = $product->id;
                        $productDimension->width = $request->width ? $request->width : NULL;
                        $productDimension->heigth = $request->heigth ? $request->heigth : NULL;
                        $productDimension->weigth = $request->weigth ? $request->weigth : NULL;
                        $productDimension->shape = $request->shape ? $request->shape : NULL;
                        $productDimension->diameter = $request->diameter ? $request->diameter : NULL;
                        $productDimension->sphere = $request->sphere ? $request->sphere : NULL;

                        if(!empty($productDimension)) {
                            $productDimension->save();
                        }
                    } catch (Exception $e) {
                        Log::error($e->getMessage());
                        throw new Exception($e->getMessage());
                    }

                    try{
                        $productStock = new Stock();
                        $productStock->product_id = $product->id;
                        $productStock->total_product_quantity = $product->stock ?? NULL;
                        if($product->stock > 0){
                            $productStock->active_product = "product stock is available";
                            $productStock->status = 1;

                        } 
                        if($product->stock == 0) {
                            $productStock->inactive_product = "product stock is not available";
                            $productStock->status = 2;

                        }
                        if(!empty($productStock)){
                            $productStock->save(); 
                        }

                    } catch (Exception $e) {
                        Log::error($e->getMessage());
                        throw new Exception($e->getMessage());
                    }

                    try{
                        $productAttribute = new ProductAttribute();
                        $productAttribute->product_id = $product->id;
                        $productAttribute->color_name = $request->color_name ?? NULL;
                        $productAttribute->color_code = $request->color_code ?? NULL;
                        $productAttribute->product_video = $request->product_video ?? NULL;

                        if($request->hasFile('attribute_image')) {
                            $image = $request->file('attribute_image');
                            // foreach($images as $image) {
                                $imageName = time().'.'.$image->getClientOriginalExtension();
                                $image->move(public_path('assets/images/product/attribute/attribute_image'), $imageName);
                                $productAttribute->attribute_image = $imageName;
                            // }
                        }

                        if($request->hasFile('feature_image')) {
                            $image = $request->file('feature_image');
                            // foreach($images as $image) {
                                $imageName = time().'.'.$image->getClientOriginalExtension();
                                $image->move(public_path('assets/images/product/attribute/feature_image'), $imageName);
                                $productAttribute->feature_image = $imageName;
                            // }
                        }

                        if($request->hasFile('product_video')) {
                            $image = $request->file('product_video');
                            // foreach($images as $image) {
                                $imageName = time().'.'.$image->getClientOriginalExtension();
                                $image->move(public_path('assets/images/product/attribute/feature_image'), $imageName);
                                $productAttribute->product_video = $imageName;
                            // }
                        }

                        if(!empty($productAttribute)) {
                            $productAttribute->save();
                        }

                    } catch (Exception $e) {
                        Log::error($e->getMessage());
                        throw new Exception($e->getMessage());
                    }
                }
                return response()->json([
                    'status' => true,
                    'message' => 'Product Created Successfully',
                ]);

            } catch (Exception $e) { 
                Log::info('Add Product details '. $e->getMessage());
                throw new HttpResponseException (response()->json([
                    'status' => false, 
                    'message' => 'Error While Adding product'
                ]));
            }

        } elseif($request->type_id == Product::BULK_UPLOAD) {
            try{


            } catch (Exception $e) {
                Log::info('Add Product details '. $e->getMessage());
                throw new HttpResponseException (response()->json([
                    'status' => false, 
                    'message' => 'Error While Adding bulk product'
                ])); 
            }

        }
    }

    public function updateProduct(UpdateProductRequest $request, Product $product) {
        
    }

    public function deleteProduct(Product $product){
        
    }

    public function authorDataApi(Request $request) {
        try{
            $authorApi = Http::get('https://openlibrary.org/authors/OL23919A/works.json');
            // if($authorApi->successful()) {
            //     $responseArray = $authorApi->json();
            //     // AutherJob::dispatch($responseArray)->onQueue('default');
            //     AuthorDetailJob::dispatch($responseArray)->onQueue('default');
            //     return response()->json([
            //         'status' => true,
            //         'data' => 'File Uploaded successfully'
            //     ]);
            // }
        } catch(Exception $e) {

        }
    }
}
