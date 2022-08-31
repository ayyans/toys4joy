<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usergiftcards extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function giftCard() {
        return $this->belongsTo(giftcards::class, 'giftcard_id');
    }
}
