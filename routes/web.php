<?php

use App\Models\Book;
use App\Models\TextBook;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/php-83', function () {
    return (new Response())
        ->header('Content-Type', 'application/json')
        ->setContent(['status' => 'success'])
        ->setStatusCode(200);
});

Route::get('/php-84', function () {
    return new Response()
        ->header('Content-Type', 'application/json')
        ->setContent(['status' => 'success'])
        ->setStatusCode(200);
});

Route::get('/book-example', function () {
    // Create a new book
    $book = new Book(
        title: 'PHP 8.4 Advanced Guide',
        author: 'John Doe',
        price: 49.99,
        publicationYear: 2024,
        isbn: '978-0-123456-78-9'
    );

    // Read public properties
    $publicData = [
        'title' => $book->title,    // OK - public read
        'author' => $book->author,   // OK - public read
        'price' => $book->price,     // OK - public read
    ];

    // These would cause Fatal Errors
    // $book->title = 'New Title';           // Error - private(set)
    // $book->price = 59.99;                 // Error - private(set)
    // $book->publicationYear = 2025;        // Error - protected property
    // $book->isbn = '978-0-987654-32-1';   // Error - private(set)

    // Create a TextBook instance
    $textbook = new TextBook(
        title: 'PHP 8.4 for Students',
        author: 'Jane Smith',
        price: 39.99,
        publicationYear: 2024,
        isbn: '978-0-555555-55-5'
    );

    // Update protected settable properties
    $textbook->updateBook(newAuthor: 'Jane Smith-Jones');

    return response()->json([
        'book_public_data' => $publicData,
        'book_all_data' => $book->getDetails(),
        'textbook_data' => $textbook->getDetails(),
        'textbook_isbn' => $textbook->getIsbn(),
    ], JSON_PRETTY_PRINT);
});
