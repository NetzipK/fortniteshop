<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use NotificationChannels\Discord\Discord;
use App\Article;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');

        // $client = new \GuzzleHttp\Client();
        // $discord = new Discord($client, 'NTU3Mjc2MjY0Njk2NjQzNTg2.D3F8lw.xzl5LqZriDi6jzGvdWik7T4mebQ');
        // $discord->send('561294901484978186', [
        //     'content' => '**Order** #'
        // ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $articles = Article::getFeaturedArticles(8);
        return view('shop.home.index', compact('articles'));
    }

    public function helpIndex()
    {
        return view('shop.help.index');
    }

    public function privacy()
    {
        return view('shop.help.privacy');
    }

    public function toc()
    {
        return view('shop.help.terms-and-conditions');
    }

    public function cookie()
    {
        return view('shop.help.cookie-policy');
    }
    public function row()
    {
        return view('shop.help.right-of-withdrawal');
    }

    public function paymentMethods()
    {
        return view('shop.help.paymentmethods');
    }

    public function findYourEpicId()
    {
        return view('shop.guides.find-your-epic-id');
    }

    public function searchAll(Request $request)
    {
        $search = $request->get('search');

        $articles = Article::where('name', 'LIKE', '%' . $search . '%')
                        ->orWhere('description', 'LIKE', '%' . $search . '%')->limit(5)->get();
        // $accounts = \App\Account::where('name', 'like', '%' . $search . '%')
        //                 ->orWhereHas('outfit', function($query) use ($search) {
        //                     $query->where('name', 'like', '%' . $search . '%');
        //                 })
        //                 ->orWhereHas('backbling', function($query) use ($search) {
        //                     $query->where('name', 'like', '%' . $search . '%');
        //                 })
        //                 ->orWhereHas('pickaxe', function($query) use ($search) {
        //                     $query->where('name', 'like', '%' . $search . '%');
        //                 })
        //                 ->orWhereHas('dance', function($query) use ($search) {
        //                     $query->where('name', 'like', '%' . $search . '%');
        //                 })
        //                 ->orWhereHas('glider', function($query) use ($search) {
        //                     $query->where('name', 'like', '%' . $search . '%');
        //                 })->limit(5)->get();
        // $skins = \App\Skin::where('name', 'like', '%' . $search . '%')
        //                 ->orWhere('description', 'like', '%' . $search . '%')->limit(5)->get();

        $articlesArr = [];
        foreach($articles as $article) {
            $articlesArr[] = [
                'name' => str_limit($article->name, 40, "..."),
                'type' => 'STW Item',
                'image' => route('article.image', $article->image_name),
                'price' => number_format($article->price, 2, ',', '.'),
                'url' => route('article.show', $article->external_id)
            ];
        }

        // $accountsArr = [];
        // foreach($accounts as $account) {
        //     $accountsArr[] = [
        //         'name' => str_limit($account->name, 40, "..."),
        //         'type' => 'Account',
        //         'image' => '',
        //         'url' => route('account.show', $account->external_id)
        //     ];
        // }
        //
        // $skinsArr = [];
        // foreach($skins as $skin) {
        //     $skinsArr[] = [
        //         'name' => str_limit($skin->name, 40, "..."),
        //         'type' => 'Skin',
        //         'image' => '',
        //         'url' => route('skin.show', $skin->external_id)
        //     ];
        // }

        // $result = collect($articlesArr)->concat($accountsArr)->concat($skinsArr);
        $result = collect($articlesArr);
        // dd($result);

        return response()->json(['result' => $result]);
    }
}
