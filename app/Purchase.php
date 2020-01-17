<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
  public function CreatedBy() {
      return $this->belongsTo('App\User', 'created_by');
  }

  public function UpdatedBy() {
      return $this->belongsTo('App\User', 'updated_by');
  }

  public function Product() {
      return $this->belongsTo('App\Product', 'product_id', 'id');
  }

  public function Supplier() {
      return $this->belongsTo('App\Supplier', 'supplier_id', 'id');
  }
}
