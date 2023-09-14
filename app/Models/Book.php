<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'authors',
        'published_date',
        'cover',
        'price',
        'amount',
        'gbooks_id'
    ];
}
