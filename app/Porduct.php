<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Porduct extends Model
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
}
