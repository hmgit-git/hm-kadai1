<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',      // ← これがないと今のエラーが出る
        'first_name',
        'last_name',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'detail',
    ];
}
