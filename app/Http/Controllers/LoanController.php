<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Http\Requests\StoreLoanRequest;
use Illuminate\Http\Request;

class LoanController extends Controller {
    
    // Préstamo
    public function store(StoreLoanRequest $request) {
        $book = Book::find($request->book_id);

        if ($book->available_copies <= 0) {
            return response()->json(['error' => 'Libro no disponible para préstamo'], 422);
        }

        $loan = Loan::create([
            'book_id' => $book->id,
            'applicant_name' => $request->applicant_name,
            'loan_date' => now(),
        ]);

        $book->decrement('available_copies');

        if ($book->available_copies == 0) {
            $book->update(['status' => false]);
        }

        return response()->json(['message' => 'Préstamo registrado', 'loan' => $loan], 201);
    }

    // Devolución
    public function returnBook($loan_id) {
        $loan = Loan::findOrFail($loan_id);

        if ($loan->return_date !== null) {
            return response()->json(['error' => 'El libro ya fue devuelto'], 422);
        }

        $loan->update(['return_date' => now()]);

        $book = $loan->book;
        $book->increment('available_copies');

        if (!$book->status) {
            $book->update(['status' => true]);
        }

        return response()->json(['message' => 'Libro devuelto con éxito'], 200);
    }

    // Historial
    public function history() {
        $loans = Loan::with('book')->get()->map(function ($loan) {
            return [
                'loan_id' => $loan->id,
                'book_title' => $loan->book->title,
                'applicant_name' => $loan->applicant_name,
                'loan_date' => $loan->loan_date,
                'return_date' => $loan->return_date,
                'status' => $loan->return_date === null ? 'Activo' : 'Devuelto',
            ];
        });

        return response()->json($loans);
    }
}
