<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\CityController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductBrandController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\CategoryController;
// use App\Http\Controllers\UserDetailsController;
use App\Http\Controllers\TemplateDetailsController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StateController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/state', [StateController::class, 'index']);
Route::post('/school', [SchoolController::class, 'index']);

// Route::post('/post', [PostController::class, 'index']);
// Route::post('/post/store', [PostController::class, 'storePost'])->name('store-post');
// Route::post('/post/update/{id}', [PostController::class, 'updatePost'])->name('update-post');
// Route::delete('/post/delete/{id}', [PostController::class, 'deletePost'])->name('delete-post');
// Route::post('/post/restore/{id}', [PostController::class, 'restoreDeletedPost'])->name('restore-post');


// Route::post('comment/store', [CommentController::class, 'createComment'])->name('restore-post');


Route::post('category/store', [CategoryController::class, 'createCategoryApi']);
Route::post('category/update/{id}', [CategoryController::class, 'updateCategoryApi']);
Route::delete('category/delete/{id}', [CategoryController::class, 'deleteCategoryApi']);
Route::post('category/restore/{id}', [CategoryController::class, 'restoreCategoryDetailsApi']);


Route::post('sub-category/store', [SubCategoryController::class, 'storeSubCategoryApi']);
Route::post('sub-category/update/{id}', [SubCategoryController::class, 'updateSubCategoryApi']);
Route::delete('sub-category/delete/{id}', [SubCategoryController::class, 'deleteSubCategoryApi']);
Route::post('sub-category/restore/{id}', [SubCategoryController::class, 'restoreSubCategoryApi']);


Route::post('product-brand/store', [ProductBrandController::class, 'storeProductBrandApi']);
Route::post('product-brand/update/{id}', [ProductBrandController::class, 'updateProductBrandApi']);
Route::delete('product-brand/delete/{id}', [ProductBrandController::class, 'deleteProductBrandApi']);
Route::post('product-brand/restore/{id}', [ProductBrandController::class, 'restoreCategoryDetailsApi']);


Route::post('product/show-product', [ProductController::class, 'showProduct']);
Route::post('product/store', [ProductController::class, 'storeProduct']);
Route::post('product/update/{id}', [ProductController::class, 'updateProduct']);
Route::delete('product/delete/{id}', [ProductController::class, 'deleteProduct']);
Route::post('product/restore/{id}', [ProductController::class, 'restoreProductDimensionDetailsApi']);



Route::get('product/author-api', [ProductController::class, 'authorDataApi']);


Route::post('template/name-field/save', [TemplateDetailsController::class, 'saveTemplateNameFields']);

Route::post('template/payload/save', [TemplateDetailsController::class, 'getTemplatePayloadDetails']);

Route::post('template/name-field/update', [TemplateDetailsController::class, 'updateTemplateNameField']);

Route::post('template/name-field/show', [TemplateDetailsController::class, 'showTemplateDetails']);



// Traits
Route::post('template/name-field/store', [StudentController::class, 'store']);

Route::post('template/name-field/update', [StudentController::class, 'update']);

