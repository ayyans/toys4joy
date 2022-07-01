<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnRequest extends Model
{
    use HasFactory;

    protected $fillable = ['reason', 'detail', 'receipt', 'status'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
