<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    public function add() 
    {

    }

    public function get(Request $request)
    {
        $Book = Book::create([
            'name' => $request->name,
            'authors',
            'published_date',
            'cover',
            'price',
            'amount',
            'gbooks_id'
        ]);
    }
}
