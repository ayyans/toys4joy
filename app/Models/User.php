<?php

namespace App\Models;

use Bavix\Wallet\Interfaces\Customer;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Traits\CanPay;

class User extends Authenticatable implements Wallet, Customer
{
    use HasApiTokens, HasFactory, Notifiable, HasWallet, CanPay;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guard='admin';
    protected $fillable = [
        'name',
        'email',
        'password',
        'show_password',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function wishlist() {
        return $this->hasMany(Wishlist::class, 'cust_id');
    }

    public function returnRequests() {
        return $this->hasMany(ReturnRequest::class);
    }

    public function orders() {
        return $this->hasMany(Order::class)->where('additional_details->is_abandoned', false);
    }

    public function deliveredOrders() {
        return $this->hasMany(Order::class)->where('order_status', 'delivered');
    }

    public function address() {
        return $this->hasOne(CustomerAddress::class, 'cust_id', 'id');
    }

    public function siblings() {
        return $this->hasOne(sibblings::class, 'user_id', 'id');
    }

    public function giftCardsUsed() {
        return $this->hasMany(giftcards::class, 'user_id', 'id');
    }

    public function giftCardsPurchased() {
        return $this->hasMany(usergiftcards::class, 'user_id', 'id')
            ->where('payment_status', 'paid')->whereNotNull('transaction_number');
    }

    public function giftCardsRewarded() {
        return $this->hasMany(usergiftcards::class, 'user_id', 'id')
            ->where('payment_status', 'paid')->whereNull('transaction_number');
    }
}
