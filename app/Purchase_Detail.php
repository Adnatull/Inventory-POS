<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase_Detail extends Model
{
  public function Purchase() {
      return $this->belongsTo('App\Purchase', 'purchase_id', 'id');
  }

  public function Product() {
    return $this->belongsTo('App\Product', 'product_id', 'id'); 
  }


    protected $table = 'purchase_details';
}
