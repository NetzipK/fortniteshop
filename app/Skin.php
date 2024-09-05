<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Skin extends Model
{
    protected $guarded = [];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->external_id = Str::uuid();
        });
    }
    public static function getAllActiveSkins()
    {
        return Skin::where('active', true)->orderBy('created_at', 'desc')->paginate(20);
    }
    public static function findActiveByExternalId($externalId)
    {
        return Skin::where('external_id', '=', $externalId)->where('active', true)->firstOrFail();
    }

    public static function getRandomSkins($count = 3)
    {
        return Skin::where('active', true)->inRandomOrder()->take($count)->get();
    }
}
