<?php
use Exception;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryTrait {
    public function index(Request $request) {
        // try{
        //     $subCategory = SubCategory::when($request->has('sub_category_slug'), function ($query) use ($request) {
        //         $query->whereHas('category', function ($q) use ($request) {

        //         });
        //     });
        // } catch(Exception $e) {

        // }
    }

    public function create() {
        
    }


}
