<?php

namespace App\Http\Controllers\Books;

use App\DTO\IdDto;
use App\DTO\Book\RateDto;
use App\DTO\Book\SearchDto;
use Illuminate\Http\Request;
use App\Traits\GeneralTraits;
use App\DTO\Book\CreateBookDto;
use App\DTO\Book\UpdateBookDto;
use App\Http\Requests\IdRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Facades\BookFacade;
use App\Http\Requests\Books\RateRequest;
use App\Http\Requests\Books\SearchRequest;
use App\Http\Requests\Books\CreateBookRequest;
use App\Http\Requests\Books\UpdateBookRequest;

class BookController extends Controller
{
    use GeneralTraits;

    public function add(CreateBookRequest $request): JsonResponse
    {
        $dto = CreateBookDto::create($request);

        $book = BookFacade::createBook($dto);

        if(!$book)
        {
            if($this -> getCurrentLang() == 'ar')
                return $this -> returnError(400, 'هذا الكتاب موجود بالفعل');
            return $this -> returnError(400, 'This Book is already exist');
        }

        if($this -> getCurrentLang() == 'ar')
            return $this -> returnSuccessMessage(200, 'تم إضافة الكتاب بنجاح');
        return $this -> returnSuccessMessage(200, 'The Books Has Been Added Successfully');
    }

    
    public function findFavorite(IdRequest $request):JsonResponse
    { 
        $dto = IdDto::id($request);

        $favorite = BookFacade::findFavorite($dto);

        return $this -> returnData('favortie', $favorite);
  
    }

    public function delete(IdRequest $request): JsonResponse
    {
        $dto = IdDto::id($request);

        $book = BookFacade::removeBook($dto);

        if($book == 0)
        {
            if($this -> getCurrentLang() == 'ar')
                return $this -> returnError(400, 'هذا غير الكتاب موجود');
            return $this -> returnError(400, "This Book isn't exist");
        }

        if($this -> getCurrentLang() == 'ar')
            return $this -> returnSuccessMessage(200, 'تم حذف الكتاب بنجاح');
        return $this -> returnSuccessMessage(200, 'The Books Has Been Deleted Successfully');
    }

    public function update(UpdateBookRequest $request)
    {
        $dto = UpdateBookDto::updateBook($request);

        $book = BookFacade::updateBook($dto);

        if($this -> getCurrentLang() == 'ar')
            return $this -> returnSuccessMessage(200, 'تم حذف الكتاب بنجاح');
        return $this -> returnSuccessMessage(200, 'The Books Has Been Deleted Successfully');
    }

    public function getAllBooks(): JsonResponse
    {
        $books = BookFacade::getBooks();

        return $this -> returnData('books', $books);
    }

    public function getBook(IdRequest $request): JsonResponse
    {
        $dto = IdDto::id($request);

        $book = BookFacade::getBook($dto);

        return $this -> returnData('book', $book);
    }

    public function searchForBook(SearchRequest $request): JsonResponse
    {
        $dto = SearchDto::search($request);

        $books = BookFacade::searchBook($dto);

        return $this -> returnData('books', $books);
    }

    public function buyBook(Request $request)
    {

    }// TODO:implement buyBook method.

    public function showCategories(): JsonResponse
    {
        $categories = BookFacade::showCategories();

        return $this -> returnData('categories', $categories);
    }

    public function showCategory(IdRequest $request): JsonResponse
    {
        $dto = IdDto::id($request);

        $category = BookFacade::showCategory($dto);

        return $this -> returnData('category', $category);
    }



    public function rateBook(RateRequest $request): JsonResponse
    {

        $dto = RateDto::rate($request);

        $book = BookFacade::rateBook($dto);

        return $this -> returnData('book', $book);
    }


    // TODO: add rate controller.

    public function topTen(): JsonResponse
    {
        $topten = BookFacade::topTen();

        return $this -> returnData('top_ten', $topten);
    }
}
