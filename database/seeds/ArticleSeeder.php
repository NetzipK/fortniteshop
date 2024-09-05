<?php

use Illuminate\Database\Seeder;

use App\Category;
use App\Article;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File as IlluminateFile;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
            $newArticle->price = $article["price"] * $article["amount_step_size"];
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
    }
}
