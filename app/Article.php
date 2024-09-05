<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Gloudemans\Shoppingcart\Contracts\Buyable;

class Article extends Model
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->external_id = Str::uuid();
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'name',
      'type',
      'description',
      'active',
      'amount_min',
      'amount_max',
      'amount_step_size',
      'is_popular',
      'is_sale',
      'is_featured',
      'is_legacy',
      'is_modded',
      'available_on_PC',
      'available_on_PS4',
      'available_on_XBOX',
      'price',
      'item_type',
      'item_perk',
      'image_name',
      'power_level',
      'stars',
      'views',
      'tags',
      'priority'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function category()
    {
        return $this->belongsToMany('App\Category');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /** Find by externalId or fail*/
    public static function findActiveByExternalId($externalId) {
      return Article::where('external_id', '=', $externalId)->where('active', true)->firstOrFail();
    }

    /** Get all active articles */
    public static function getAllActiveArticles() {
      return Article::where('active', true)->orderBy('priority', 'desc')->paginate(20);
    }

    public function getShortDescription() {
      return Str::limit(strip_tags($this->description), 30);
    }

    public static function getAllActiveArticlesFromCategory($id) {
      return Article::where('active', true)->orderBy('priority', 'desc')->whereHas('category', function($q) use ($id) {
        $q->where('category_id', $id);
      })->paginate(20);
    }

    public static function getRandomArticles($count = 3) {
      return Article::where('active', true)->inRandomOrder()->take($count)->get();
    }

    public static function getFeaturedArticles($count = 5) {
      $featured = Article::where('active', true)->where('is_featured', true)->inRandomOrder()->take($count)->get();
      /** If too less featured articles exists, add normal articles in random order */
      if ($featured->count() < $count) {
        $normalItemCount = $count - $featured->count();
        $normalArticles = Article::where('active', true)->where('is_featured', false)->inRandomOrder()->take($normalItemCount)->get();
        $featured = $featured->merge($normalArticles);
      }

      return $featured;
    }

    public function getSoldCount()
    {
        $orders = \App\Order::where('order_paid', true)->whereHas('articles', function ($query) {
            $query->where('article_id', $this->id);
        })->get();
        // dd($orders);
        $counter = 0;
        foreach ($orders as $order) {
            $counter += $order->articles->find($this->id)->pivot->quantity;
        }

        return $counter;
    }

    public function getSoldRevenue()
    {
        if($this->user->exists()) {
            $orders = \App\Order::where('order_paid', true)->whereHas('articles', function ($query) {
                $query->where('article_id', $this->id);
            })->get();

            $total = 0;
            foreach ($orders as $order ) {
                $total += $order->articles->find($this->id)->pivot->subtotal;
            }

            $total = $total * $this->owner_revenue / 100;

            return number_format($total, 2, ',', '.');
        }
    }

    public static function searchArticles($name) {
      return Article::where('active', true)->where('name', 'like', '%' . $name . '%')->orWhere('tags', 'like', '%' . $name . '%')->orderBy('priority', 'desc')->paginate(18);
    }
}
