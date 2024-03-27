<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource {
    public function toArray($request) {
        $data = [];
        if($this->stocks->total_product_quantity > 0) {
            $data['category_id']              = $this->category->id;
            $data['sub_category_id']          = $this->subCategory->id;
            $data['category_name']            = $this->category->category_name;
            $data['category_slug']            = $this->category->category_slug;
            $data['sub_category_name']        = $this->subCategory->sub_category_name;
            $data['sub_category_slug']        = $this->subCategory->sub_category_slug;
            $data['parent_sub_category_name'] = $this->subCategory->categorySub->category_name;
            $data['parent_sub_category_slug'] = $this->subCategory->categorySub->category_slug;
            $data['total_product_quantity']   = $this->stocks->total_product_quantity;
            $data['brand_name']               = $this->brand->brand_name;
            $data['product_sku']              = $this->product_sku;
            $data['product_manufracturer']    = $this->product_manufracturer;
            $data['product_price']            = $this->product_price;
            // foreach($this->stocks as $key => $value){
                $data['stock']                = $this->stocks->active_product;
            // }

        } else {
            $data['category_id']              = $this->category->id;
            $data['sub_category_id']          = $this->subCategory->id;
            $data['category_name']            = $this->category->category_name;
            $data['category_slug']            = $this->category->category_slug;
            $data['sub_category_name']        = $this->subCategory->sub_category_name;
            $data['sub_category_slug']        = $this->subCategory->sub_category_slug;
            $data['parent_sub_category_name'] = $this->subCategory->categorySub->category_name;
            $data['parent_sub_category_slug'] = $this->subCategory->categorySub->category_slug;
            $data['total_product_quantity']   = $this->stocks->total_product_quantity;
            $data['brand_name']               = $this->brand->brand_name;
            $data['product_sku']              = $this->product_sku;
            $data['product_manufracturer']    = $this->product_manufracturer;
            $data['product_price']            = $this->product_price;
            // foreach($this->stocks as $value){
                $data['stock']                = $this->stocks->inactive_product;
            // };
        }

        return $data;
    }
}
