<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\CartModel;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\DiscountCode;

class CartController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
      $articles = Article::getRandomArticles(8);

      $discount = 0;
      $loyaltyBonus = 0;
      $total = 0;

      if (session('coupon') && is_null(DiscountCode::findActiveByCode(session('coupon')['name']))) {
          session()->forget('coupon');
      }

      /** Check if coupon exists */
      if (session('coupon')) {
        //return session('coupon')['discount'];
        $discount = floatval(str_replace(',', '.', session('coupon')['discount']));
        $temp = floatval(str_replace(',', '.', Cart::total()));
        $temp = floatval(str_replace('.', '', $temp));
        $total = $temp - $discount;
    } else {
        $total = Cart::total(2, '.', '');
    }

      /** Prevent coupon beeing negative or 0 */
      if ($total == 0 || $total < 0) {
        session()->forget('coupon');
      }

      Cart::search(function ($cartItem, $rowId) {
          if (CartModel::findArticleByID($cartItem->id)->active == false) {
              Cart::remove($rowId);
          }
      });

      if($user = \Auth::user()) {
          $loyaltyBonus = $user->getLoyaltyDiscount($total);
          // dd($total);
          $total -= $loyaltyBonus;
      }

      return view('shop.cart.index', compact('articles', 'discount', 'total', 'loyaltyBonus'));
    }

    /** Add new article */
    public function addArticle(Request $request, $id)
    {
      /** Find article */
      $article = CartModel::findActiveByExternalId($id);
      $quantity = intval($request->quantity);

      /** Make sure to not allow a quantity below 1 */
      if ($quantity < 1) {
        $quantity = 1;
      }

      /** Check if the item already exists in the card and remove if needed */
      Cart::search(function ($cartItem, $rowId) use ($article) {
        if ($cartItem->id === $article->id) {
          Cart::remove($rowId);
        }
        if (CartModel::findArticleByID($cartItem->id)->active == false) {
            Cart::remove($rowId);
        }
      });

      /** Add item to cart */
      $baseName = class_basename($article);
      Cart::add($article->id, $article->name, $quantity, $article->price)->associate("App\\{$baseName}");

      return redirect()->back()->with('article-added', true);
    }

    /** Update article quantity */
    public function updateArticle(Request $request, $id)
    {
      /** Find article */
      $article = CartModel::findActiveByExternalId($id);
      $quantity = intval($request->quantity);

      /** Make sure to not allow a quantity below 1 */
      if ($quantity < 1) {
        $quantity = 1;
      }
      /** Check if the item already exists in the card and updated if needed*/
      Cart::search(function ($cartItem, $rowId) use ($article, $quantity) {
        if ($cartItem->id === $article->id) {
          Cart::update($rowId, $quantity);
        }
        if (CartModel::findArticleByID($cartItem->id)->active == false) {
            Cart::remove($rowId);
        }
      });

      return redirect()->back()->with('article-updated', true);
    }

    /** Remove article from cart */
    public function removeArticle(Request $request, $id)
    {
      /** Find article */
      $article = CartModel::findActiveByExternalId($id);

      /** Check if the item already exists in the card and remove if needed */
      Cart::search(function ($cartItem, $rowId) use ($article) {
        if ($cartItem->id === $article->id) {
          Cart::remove($rowId);
        }
        if (CartModel::findArticleByID($cartItem->id)->active == false) {
            Cart::remove($rowId);
        }
      });

      return redirect()->back()->with('article-deleted', true);
    }
}
