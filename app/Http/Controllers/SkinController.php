<?php

namespace App\Http\Controllers;

use App\Skin;
use Illuminate\Http\Request;
use Image;
use Validator;

class SkinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skins = Skin::getAllActiveSkins();
        return view('shop.skins.index', compact('skins'));
    }

    function getSkinWatermarkImage($imageName) {
        $img = Image::make(storage_path('/assets/images/skins/' . $imageName));
        $img->insert(storage_path('assets/images/others/copyright.png'), 'center');

        return $img->response();
    }

    function filterSkins(Request $request) {
        $skin = Skin::where('active', true);
        if(!Validator::make($request->all(), [
            'from_price' => 'required|integer|min:0',
            'to_price' => 'required|integer|max:10000', // . $skin->,
            'platform_pc' => 'required|in:true,false',
            'platform_ps4' => 'required|in:true,false',
            'platform_xbox' => 'required|in:true,false',
            'platform_switch' => 'required|in:true,false',
            'search' => 'nullable',
            'sortBy' => 'required'
        ])->passes()) {
            return response()->json(['error' => 'Validation failed'], 422);
        }
        $fromPrice = (int) $request->get('from_price');
        $toPrice = (int) $request->get('to_price');

        $pcPlatform = $request->get('platform_pc') === "true";
        $ps4Platform = $request->get('platform_ps4') === "true";
        $xboxPlatform = $request->get('platform_xbox') === "true";
        $switchPlatform = $request->get('platform_switch') === "true";

        $searchInput = $request->get('search');

        $sortBy = $request->get('sortBy');

        $skin->where('price', '>=', $fromPrice)->where('price', '<=', $toPrice);

        if ($pcPlatform || $ps4Platform || $xboxPlatform || $switchPlatform) {
            $skin->where(function ($query) use ($pcPlatform, $ps4Platform, $xboxPlatform, $switchPlatform) {
                if ($pcPlatform) {
                    $query->orWhere('available_on_PC', true);
                }

                if ($ps4Platform) {
                    $query->orWhere('available_on_PS4', true);
                }

                if ($xboxPlatform) {
                    $query->orWhere('available_on_XBOX', true);
                }

                if ($switchPlatform) {
                    $query->orWhere('available_on_SWITCH', true);
                }
            });
        }

        if(!is_null($searchInput)) {
            $skin->where('name', 'like', '%' . $searchInput . '%')->orWhere('description', 'like', '%' . $searchInput . '%');
        }

        if($sortBy === "newest") {
            $skin->latest();
        }
        else if ($sortBy === "price ascending") {
            $skin->orderBy('price', 'asc');
        }
        else if ($sortBy === "price descending") {
            $skin->orderBy('price', 'desc');
        }
        else {
            return response()->json(['error' => 'Validation failed'], 422);
        }

        $skins = $skin->get();
        $skinsArr = [];
        foreach ($skins as $skin) {
            $imageURL = '';
            if($skin->available_on_PC == true) {
                $imageURL = route('skin.image', 'pc.png');
            }
            if ($skin->available_on_PS4 == true) {
                $imageURL = route('skin.image', 'ps4.png');
            }
            if ($skin->available_on_XBOX == true) {
                $imageURL = route('skin.image', 'xbox.png');
            }
            if ($skin->available_on_SWITCH == true) {
                $imageURL = route('skin.image', 'switch.png');
            }
            $skinsArr[] = [
                'name' => str_limit($skin->name, 40, "..."),
                'price' => number_format($skin->price, 2),
                'external_id' => $skin->external_id,
                'url' => route('skin.show', [$skin->external_id]),
                'imageURL' => $imageURL,
            ];
        }
        return response()->json(['skins' => $skinsArr]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Skin  $skin
     * @return \Illuminate\Http\Response
     */
     public function show(Request $request, $skinExternalId)
     {
       $skin = Skin::findActiveByExternalId($skinExternalId);
       $skins = Skin::getRandomSkins(5);
       return view('shop.skins.show', compact('skin', 'skins'));
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Skin  $skin
     * @return \Illuminate\Http\Response
     */
    public function edit(Skin $skin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Skin  $skin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Skin $skin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Skin  $skin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Skin $skin)
    {
        //
    }
}
