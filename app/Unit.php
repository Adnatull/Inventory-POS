<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
  public function CreatedBy() {
      return $this->belongsTo('App\User', 'created_by');
  }

  public function UpdatedBy() {
      return $this->belongsTo('App\User', 'updated_by');
  }
}
