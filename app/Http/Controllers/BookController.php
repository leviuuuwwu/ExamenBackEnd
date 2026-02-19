<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Http\Resources\BookResource;

class BookController extends Controller 
{
    public function index(Request $request) {
        $query = Book::query();

        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }
        if ($request->has('isbn')) {
            $query->where('isbn', $request->isbn);
        }
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        return BookResource::collection($query->get());
    }
}