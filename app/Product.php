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

    public function Prices() {
        return $this->hasMany('App\Product_Price', 'product_id', 'id');
    }

    public function Current_Price() {
      $price = $this->Prices()->where('product_id', $this->id)->orderBy('id', 'DESC')->first();
      return $price['selling_cost'];
    }
}
