<?php

namespace App\DTO\Book;

use App\Http\Requests\Books\UpdateBookRequest;

class UpdateBookDto
{
    public function __construct(
        public readonly int $id,
        public readonly ?string $book_description,
        public readonly ?int $quantity,
        public readonly ?int $price,
        public readonly ?string $book_image,
    )
    {

    }

    public static function updateBook(UpdateBookRequest $request): UpdateBookDto
    {
        return new self(
            id: $request->id,
            book_description: $request->book_description,
            quantity: $request->quantity,
            price: $request->price,
            book_image: $request->book_image
        );
    }
}
