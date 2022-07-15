<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
        'show_password'
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

    public function returnRequests() {
        return $this->hasMany(ReturnRequest::class);
    }

    public function orders() {
        return $this->hasMany(Order::class, 'cust_id', 'id');
    }

    public function paid_orders() {
        return $this->hasMany(Order::class, 'cust_id', 'id')->where('status', 5);
    }
}
