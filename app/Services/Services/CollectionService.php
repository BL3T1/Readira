<?php

namespace App\Services\Services;

use App\DTO\Collection\CreateCollectionDto;
use App\DTO\Collection\UpdateCollectionDto;
use App\DTO\IdDto;
use App\DTO\UserDto;
use App\Models\Book;
use App\Models\User;
use App\Models\Collection;
use App\Models\Favorite;
use App\Services\Contracts\CollectionContract;
use App\DTO\Collection\RemoveCollectionDto;
use App\DTO\Collection\RemoveFromCollectionDto;
use Illuminate\Database\Eloquent\Collection as Collections;

class CollectionService implements CollectionContract
{

    public function createCollection(CreateCollectionDto $data): ?Collection
    {
        $user = $data->user;

        if($user
            -> collections()
            -> where('name', $data->name)
            -> first())
        {
            return null;
        }

        $collection = Collection::create([
            'name' => $data->name,
        ]);

        $data
            -> user
            -> collections()
            -> attach($collection);

        return $collection;
    }

    public function insertIntoCollection(UpdateCollectionDto $data): array
    {
        $book = Book::where('id', $data->id)
            -> first();

        $collection = $data
            -> user
            -> collections()
            -> where('name', $data->name)
            -> first();

        $name = $collection->name;

        if($collection -> books -> where('id', $book->id) -> first())
        {
            return [0, $name];
        }

        $book
            -> collections()
            -> attach($collection);

        return [1, $name];
    }

    public function removeCollection(RemoveCollectionDto $data): int
    {
        $collection = $data
            -> user
            -> collections()
            -> where('name', $data->name)
            -> first();

        if(!$collection)
            return 0;

        $collection
            -> delete();
        return 1;
    }

    public function removeFromCollection(RemoveFromCollectionDto $data): array
    {
        $book = Book::find($data->id);

        $collection = $data
            -> user
            -> collections()
            -> where('name', $data->name)
            -> first();

        $name = $data->name;

        if (!$book || !$collection)
            return [0, $name];

        $isDetached = $collection->books()->detach($book->id);

        if ($isDetached)
            return [1, $name];

        else
            return [-1, $name];
    }

    public function getCollections(UserDto $data): Collections
    {
        $collections = User::where('id', $data->user->id)
            -> with('collections')
            -> get()
            -> pluck('collections')[0];

        return $collections;
    }

    public function getCollectionContent(CreateCollectionDto $data): Collections
    {
        $collections = User::where('id', $data->user->id)
            -> with('collections')
            -> get()
            -> pluck('collections')[0];

        $res = new Collections();

        foreach($collections as $collection)
        {
            if($collection->name == $data->name)
            {
                $res = $collection
                    -> books;
                break;
            }
        }

        return $res;
    }

    public function insertIntoFavorite(IdDto $data): int
    {
        if(Favorite::where('book_id', $data->id)
            -> where('user_id', $data->user->id)
            -> first())
        {
            return 0;
        }

       Favorite::create([
            'book_id' => $data->id,
            'user_id' => $data->user->id,
        ]);

        return 1;
    }

    public function removeFromFavorite(IdDto $data): int
    {
        if(!Favorite::where('id', $data->id)
            -> first())
            return 0;

        Favorite::where('user_id', $data->user->id)
            -> where('book_id', $data->id)
            -> delete();

        return 1;
    }

    public function getFavorite(UserDto $data): array
    {
         $favorites = Favorite::where('user_id', $data->user->id)
            -> get();

         $books = [];

         foreach($favorites as $favorite)
         {
            $books[] = Book::where('id', $favorite->book_id)
                -> first();
         }

         return $books;
    }
}
