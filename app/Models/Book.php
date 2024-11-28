<?php

namespace App\Models;

class Book
{
    public function __construct(
        // Public read, private write
        public private(set) string $title,
        // Public read, protected write
        public protected(set) string $author,
        // Public read, private write
        public private(set) float $price,
        // Protected read, private write
        protected private(set) int $publicationYear,
        // Protected read, private write
        protected private(set) string $isbn
    ) {}

    // Method to get protected/private properties
    public function getDetails(): array
    {
        return [
            'title' => $this->title,
            'author' => $this->author,
            'price' => $this->price,
            'year' => $this->publicationYear,
            'isbn' => $this->isbn
        ];
    }

    // Method to update protected settable properties
    protected function updateProtectedProperties(string $author, string $isbn): void
    {
        $this->author = $author;  // OK - protected(set)
        $this->isbn = $isbn;      // OK - protected(set)
    }
}
