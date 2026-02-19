<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/books.csv');
        $file = fopen($path, 'r');
        $headers = fgetcsv($file);

        while (($row = fgetcsv($file)) !== false) {
            Book::create([
                'title' => $row[0],
                'description' => $row[1],
                'isbn' => $row[2],
                'total_copies' => (int) $row[3],
                'available_copies' => (int) $row[4],
                'status' => (bool) $row[5],
            ]);
        }

        fclose($file);
        Book::factory(90)->create();
    }
}
