<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'epic_id', 'discord_id', 'platform'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function wallet()
    {
        return $this->hasOne('App\Wallet')->withDefault();
    }

    public function giftcards()
    {
        return $this->hasMany('App\Giftcard');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function discountcode()
    {
        return $this->hasOne('App\DiscountCode');
    }

    public function cashouts()
    {
        return $this->hasMany('App\Cashout');
    }

    public function articles()
    {
        return $this->hasMany('App\Article');
    }

    public function authorizeRoles($roles)
    {
        if (is_array($roles)) {
            return $this->hasAnyRole($roles) || abort(401, 'This action is unauthorized.');
        }

        return $this->hasRole($roles) || abort(401, 'This action is unauthorized.');
    }

    public function hasAnyRole($roles)
    {
        return null !== $this->roles()->whereIn('name', $roles)->first();
    }

    public function hasRole($role)
    {
        return null !== $this->roles()->where('name', $role)->first();
    }

    public function getOrdersTotal()
    {
        return $this->orders()->where('order_paid', true)->where('order_refunded', false)->where('order_failed', false)->sum('total');
    }

    public function getGGPoints()
    {
        return $this->getOrdersTotal() * 100;
    }

    public function getLoyaltyDiscount($total)
    {
        $discount = 0;
        $ggPoints = $this->getGGPoints();
        if ($ggPoints >= 10000 && $ggPoints < 25000) {
            $discount = 1;
        } elseif ($ggPoints >= 25000 && $ggPoints < 50000) {
            $discount = 2;
        } elseif ($ggPoints >= 50000 && $ggPoints < 150000) {
            $discount = 3;
        } elseif ($ggPoints >= 150000 && $ggPoints < 300000) {
            $discount = 5;
        } elseif ($ggPoints >= 300000 && $ggPoints < 500000) {
            $discount = 7.5;
        } elseif ($ggPoints >= 500000) {
            $discount = 10;
        }
        
        return ($discount / 100) * $total;
    }

    public function getLoyaltyLevel()
    {
        $level = 0;
        $ggPoints = $this->getGGPoints();
        if ($ggPoints >= 10000 && $ggPoints < 25000) {
            $level = 1;
        } elseif ($ggPoints >= 25000 && $ggPoints < 50000) {
            $level = 2;
        } elseif ($ggPoints >= 50000 && $ggPoints < 150000) {
            $level = 3;
        } elseif ($ggPoints >= 150000 && $ggPoints < 300000) {
            $level = 4;
        } elseif ($ggPoints >= 300000 && $ggPoints < 500000) {
            $level = 5;
        } elseif ($ggPoints >= 500000) {
            $level = 6;
        }
        return $level;
    }

    public function getLoyaltyLevelBasePoints()
    {
        $level = $this->getLoyaltyLevel();
        $LP = 0;
        switch($level) {
            case 0:
                $LP = 0;
                break;
            case 1:
                $LP = 10000;
                break;
            case 2:
                $LP = 25000;
                break;
            case 3:
                $LP = 50000;
                break;
            case 4:
                $LP = 150000;
                break;
            case 5:
                $LP = 300000;
                break;
            case 6:
                $LP = 500000;
                break;
        }
        return $LP;
    }

    public function getLoyalyNextLevelPoints()
    {
        $level = $this->getLoyaltyLevel();
        $NLP = 0;
        switch($level) {
            case 0:
                $NLP = 10000;
                break;
            case 1:
                $NLP = 25000;
                break;
            case 2:
                $NLP = 50000;
                break;
            case 3:
                $NLP = 150000;
                break;
            case 4:
                $NLP = 300000;
                break;
            case 5:
                $NLP = 500000;
                break;
            case 6:
                $NLP = 500000;
                break;
        }
        return $NLP;
    }

    public function getGGPercentageToNextLevel()
    {
        $ggPoints = $this->getGGPoints();
        $basePoints = $this->getLoyaltyLevelBasePoints();
        $NLP = $this->getLoyalyNextLevelPoints();
        $percentage = (($ggPoints-$basePoints) / ($NLP-$basePoints)) * 100;
        return number_format($percentage);
    }
}
