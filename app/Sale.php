<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
  public function CreatedBy() {
      return $this->belongsTo('App\User', 'created_by');
  }

  public function UpdatedBy() {
      return $this->belongsTo('App\User', 'updated_by');
  }

  public function Customer() {
      return $this->belongsTo('App\Customer', 'customer_id', 'id');
  }
  public function Sale_Details() {
      return $this->hasMany('App\SaleDetail', 'sale_id', 'id');
  }

  public function totalSaleTypes() {
    return $this->Sale_Details()->count();
  }

}
