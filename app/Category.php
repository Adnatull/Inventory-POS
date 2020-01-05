<?php

namespace App;

use Cassandra\Bigint;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Category extends Model
{
    protected $fillable = ['title', 'image', 'status'];
    private $title;
    private $created_by;
    private $updated_by;
    private $parent_id;
    /**
     * @var string
     */
    private $image;
    /**
     * @var string
     */
    private $status;




    public function CreatedBy() {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function UpdatedBy() {
        return $this->belongsTo('App\User', 'updated_by');
    }

    public function ParentCategory() {
        return $this->belongsTo('App\Category', 'parent_id', 'id');
    }

    public function ChildCategories() {
        return $this->hasMany('App\Category', 'parent_id','id');
    }

    public function Products() {
        return $this->hasMany('App\Product', 'category_id', 'id');
    }



}
