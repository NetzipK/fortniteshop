<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    static public function getAll() {
        return Category::where('active', true)->get()->sortBy('order', false);
    }


    public function article()
    {
        return $this->belongsToMany('App\Article');
    }
}
