<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{   
    public function create(Request $request) 
    {
        $gbooks_id = $request->gbooks_id;
        $gbooks_ids = array_values((array) Book::pluck('gbooks_id'))[0];
        if (in_array($gbooks_id, $gbooks_ids)) 
        {
            $book = Book::where('gbooks_id', $gbooks_id)->get()->first();
            $book->amount = $book->amount + $request->amount;
            $book->save();
        }
        else 
        {
            $book = Book::create([
                'name' => $request->name,
                'authors' => $request->authors,
                'published_date' => $request->published_date,
                'cover' => $request->cover,
                'price' => $request->price,
                'amount' => $request->amount,
                'gbooks_id' => $gbooks_id
            ]);
        }
        return response()->json(['book' => $book]);
    }

    public function getFirst10FromOffset(Request $request)
    {
        $skip = $request->input('skip');
        $books = Book::skip($skip)->take(10)->get();
        return response()->json([
            'books' => $books
        ]);
    }
}
