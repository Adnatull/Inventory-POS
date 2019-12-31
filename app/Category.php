<?php

namespace App;

use Cassandra\Bigint;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    public static function getAll() {

    }


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



}
