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

  public function Supplier() {
      return $this->belongsTo('App\Supplier', 'supplier_id', 'id');
  }

  public function Purchase_Details() {
      return $this->hasMany('App\Purchase_Detail', 'purchase_id', 'id');
  }

  public function totalProductTypes() {
    return $this->Purchase_Details()->count();
  }
}
