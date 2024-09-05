<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/** Models */
use App\Article;

/** Packages */
use Webpatser\Uuid\Uuid;
use App\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File as IlluminateFile;
use Image;

class ArticleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
      $articles = Article::getAllActiveArticles();
      $categories = Category::getAll();
      return view('shop.articles.index', compact('articles', 'categories'));
    }

    public function search(Request $request)
    {
      $articles = Article::searchArticles($request->name);
      $categories = Category::getAll();
      return view('shop.articles.index', compact('articles', 'categories'));
    }

    public function category(Request $request, $categoryId)
    {
      $articles = Article::getAllActiveArticlesFromCategory($categoryId);
      $categories = Category::getAll();
      return view('shop.articles.index', compact('articles', 'categories'));
    }

    /** Show single article */
    public function show(Request $request, $articleExternalId)
    {
      $article = Article::findActiveByExternalId($articleExternalId);
      $articles = Article::getRandomArticles(5);
      return view('shop.articles.show', compact('article', 'articles'));
    }

    public function create(Request $request) {

      /** Create a new article */
      $article = new Article;

      /** Store values */
      $article->externalId = Uuid::generate(4);
      $article->name = $request->name;
      $article->image = $request->image;
      $article->price = $request->price;
      $article->oldPrice = $request->price + 1;
      $article->isFeatured = boolval($request->isFeatured);
      $article->description = $request->description;
      $article->itemStars = $request->itemStars;

      /** Store article */
      $article->save();

      return $request;
    }

    public function loadArticles() {
      $json = IlluminateFile::get(storage_path('/articles.json'));
      $articles = json_decode($json, true);

      foreach($articles as $article) {

        $dbArticle = Article::where('unique_id', $article["id"])->first();
        if (empty($dbArticle)) {
          $newArticle = new Article();

          $newArticle->name = $article["name"];
          $newArticle->description = $article["description"];
          $newArticle->active = $article["active"];
          $newArticle->amount_min = $article["amount_min"];
          $newArticle->amount_max = $article["amount_max"];
          $newArticle->amount_step_size = $article["amount_step_size"];
          $newArticle->is_sale = $article["is_sale"];
          $newArticle->is_featured = $article["is_featured"];
          $newArticle->price = $article["price"];
          $newArticle->power_level = $article["power_level"];
          $newArticle->image_name = $article["image_name"];
          $newArticle->stars = $article["stars"];
          $newArticle->unique_id = $article["id"];
          $newArticle->tags = implode(",", $article["tag"]);

          /** Save article */
          $newArticle->save();

          /** Main category */
          $mainCategory = Category::where('name', $article["mainCategory"])->first();
          if (!empty($mainCategory)) {
            $newArticle->category()->attach($mainCategory->id);
          }

          /** Category */
          $category = Category::where('name', $article["category"])->first();
          if (!empty($category)) {
            $newArticle->category()->attach($category->id);
          }
        }
      }
      return $articles;
    }

    function getArticleWatermarkImage($imageName) {

        $img = Image::make(storage_path('/assets/images/articles/' . $imageName));
        $img->insert(storage_path('assets/images/others/copyright.png'), 'center');

        return $img->response();

    }

}
