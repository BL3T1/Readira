<?php

namespace App\DTO\Book;

use App\Http\Requests\Books\CreateBookRequest;
use App\Models\Author;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Http\File;

//use Illuminate\Support\Facades\File;

//use Illuminate\Http\Testing\File;

class CreateBookDto
{
    public function __construct(
        public readonly string $title,
        public readonly array $category,
        public readonly string $publisher,
        public readonly string $author,
        //public readonly string $ISBN,
        public readonly string $book_description,
        public readonly string $publication_date,
        public readonly int $quantity,
        public readonly int $price,
        public readonly int $pages_number,
        public readonly int $chapters_number,
        public readonly string $download_size,
        public readonly object $book_image,
        public readonly object $book_file,

    )
    {

    }

    public static function create(CreateBookRequest $request): CreateBookDto
    {
        return new self(
            title: $request->title,
            category: $request->category,
            publisher: $request->publisher,
            author: $request->author,
           // ISBN: $request->ISBN,
            book_description: $request->book_description,
            publication_date: $request->publication_date,
            quantity: $request->quantity,
            price: $request->price,
            pages_number: $request->pages_number,
            chapters_number: $request->chapters_number,
            download_size: $request->download_size,
            book_image: $request->book_image,
            book_file: $request->book_file,

        );
    }
}
