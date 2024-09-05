<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ArticleCategory extends Model
{
    protected $table = 'article_category';
    protected $fillable = ['article_id', 'category_id'];
}
