<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartModel extends Model
{
    public static function findActiveByExternalId($externalId)
    {
        if(\App\Article::where('external_id', '=', $externalId)->where('active', true)->exists())
        {
            return \App\Article::findActiveByExternalId($externalId);
        }

        if(\App\Account::where('external_id', '=', $externalId)->where('active', true)->exists())
        {
            return \App\Account::findActiveByExternalId($externalId);
        }

        if(\App\Skin::where('external_id', '=', $externalId)->where('active', true)->exists())
        {
            return \App\Skin::findActiveByExternalId($externalId);
        }
        abort(404);
    }

    public static function findArticleByID($id)
    {
        if(\App\Article::where('id', '=', $id)->exists())
        {
            return \App\Article::where('id', '=', $id)->firstOrFail();
        }

        if(\App\Account::where('id', '=', $id)->exists())
        {
            return \App\Account::where('id', '=', $id)->firstOrFail();
        }

        if(\App\Skin::where('id', '=', $id)->exists())
        {
            return \App\Skin::where('id', '=', $id)->firstOrFail();
        }
        abort(404);
    }
}
