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

    public function delete($gbooks_id) 
    {
        $book = Book::where('gbooks_id', $gbooks_id)->get()->first();

        if ($book) 
        {
            if (!$book->delete())
            {
                return response()->json([
                    'error' => 'Unable to delete the book'
                ]);
            }

            return response()->json([
                'message' => 'Book deleted successfully',
            ]);
        }

        return response()->json([
            'error' => 'Book not found'
        ]);
    }

    public function edit(Request $request, $gbooks_id) 
    {
        $book = Book::where('gbooks_id', $gbooks_id)->get()->first();

        if ($book)
        {
            $book->name = $request->name;
            $book->authors = $request->authors;
            $book->published_date = $request->published_date;
            $book->cover = $request->cover;
            $book->price = $request->price;
            $book->amount = $request->amount;

            $book->save();

            return response()->json([
                'message' => 'Book updated successfully',
            ]);
        }

        return response()->json([
            'error' => 'Book not found'
        ]);
    }

    public function getFirst10FromOffset(Request $request)
    {
        $skip = $request->input('skip');
        $books = Book::skip($skip)->take(10)->get();
        return response()->json([
            'books' => $books
        ]);
    }

    public function checkIfBookIsInDatabase(Request $request)
    {
        $gbooks_id = $request->input('gbooks_id');
        if (Book::where('gbooks_id', $gbooks_id)->first())
        {
            return response()->json([
                'found' => TRUE
            ]);
        }
        else
        {
            return response()->json([
                'found' => FALSE
            ]);
        }
    }
}
