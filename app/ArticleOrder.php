<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ArticleOrder extends Model
{
    protected $table = 'article_order';
    protected $fillable = ['order_id', 'article_id', 'quantity', 'price_per_unit', 'subtotal', 'name'];
}
