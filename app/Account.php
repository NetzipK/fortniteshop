<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Account extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->external_id = Str::uuid();
        });
    }

    public function outfit()
    {
        return $this->belongsToMany('App\Outfit');
    }

    public function backbling()
    {
        return $this->belongsToMany('App\BackBling', 'account_backbling');
    }

    public function pickaxe()
    {
        return $this->belongsToMany('App\Pickaxe');
    }

    public function dance()
    {
        return $this->belongsToMany('App\Dance');
    }

    public function glider()
    {
        return $this->belongsToMany('App\Glider');
    }

    public static function getAllActiveAccounts()
    {
      return Account::where('active', true)->orderBy('created_at', 'desc')->paginate(20);
    }

    public static function findActiveByExternalId($externalId)
    {
      return Account::where('external_id', '=', $externalId)->where('active', true)->firstOrFail();
    }

    public static function getRandomAccounts($count = 3)
    {
      return Account::where('active', true)->inRandomOrder()->take($count)->get();
    }

    public static function getAllActiveSTWAccounts()
    {
        return Account::where([
            ['active', true],
            ['pve', true]
            ])
                ->orderBy('created_at', 'desc')->get();
    }

    public static function getAllActiveBRAccounts()
    {
        return Account::where([
            ['active', true]
            ])
                ->orderBy('created_at', 'desc')->where('outfits', '>', 0)->get();
    }

    public static function getAllActiveAccountsFilterAccess($stworbr, $access)
    {
        return Account::where([
            ['active', true],
            ['pve', $stworbr],
            ['full_access', $access]
            ])
                ->orderBy('created_at', 'desc')->paginate(20);
    }
}
