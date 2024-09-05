<?php

namespace App\Http\Controllers;

use Validator;
use App\Account;
use Illuminate\Http\Request;
use Image;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('accounts.showbr');
        // $accounts = Account::getAllActiveAccounts();
        // return view('shop.accounts.index', compact('accounts'));
    }

    public function ShowSTW()
    {
        $accounts = Account::getAllActiveSTWAccounts();
        return view('shop.accounts.index', compact('accounts'));
    }
    public function ShowSTWAccess()
    {
        $accounts = Account::getAllActiveAccountsFilterAccess(true, true);
        return view('shop.accounts.index', compact('accounts'));
    }
    public function ShowSTWNoAccess()
    {
        $accounts = Account::getAllActiveAccountsFilterAccess(true, false);
        return view('shop.accounts.index', compact('accounts'));
    }
    public function ShowBR()
    {
        $accounts = Account::getAllActiveBRAccounts();
        return view('shop.accounts.index', compact('accounts'));
    }
    public function ShowBRAccess()
    {
        $accounts = Account::getAllActiveAccountsFilterAccess(false, true);
        return view('shop.accounts.index', compact('accounts'));
    }
    public function ShowBRNoAccess()
    {
        $accounts = Account::getAllActiveAccountsFilterAccess(false, false);
        return view('shop.accounts.index', compact('accounts'));
    }

    function indexTest()
    {
        $accounts = Account::getAllActiveAccounts();
        return view('shop.accounts.test', compact('accounts'));
    }

    function filterAccountsBR(Request $request) {
        $account = Account::where('active', true)->where('outfits', '>', 0);
        if(!Validator::make($request->all(), [
            'from_price' => 'required|integer|min:0',
            'to_price' => 'required|integer|max:10000', // . $account->,
            'from_level' => 'required|integer|min:0',
            'to_level' => 'required|integer|max:310', // . $account->,
            'from_vbucks' => 'required|integer|min:0',
            'to_vbucks' => 'required|integer|max:15000', // . $account->,
            'from_bplevel' => 'required|integer|min:0',
            'to_bplevel' => 'required|integer|max:310', // . $account->,
            'from_skins' => 'required|integer|min:0',
            'to_skins' => 'required|integer|max:310', // . $account->,
            'from_pickaxes' => 'required|integer|min:0',
            'to_pickaxes' => 'required|integer|max:310', // . $account->,
            'from_backblings' => 'required|integer|min:0',
            'to_backblings' => 'required|integer|max:310', // . $account->,
            'from_gliders' => 'required|integer|min:0',
            'to_gliders' => 'required|integer|max:310', // . $account->,
            'from_dances' => 'required|integer|min:0',
            'to_dances' => 'required|integer|max:310', // . $account->,
            'platform_pc' => 'required|in:true,false',
            'platform_ps4' => 'required|in:true,false',
            'platform_xbox' => 'required|in:true,false',
            'platform_switch' => 'required|in:true,false',
            'email_access' => 'required|in:bothea,yesea,noea',
            'current_bp' => 'required|in:bothbp,yesbp,nobp',
            'search' => 'nullable',
            'sortBy' => 'required',
        ])->passes()) {
            return response()->json(['error' => 'Validation failed'], 422);
        }
        $fromPrice = (int) $request->get('from_price');
        $toPrice = (int) $request->get('to_price');
        $fromLevel = (int) $request->get('from_level');
        $toLevel = (int) $request->get('to_level');
        $fromVBucks = (int) $request->get('from_vbucks');
        $toVBucks = (int) $request->get('to_vbucks');
        $fromBPLevel = (int) $request->get('from_bplevel');
        $toBPLevel = (int) $request->get('to_bplevel');
        $fromSkins = (int) $request->get('from_skins');
        $toSkins = (int) $request->get('to_skins');
        $fromPickaxes = (int) $request->get('from_pickaxes');
        $toPickaxes = (int) $request->get('to_pickaxes');
        $fromBackblings = (int) $request->get('from_backblings');
        $toBackblings = (int) $request->get('to_backblings');
        $fromGliders = (int) $request->get('from_gliders');
        $toGliders = (int) $request->get('to_gliders');
        $fromDances = (int) $request->get('from_dances');
        $toDances = (int) $request->get('to_dances');

        $pcPlatform = $request->get('platform_pc') === "true";
        $ps4Platform = $request->get('platform_ps4') === "true";
        $xboxPlatform = $request->get('platform_xbox') === "true";
        $switchPlatform = $request->get('platform_switch') === "true";

        $emailAccess = $request->get('email_access');
        $currentBP = $request->get('current_bp');

        $searchInput = $request->get('search');

        $sortBy = $request->get('sortBy');

        /* Sliders */
        $account->where('price', '>=', $fromPrice)->where('price', '<=', $toPrice);
        $account->where('account_level', '>=', $fromLevel)->where('account_level', '<=', $toLevel);
        $account->where('battle_pass_level', '>=', $fromBPLevel)->where('battle_pass_level', '<=', $toBPLevel);
        $account->where('vbucks', '>=', $fromVBucks)->where('vbucks', '<=', $toVBucks);
        $account->where('outfits', '>=', $fromSkins)->where('outfits', '<=', $toSkins);
        $account->where('pickaxes', '>=', $fromPickaxes)->where('pickaxes', '<=', $toPickaxes);
        $account->where('back_bling', '>=', $fromBackblings)->where('back_bling', '<=', $toBackblings);
        $account->where('gliders', '>=', $fromGliders)->where('gliders', '<=', $toGliders);
        $account->where('dances', '>=', $fromDances)->where('dances', '<=', $toDances);

        /* Radios */
        if ($emailAccess === "yesea")
        {
            $account->where('full_access', true);
        }
        else if ($emailAccess === "noea")
        {
            $account->where('full_access', false);
        }
        if ($currentBP === "yesbp")
        {
            $account->where('battle_pass', true);
        }
        else if ($currentBP === "nobp")
        {
            $account->where('battle_pass', false);
        }

        /* Checkboxes */
        if ($pcPlatform || $ps4Platform || $xboxPlatform || $switchPlatform) {
            $account->where(function ($query) use ($pcPlatform, $ps4Platform, $xboxPlatform, $switchPlatform) {
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
            $account->where('name', 'like', '%' . $searchInput . '%')
                ->orWhereHas('outfit', function($query) use ($searchInput) {
                    $query->where('name', 'like', '%' . $searchInput . '%');
                })
                ->orWhereHas('backbling', function($query) use ($searchInput) {
                    $query->where('name', 'like', '%' . $searchInput . '%');
                })
                ->orWhereHas('pickaxe', function($query) use ($searchInput) {
                    $query->where('name', 'like', '%' . $searchInput . '%');
                })
                ->orWhereHas('dance', function($query) use ($searchInput) {
                    $query->where('name', 'like', '%' . $searchInput . '%');
                })
                ->orWhereHas('glider', function($query) use ($searchInput) {
                    $query->where('name', 'like', '%' . $searchInput . '%');
                });
        }

        if($sortBy === "newest") {
            $account->latest();
        }
        else if ($sortBy === "price ascending") {
            $account->orderBy('price', 'asc');
        }
        else if ($sortBy === "price descending") {
            $account->orderBy('price', 'desc');
        }
        else {
            return response()->json(['error' => 'Validation failed'], 422);
        }

        $accounts = $account->get();
        $accountsArr = [];

        foreach ($accounts as $account) {
            $accountsArr[] = [
                'name' => str_limit($account->name, 40, "..."),
                'price' => number_format($account->price, 2),
                'vbucks' => number_format($account->vbucks, 0, ".", ","),
                'level' => $account->account_level,
                'skins' => $account->outfits,
                'pickaxes' => $account->pickaxes,
                'backblings' => $account->back_bling,
                'gliders' => $account->gliders,
                'dances' => $account->dances,
                'external_id' => $account->external_id,
                'pve' => ($account->pve ? '<div class="account-pve color"><strong>yes</strong></div>' : '<div class="account-not-pve"><strong>no</strong></div>'),
                'url' => route('account.show', [$account->external_id]),
                'access_img' => ($account->full_access ? asset('/assets/images/accounts/br/01_full_access.png') : asset('/assets/images/accounts/br/02_half_access.png')),
            ];
        }
        return response()->json(['accounts' => $accountsArr]);
    }

    function filterAccountsSTW(Request $request) {
        $account = Account::where([
            ['active', true],
            ['pve', true]
            ]);
        if(!Validator::make($request->all(), [
            'from_price' => 'required|integer|min:0',
            'to_price' => 'required|integer|max:10000', // . $account->,
            'from_power' => 'required|integer|min:0',
            'to_power' => 'required|integer|max:310', // . $account->,
            'from_vbucks' => 'required|integer|min:0',
            'to_vbucks' => 'required|integer|max:15000', // . $account->,
            'platform_pc' => 'required|in:true,false',
            'platform_ps4' => 'required|in:true,false',
            'platform_xbox' => 'required|in:true,false',
            'platform_switch' => 'required|in:true,false',
            'email_access' => 'required|in:bothea,yesea,noea',
            'current_cq' => 'required|in:t1,t2,t3,t4',
            'current_edition' => 'required|in:both,standard,deluxe,super_deluxe',
            'search' => 'nullable',
            'sortBy' => 'required',
        ])->passes()) {
            return response()->json(['error' => 'Validation failed'], 422);
        }
        $fromPrice = (int) $request->get('from_price');
        $toPrice = (int) $request->get('to_price');
        $fromPower = (int) $request->get('from_power');
        $toPower = (int) $request->get('to_power');
        $fromVBucks = (int) $request->get('from_vbucks');
        $toVBucks = (int) $request->get('to_vbucks');

        $pcPlatform = $request->get('platform_pc') === "true";
        $ps4Platform = $request->get('platform_ps4') === "true";
        $xboxPlatform = $request->get('platform_xbox') === "true";
        $switchPlatform = $request->get('platform_switch') === "true";

        $emailAccess = $request->get('email_access');
        $currentCQ = $request->get('current_cq');
        $currentEdition = $request->get('current_edition');

        $searchInput = $request->get('search');

        $sortBy = $request->get('sortBy');

        /* Sliders */
        $account->where('price', '>=', $fromPrice)->where('price', '<=', $toPrice);
        $account->where('homebase_level', '>=', $fromPower)->where('homebase_level', '<=', $toPower);
        $account->where('vbucks', '>=', $fromVBucks)->where('vbucks', '<=', $toVBucks);

        /* Radios */
        if ($emailAccess === "yesea")
        {
            $account->where('full_access', true);
        }
        else if ($emailAccess === "noea")
        {
            $account->where('full_access', false);
        }
        if ($currentCQ === "t1") {
            $account->where('campagne', 'LIKE', '%T1%');
        }
        else if ($currentCQ === "t2") {
            $account->where('campagne', 'LIKE', '%T2%');
        }
        else if ($currentCQ === "t3") {
            $account->where('campagne', 'LIKE', '%T3%');
        }
        else if ($currentCQ === "t4") {
            $account->where('campagne', 'LIKE', '%T4%');
        }
        if ($currentEdition === "standard") {
            $account->where('standard_edition', true);
        }
        else if ($currentEdition === "deluxe") {
            $account->where('deluxe_edition', true);
        }
        else if ($currentEdition === "super_deluxe") {
            $account->where('super_deluxe_edition', true);
        }

        /* Checkboxes */
        if ($pcPlatform || $ps4Platform || $xboxPlatform || $switchPlatform) {
            $account->where(function ($query) use ($pcPlatform, $ps4Platform, $xboxPlatform, $switchPlatform) {
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
            $account->where('name', 'like', '%' . $searchInput . '%');//->orWhere('campagne', 'like', '%' . $searchInput . '%');
        }

        if($sortBy === "newest") {
            $account->latest();
        }
        else if ($sortBy === "price ascending") {
            $account->orderBy('price', 'asc');
        }
        else if ($sortBy === "price descending") {
            $account->orderBy('price', 'desc');
        }
        else {
            return response()->json(['error' => 'Validation failed'], 422);
        }

        $accounts = $account->get();
        $accountsArr = [];

        foreach ($accounts as $account) {
            $accEdition = '';
            if($account->standard_edition == true) {
                $accEdition = '<div class="standard-edition">STANDARD</div>';
            }
            if($account->deluxe_edition == true) {
                $accEdition = '<div class="deluxe-edition">DELUXE</div>';
            }
            if($account->super_deluxe_edition == true) {
                $accEdition = '<div class="super-deluxe-edition"><span style="letter-spacing: 0;">SUPER</span> DELUXE</div>';
            }

            $accCampagne = '';
            if($account->campagne === 'T1') {
                $accCampagne = 'T1: Stonewood';
            }
            else if ($account->campagne === 'T2') {
                $accCampagne = 'T2: Plankerton';
            }
            else if ($account->campagne === 'T3') {
                $accCampagne = 'T3: Canney Valley';
            }
            else if ($account->campagne === 'T4') {
                $accCampagne = 'T4: Twine Peaks';
            }

            $accountsArr[] = [
                'name' => str_limit($account->name, 40, "..."),
                'price' => number_format($account->price, 2),
                'vbucks' => number_format($account->vbucks, 0, ".", ","),
                'power' => $account->homebase_level,
                'external_id' => $account->external_id,
                'edition' => $accEdition,
                'campaign' => $accCampagne,
                'url' => route('account.show', [$account->external_id]),
                'access_img' => ($account->full_access ? asset('/assets/images/accounts/stw/01_full_access.png') : asset('/assets/images/accounts/stw/02_half_access.png')),
            ];
        }
        return response()->json(['accounts' => $accountsArr]);
    }

    function postAccounts(Request $request) {
        if (!Validator::make($request->all(), [
            'from_price' => 'required|integer|min:0',
            'to_price' => 'required|integer|max:' . Account::where('enabled', true)->max('outfits'),
            'platform_pc' => 'required|in:true,false',
            'platform_ps4' => 'required|in:true,false',
            'platform_xbox' => 'required|in:true,false',
            'type_br' => 'required|in:true,false',
            'type_stw' => 'required|in:true,false',
            'email_access' => 'required|in:both,yes,no',
        ])->passes()) {
            return response()->json(['error' => 'Validation failed'], 422);
        }

        $fromPrice = (int) $request->get('from_price');
        $toPrice = (int) $request->get('to_price');
        $platform = $request->get('platform');
        $pcPlatform = $request->get('platform_pc') === "true";
        $ps4Platform = $request->get('platform_ps4') === "true";
        $xboxPlatform = $request->get('platform_xbox') === "true";
        $brType = $request->get('type_br') === "true";
        $stwType = $request->get('type_stw') === "true";
        $emailAccess = $request->get('email_access');

        $account->where('price', '>=', $fromPrice)->where('price', '<=', $toPrice);

        // if ($platform !== "all") {
        //     $account->where('platform', $platform);
        // }

        if ($emailAccess === "yes")
        {
            $account->where('full_access', true);
        }
        else if ($emailAccess === "no")
        {
            $account->where('full_access', false);
        }

        if ($brType || $stwType) {
            $account->where(function ($query) use ($brType, $stwType) {
                if($brType) {
                    $query->orWhere('pve', false);
                }
                if($stwType) {
                    $query->orWhere('pve', true);
                }
            });
        }

        if ($pcPlatform || $ps4Platform || $xboxPlatform) {
            $account->where(function ($query) use ($pcPlatform, $ps4Platform, $xboxPlatform) {
                if ($pcPlatform) {
                    $query->orWhere('available_on_PC', true);
                }

                if ($ps4Platform) {
                    $query->orWhere('available_on_PS4', true);
                }

                if ($xboxPlatform) {
                    $query->orWhere('available_on_XBOX', true);
                }
            });
        }

        $accounts = $account->get();
        $accountsArr = [];

        foreach ($accounts as $account) {
            $accountsArr[] = [
                'name' => $account->name,
                'pve' => $account->pve,
                'price' => $account->price,
                'vbucks' => $account->vbucks,
                'url' => route('account.show', [$account->external_id])
            ];
        }
        return response()->json(['accounts' => $accountsArr]);
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
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
     public function show(Request $request, $accountExternalId)
     {
       $account = Account::findActiveByExternalId($accountExternalId);
       $accounts = Account::getRandomAccounts(5);
       return view('shop.accounts.show', compact('account', 'accounts'));
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        //
    }

    public function testOutfit($imageName)
    {
        $background = Image::make(storage_path('/assets/images/outfits/01_background.png'));
        $outfit = Image::make(storage_path('/assets/images/outfits/' . $imageName));
        $foreground = Image::make(storage_path('/assets/images/outfits/02_frontground.png'));
        $watermark = Image::make(storage_path('/assets/images/others/copyright_rarity.png'));

        // $outfit->crop(50, 0);
        $outfit->fit(78, 123);

        $foreground->insert($watermark, 'center');
        $background->insert($outfit, 'top', 0, 0);
        $background->insert($foreground, 'center');
        return $background->response();
    }
}
