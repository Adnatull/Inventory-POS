<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
  public function Sale() {
      return $this->belongsTo('App\Sale', 'sale_id', 'id');
  }

  public function Product() {
    return $this->belongsTo('App\Product', 'product_id', 'id');
  }
}
