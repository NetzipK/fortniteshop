<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{

    public function user()
    {
        return $this->belongsTo('App\User')->withDefault();
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

    public function deposit($amount, $type = 'deposit', $meta = [])
    {
        if($this->exists) {
            $this->balance += $amount;
            $this->save();
        }
        else {
            $this->balance += $amount;
            $this->save();
        }
    }

    public function withdraw($amount, $type = 'withdraw', $meta = [])
    {
        $accepted = $this->canWithdraw($amount);
        if($accepted) {
            $this->balance -= $amount;
            $this->save();
        }
        elseif(!$this->exists) {
            $this->save();
        }
    }

    public function canWithdraw($amount)
    {
        return $this->balance >= $amount;
    }

    public function getBalance()
    {
        return number_format($this->balance, 2, ',', '.');
    }

    public function getCashoutAmount()
    {
        $amount = $this->transactions()
            ->whereIn('type', ['revenue', 'referral', 'item_revenue'])
            ->sum('amount');
        $cashout = $this->user->cashouts()
            ->where('accepted', true)
            ->orWhere('accepted', null)
            ->sum('amount');
        if ($this->balance < $amount - $cashout) {
            return $this->balance;
        }
        return $amount - $cashout;
    }

    public function getCreditGranted()
    {
        $credits = $this->transactions()
            ->whereIn('type', ['deposit', 'revenue', 'referral', 'item_revenue'])
            ->sum('amount');

        $debits = $this->transactions()
            ->whereIn('type', ['cashout', 'withdraw'])
            ->sum('amount');

        return $this->balance - ($credits - $debits);
        // return $this->balance - $this->getAddedFunds() - $this->getRefRevenue() - $this->getDCRevenue() - $debits;
    }

    public function getAddedFunds()
    {
        $amount = $this->transactions()
            ->whereIn('type', ['deposit'])
            ->sum('amount');
        $debits = $this->transactions()
            ->whereIn('type', ['withdraw'])
            ->sum('amount');

        return $amount;
    }

    public function getRefRevenue()
    {
        $amount = $this->transactions()
            ->whereIn('type', ['referral'])
            ->sum('amount');

        return $amount;
    }

    public function getRefUses()
    {
        return $this->transactions()
            ->whereIn('type', ['referral'])
            ->count();
    }

    public function getDCRevenue()
    {
        $amount = $this->transactions()
            ->whereIn('type', ['revenue'])
            ->sum('amount');

        return $amount;
    }

    public function getDCUses()
    {
        return $this->transactions()
            ->whereIn('type', ['revenue'])
            ->count();
    }

    public function getItemRevenue()
    {
        $amount = $this->transactions()
            ->whereIn('type', ['item_revenue'])
            ->sum('amount');

        return $amount;
    }

    public function getItemsSold()
    {
        return $this->transactions()
            ->whereIn('type', ['item_revenue'])
            ->count();
    }

    public function getFundsReduced()
    {
        $totalBalance = $this->balance;
        $creditGranted = $this->getCreditGranted();
        $addedFunds = $this->getAddedFunds();
        $referrals = $this->getRefRevenue();
        $discountCode = $this->getDCRevenue();
        $items = $this->getItemRevenue();

        $debits = $this->transactions()
            ->whereIn('type', ['withdraw',])
            ->sum('amount');
        $cashouts = $this->transactions()
            ->whereIn('type', ['cashout',])
            ->sum('amount');
        $debitLeft = $debits;
        $cashoutLeft = $cashouts;

        if($referrals >= $cashoutLeft) {
            $referrals -= $cashoutLeft;
            $cashoutLeft = 0;
        } else {
            $cashoutLeft -= $referrals;
            $referrals = 0;
        }
        if($discountCode >= $cashoutLeft) {
            $discountCode -= $cashoutLeft;
            $cashoutLeft = 0;
        } else {
            $cashoutLeft -= $discountCode;
            $discountCode = 0;
        }
        if($items >= $cashoutLeft) {
            $items -= $cashoutLeft;
            $cashoutLeft = 0;
        } else {
            $cashoutLeft -= $items;
            $items = 0;
        }

        if($creditGranted >= $debitLeft) {
            $creditGranted -= $debitLeft;
            $debitLeft = 0;
        } else {
            $debitLeft -= $creditGranted;
            $creditGranted = 0;
        }
        if($addedFunds >= $debitLeft) {
            $addedFunds -= $debitLeft;
            $debitLeft = 0;
        } else {
            $debitLeft -= $addedFunds;
            $addedFunds = 0;
        }
        if($referrals >= $debitLeft) {
            $referrals -= $debitLeft;
            $debitLeft = 0;
        } else {
            $debitLeft -= $referrals;
            $referrals = 0;
        }
        if($discountCode >= $debitLeft) {
            $discountCode -= $debitLeft;
            $debitLeft = 0;
        } else {
            $debitLeft -= $discountCode;
            $discountCode = 0;
        }
        if($items >= $debitLeft) {
            $items -= $debitLeft;
            $debitLeft = 0;
        } else {
            $debitLeft -= $items;
            $items = 0;
        }

        $data = array(
                "credit" => $creditGranted,
                "added" => $addedFunds,
                "referrals" => $referrals,
                "dcode" => $discountCode,
                "items" => $items,
        );

        return $data;
    }
}
