<?php

namespace App\Services\Contracts;

use App\DTO\Collection\CreateCollectionDto;
use App\DTO\Collection\RemoveCollectionDto;
use App\DTO\Collection\RemoveFromCollectionDto;
use App\DTO\Collection\UpdateCollectionDto;
use App\DTO\IdDto;
use App\DTO\UserDto;
use App\Models\Favorite;
use \Illuminate\Database\Eloquent\Collection as Collections;
use App\Models\Collection;

interface CollectionContract
{
    public function createCollection(CreateCollectionDto $data): ?Collection;

    public function insertIntoCollection(UpdateCollectionDto $data): array;

    public function removeCollection(RemoveCollectionDto $data): int;

    public function removeFromCollection(RemoveFromCollectionDto $data): array;

    public function getCollections(UserDto $data): Collections;

    public function getCollectionContent(CreateCollectionDto $data): Collections;

    public function insertIntoFavorite(IdDto $data): int;

    public function removeFromFavorite(IdDto $data): int;

    public function getFavorite(UserDto $data): array;
}
