<?php

namespace App\Services\Services;


use App\DTO\IdDto;
use App\Models\Book;
use App\Models\rate;
use App\Models\Author;
use App\Models\Category;
use App\Models\Favorite;
use App\DTO\Book\RateDto;
use App\Models\Publisher;
use App\DTO\Book\SearchDto;
use Illuminate\Http\Request;
use App\Traits\GeneralTraits;
use App\DTO\Book\CreateBookDto;
use App\DTO\Book\UpdateBookDto;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Services\Contracts\BookContract;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\Books\CreateBookRequest;

class BookService implements BookContract
{

    use GeneralTraits;

    function isArabic($string): bool
    {
        $encoding = mb_detect_encoding($string, 'ASCII, UTF-8');
        return $encoding === 'UTF-8' && preg_match('/\p{Arabic}/u', $string);
    }

    private function createDependencies(CreateBookDto $data): array
    {
        $categories = $data->category;
        $category = [];
       
        foreach($categories as $categoryName)
        {
            echo($categoryName);
            echo("\n");

            // TODO: check if the category valid
            if(!$category[] = Category::where('name', $categoryName)
                -> first())
            {
                $category[] = Category::create([
                    'name' => $categoryName
                ]);
            }
        }
        if (!$publisher = Publisher::where("name", $data->publisher)
            -> first())
        {
            $publisher = Publisher::create([
                'name' => $data->publisher,
            ]);
        }
        if (!$author = Author::where("name", $data->author)
            ->first())
        {
            $author = Author::create([
                'name' => $data->author,
            ]);
        }
        return [$category, $publisher, $author];
    }
/**
 * 
 * @var object $data
 */
    public function createBook(CreateBookDto $data): ?Book
    {
        $user_id = Auth::user()->id;

        if($book = Book::where('title', $data->title)
            -> first())
                return null;


        $dependencies = $this->createDependencies($data);

        $publisher_id = $dependencies[1]->id;
        $author_id = $dependencies[2]->id;


        if (isset($data->book_image)) {
            $fileName = time() . rand(1111, 111111) . '.' . $data->book_image->extension();
            ($data->book_image)->move(public_path() . '/storage/book/photo', $fileName);
            $photoPath =  $fileName;}


            if (isset($data->book_file)) {
                $fileName = time() . rand(1111, 111111) . '.' . $data->book_file->extension();
                ($data->book_file)->move(public_path() . '/storage/book/file', $fileName);
                $bookPath =  $fileName;}
        
        $book =  Book::create([
            'title' => $data->title,
            'book_file'=>$bookPath,
            'user_id'=>$user_id,
            'author_id' => $author_id,
            'publisher_id' => $publisher_id,
           // 'ISBN' => $data->ISBN,
            'book_description' => $data->book_description,
            'publication_date' => $data->publication_date,
            'quantity' => $data->quantity,
            'price' => $data->price,
            'pages_number' => $data->pages_number,
            'chapters_number' => $data->chapters_number,
            'download_size' => $data->download_size,
           'book_image'=>$photoPath,
        ]);

        foreach ($dependencies[0] as $category)
        {
            if($category)
                $book
                    ->categories()
                    ->attach($category->id);
        }

        return $book;
    }

    public function removeBook(IdDto $data): int
    {
         $book = Book::where('id', $data->id)
            -> first();

         if(!$book)
             return 0;

         $book -> delete();
         return 1;
    }

    public function updateBook(UpdateBookDto $data): Book
    {
        $book = Book::where('id', $data->id)
            -> first();

        if($data->book_description)
            $book->book_description = $data->book_description;

        if($data->quantity)
            $book->quantity = $data->quantity;

        if($data->price)
            $book->price = $data->price;

        if($data->book_image)
            $book->book_image = $data->book_image;

        $book
            -> save();

        return $book;
    }

    public function getBooks(): Collection
    {
        $books = Book::all();

        return $books;
    }

    public function getBook(IdDto $data): Book
    {

    //     $book = Book::with('rates')
    //     ->where('id', $data->id)
    //     ->first();

    // $isFavorite = Favorite::where('user_id', $data->user->id)
    //     ->where('book_id', $book->id)
    //     ->exists();

    // $book->is_favorite = $isFavorite;

    //     $book = Book::with('rates')
    // ->where('id', $data->id)
    // ->first();

// $book->load('favorites')->where('user_id', $data->user->id);

// $book->is_favorite = $book->favorites->count() > 0;

        $book = Book::with(['rates' => function ($query) use ($data) {
            $query->where('user_id', $data->user->id); 
        },'favorites'=>function($fav)use($data){$fav->where('user_id', $data->user->id) ->where('book_id', $data->id)->exists();}])
        ->where('id', $data->id)
        ->first();



        // $book = Book::with(['rates' => function ($query) use ($data) {
        //     $query->where('user_id', $data->user->id); // Assuming you have a user ID in the DTO
        // }])
        // ->where('id', $data->id)
        // ->first();




        // $book = Book::with('rates')->where('id', $data->id)
        //     -> first();

        $book->visits_time += 1;

        $book
            -> save();

        return $book;
    }

    public function findFavorite(IdDto $data):bool
    { 
       // $id = $request->input('id');
        $favorite = Favorite::where('book_id',$data->id)->first();
       
        if($favorite){
            return true;
        }else{
            return false;
        }
    }

    public function searchBook(SearchDto $data): ?Collection
    {
        $query = Book::query();

        if (!empty($data->title)) {
            $query->where('title', 'LIKE', "%{$data->title}%");
        }

        if (!empty($data->category)) {
            $query->whereHas('categories', function ($q) use ($data) {
                $q->where('name', 'LIKE', "%{$data->category}%");
            });
        }

        if (!empty($data->author)) {
            $query->whereHas('author', function ($q) use ($data) {
                $q->where('name', 'LIKE', "%{$data->author}%");
            });
        }

        if (!empty($data->publisher)) {
            $query->whereHas('publisher', function ($q) use ($data) {
                $q->where('name', 'LIKE', "%{$data->publisher}%");
            });
        }

        return $query->get();
    }

    public function buyBook(IdDto $data): float
    {
        $user_balance = $data->user->wallet;

        $book = Book::where('id', $data->id)
            -> first();

        if($book->price > $user_balance)
            return 0;

        $user_balance -= $book->price;

        $user_balance
            -> save();

        return 1;
    }

    public function rateBook(RateDto $data): void
    {
        $book = Book::where('id', $data->bookId)
            -> first();
        
        $Rater = Rate::where('user_id',$data->user->id)
            -> where('book_id',$data->bookId)
            -> first();

        if(!$Rater)
        {
            $rate= rate::create([
                'user_id'=>$data->user->id,
                'book_id'=>$data->bookId,
                'userRate'=>$data->rate,
            ]);
            
            $oldRating = $book->rating;

            $oldRater = $book->rater_number;

            $book->rater_number += 1;

            $oldRate = $oldRating * $oldRater;

            $newRating =  ($oldRate + $data->rate) / ($oldRater + 1);

            $book->rating = $newRating;

            $book
                -> save();
        }

        else
        {    
            $rate = rate::where('user_id', $data->user->id)
                -> where('book_id', $data->bookId)
                -> first();

            $Rater->userRate=$data->rate;

            $Rater->save();

            $oldRating = $book->rating;

            $oldRater = $book->rater_number;

            //$book->rater_number ;

            $oldRate = $oldRating * $oldRater;

            $newRating =  ($oldRate + $data->rate- $rate->userRate) / ($oldRater);

            $book->rating = $newRating;

            $book
                -> save();
        }
    }

    public function showCategories(): Collection
    {
        return Category::all();
    }

    public function showCategory(IdDto $data):JsonResponse
    {
        $category = Category::where('id', $data->id)
            -> first();

        $books = $category->books;

        return response()->json(['books'=>$books ,
        'name'=>$category->name,]);
    }

    public function topTen(): Collection
    {
        $books =  Book::orderBy('visits_time', 'desc')
                    -> take(10)
                    -> get();

        return $books;
    }
}



 