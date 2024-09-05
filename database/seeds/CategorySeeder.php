<?php

use Illuminate\Database\Seeder;

use App\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File as IlluminateFile;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
     {
         $json = IlluminateFile::get(storage_path('/categories.json'));
         $categories = json_decode($json, true);

         foreach($categories as $category)
         {

           if (empty($dbCategory))
           {
             $newCategory = new Category();

             $newCategory->id = $category["id"];
             $newCategory->name = $category["name"];
             $newCategory->created_at = $category["created_at"];
             $newCategory->updated_at = $category["updated_at"];
             $newCategory->display_name = $category["display_name"];
             $newCategory->is_highlighted = $category["is_highlighted"];
             $newCategory->order = $category["order"];
             $newCategory->selectable = $category["selectable"];
             $newCategory->category_level = $category["category_level"];
             $newCategory->active = $category["active"];

             /** Save Category */
             $newCategory->save();
           }
       }
   }
}
