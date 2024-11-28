<?php

namespace App\Models;

class TextBook extends Book
{
    public function updateBook(string $newAuthor): void
    {
        // Can modify protected settable properties
        $this->author = $newAuthor;   // OK - protected(set)

        // These would cause Fatal Errors - private(set)
        // $this->title = 'New Title';
        // $this->price = 29.99;
        // $this->publicationYear = 2025;
        // $this->isbn = '978-0-987654-32-1';
    }

    public function getIsbn(): string
    {
        // Can access protected property
        return $this->isbn;
    }
}
