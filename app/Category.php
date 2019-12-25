<?php

namespace App;

use Cassandra\Bigint;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    protected $fillable = ['title', 'image', 'status', 'parent_id', 'created_by', 'updated_by'];
    private $title;
    private $parent_id;
    private $created_by;
    private $updated_by;

    public static function addCategory($request) {

        $validatedData = $request->validate([
            'title' => 'required|max:191'
        ]);

        $category = new Category();
        $category->title = $request->title;

        $category->parent_id =  $request->parentCategory;
        $category->created_by =  Auth::user()->id;
        $category->updated_by = Auth::user()->id;
        var_dump(Auth::user()->getId());
        $category->save();
    }

}
