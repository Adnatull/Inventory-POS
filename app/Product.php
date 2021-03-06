<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{


    public function CreatedBy() {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function UpdatedBy() {
        return $this->belongsTo('App\User', 'updated_by');
    }

    public function Category() {
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function SoldItems() {

    }

    public function Images() {
        return $this->hasMany('App\Product_Image', 'product_id', 'id');
    }

    public function HasImages() {
        $images = $this->Images()->count();
        if($images == 0) {
            return false;
        }
        return true;
    }

    public function getRandomImage() {
      $image = $this->Images->random(1)->first();
      return $image;
    }

    public function Prices() {
        return $this->hasMany('App\Product_Price', 'product_id', 'id');
    }

    public function Current_Price() {
      $price = $this->Prices()->where('product_id', $this->id)->orderBy('id', 'DESC')->first();
      if($price == null) {
        return 0;
      }
      return $price['selling_price'];
    }

    public function Unit() {
      return $this->belongsTo('App\Unit', 'unit_id', 'id');
    }

    public function Brand() {
      return $this->belongsTo('App\Brand', 'brand_id', 'id');
    }
}
