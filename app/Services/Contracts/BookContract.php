<?php

namespace App\Services\Contracts;

use App\DTO\Book\CreateBookDto;
use App\DTO\Book\RateDto;
use App\DTO\Book\SearchDto;
use App\DTO\Book\UpdateBookDto;
use App\DTO\IdDto;
use App\Models\Book;
use App\Models\Category;
use \Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface BookContract
{
    public function createBook(CreateBookDto $data): ?Book;

    public function removeBook(IdDto $data): int;
    public function findFavorite(IdDto $data):bool;

    public function updateBook(UpdateBookDto $data): Book;

    public function getBooks(): Collection;

    public function getBook(IdDto $data): Book;

    public function searchBook(SearchDto $data): ?Collection;

    public function buyBook(IdDto $data): float;

    public function rateBook(RateDto $data): void;

    public function showCategories(): Collection;

    public function showCategory(IdDto $data): JsonResponse;

    public function topTen(): Collection;
}
