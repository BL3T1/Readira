<?php

namespace App\DTO\Book;

use App\Http\Requests\Books\SearchRequest;

class SearchDto
{
    public function __construct(
        public readonly ?string $title,
        public readonly ?string $category,
        public readonly ?string $author,
        public readonly ?string $publisher,
    )
    {
    }

    public static function search(SearchRequest $request): SearchDto
    {
        return new self(
            title: $request->title,
            category: $request->category,
            author: $request->author,
            publisher: $request->publisher,
        );
    }
}
