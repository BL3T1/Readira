<?php

namespace App\Http\Controllers\User;

use App\DTO\Collection\CreateCollectionDto;
use App\DTO\Collection\RemoveCollectionDto;
use App\DTO\Collection\RemoveFromCollectionDto;
use App\DTO\Collection\UpdateCollectionDto;
use App\DTO\IdDto;
use App\DTO\UserDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Collection\CreateCollectionRequest;
use App\Http\Requests\Collection\RemoveCollectionRequest;
use App\Http\Requests\Collection\RemoveFromCollectionRequest;
use App\Http\Requests\Collection\UpdateCollectionRequest;
use App\Http\Requests\DeleteCRequest;
use App\Http\Requests\IdRequest;
use App\Services\Facades\CollectionFacade;
use App\Traits\GeneralTraits;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    use GeneralTraits;

    public function makeCollection(CreateCollectionRequest $request): JsonResponse
    {
        $dto = CreateCollectionDto::create($request);

        $collection = CollectionFacade::createCollection($dto);

        if(!$collection)
        {
            if($this -> getCurrentLang() == 'ar')
                return $this -> returnError(400, 'هذه المكتبة موجودة بالفعل');
            return $this -> returnError(400, 'This Library is already exist');
        }

        if($this -> getCurrentLang() == 'ar')
            return $this -> returnSuccessMessage(200, 'تم إضافة المكتبة بنجاح');
        return $this -> returnSuccessMessage(200, 'The Library Has Been Added Successfully');
    }

    public function addToCollection(UpdateCollectionRequest $request): JsonResponse
    {
        $dto = UpdateCollectionDto::update($request);

        $collection = CollectionFacade::insertIntoCollection($dto);

        $op = $collection[0];
        $name = $collection[1];

        if($op == 0)
        {
            if($this -> getCurrentLang() == 'ar')
                return $this -> returnError(400, "بالفعل $name الكتاب موجود في");
            return $this -> returnError(400, "The Books Is Already In $name");
        }

        if($this -> getCurrentLang() == 'ar')
            return $this -> returnSuccessMessage(200, "بنجاح $name تم إضافة الكتاب إلى ");
        return $this -> returnSuccessMessage(200, "The Books Has Been Add To $name Successfully");
    }

    public function getCollections(Request $request): JsonResponse
    {
        $dto = UserDto::user($request);

        $collections = CollectionFacade::getCollections($dto);

        return $this -> returnData('collections', $collections);
    }

    public function getCollectionContent(CreateCollectionRequest $request): JsonResponse
    {
        $dto = CreateCollectionDto::create($request);

        $collection_content = CollectionFacade::getCollectionContent($dto);

        return $this -> returnData('collection_content', $collection_content);
     }

    public function removeCollection(RemoveCollectionRequest $request): JsonResponse
    {
        $dto = RemoveCollectionDto::remove($request);

        $op = CollectionFacade::removeCollection($dto);

        if($op == 0)
        {
            if($this -> getCurrentLang() == 'ar')
                return $this -> returnError(400, 'المجموعة غير موجودة');
            return $this -> returnError(400, 'There Is No Collection Like This');
        }

        if($this -> getCurrentLang() == 'ar')
            return $this -> returnSuccessMessage(200, 'تم حذف المجموعة بنجاح');
        return $this -> returnSuccessMessage(200, 'The Collection Has Been Deleted Successfully');
    }

    public function removeFromCollection(RemoveFromCollectionRequest $request): JsonResponse
    {
        $dto = RemoveFromCollectionDto::remove($request);

        $data = CollectionFacade::removeFromCollection($dto);

        if($data[0] == 0) {
            if ($this->getCurrentLang() == 'ar')
                return $this->returnSuccessMessage(200, "لم يتم العثور على الكتاب او على المجموعة");
            return $this->returnSuccessMessage(200, "Book or Collection not found");
        }

        if($data[0] == -1) {
            if ($this->getCurrentLang() == 'ar')
                return $this->returnError(400, "فشل إزالة الكتاب من المكتبة");
            return $this->returnError(400, "Failed to remove book from collection");
        }
        if ($this->getCurrentLang() == 'ar')
            return $this->returnSuccessMessage(200, "تمت إزلة الكتاب من المكتبة بنجاح");
        return $this->returnSuccessMessage(200, "The Book Has Been Removed Successfully");
    }

    public function addToFavorite(IdRequest $request): JsonResponse
    {
        $dto = IdDto::id($request);

        $op = CollectionFacade::insertIntoFavorite($dto);

        if($op == 0)
        {
            if($this -> getCurrentLang() == 'ar')
                return $this -> returnError(400, 'الكتاب موجود في المفضلة بالفعل');
            return $this -> returnError(400, 'The Books Is Already In The Favorite');

        }

        if($this -> getCurrentLang() == 'ar')
            return $this -> returnSuccessMessage(200, 'تم إضافة الكتاب إلى المفضلة بنجاح');
        return $this -> returnSuccessMessage(200, 'The Books Has Been Added To Favorite Successfully');
    }

    public function getFavorite(Request $request): JsonResponse
    {
        $dto = UserDto::user($request);

        $favorites = CollectionFacade::getFavorite($dto);

        return $this -> returnData('favorites', $favorites);
    }

    public function removeFromFavorite(IdRequest $request): JsonResponse
    {
        $dto = IdDto::id($request);

        $op = CollectionFacade::removeFromFavorite($dto);

        if($op == 0)
        {
            if($this -> getCurrentLang() == 'ar')
                return $this -> returnError(400, 'هذا الكتاب غير موجود في المفضلة');
            return $this -> returnError(400, 'The Books Is Not in The Favorite Already');
        }
        if($this -> getCurrentLang() == 'ar')
            return $this -> returnSuccessMessage(200, 'تم إزالة الكتاب من المفضلة بنجاح');
        return $this -> returnSuccessMessage(200, 'The Books Has Been Removed From Favorite Successfully');
    }


}
