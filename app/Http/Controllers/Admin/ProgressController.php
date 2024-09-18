<?php

namespace App\Http\Controllers\Admin;

use App\DTO\BookMark\BookMarkDto;
use App\DTO\BookMark\getBookMarksDto;
use App\DTO\BookMark\showBookMarkDto;
use App\DTO\IdDto;
use App\DTO\Progress\EndTimeDto;
use App\DTO\Progress\ProgressDto;
use App\DTO\Progress\StartTimeDto;
use App\DTO\WalletDto;
use App\DTO\UserDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\IdRequest;
use App\Http\Requests\Progress\BookMark\BookMarkRequest;
use App\Http\Requests\Progress\BookMark\getBookMarksRequest;
use App\Http\Requests\Progress\BookMark\showBookMarkRequest;
use App\Http\Requests\Progress\EndTimeRequest;
use App\Http\Requests\Progress\ProgressRequest;
use App\Http\Requests\Progress\StartTimeRequest;
use App\Http\Requests\WalletRequest;
use App\Services\Facades\ProgressFacade;
use App\Traits\GeneralTraits;
use Illuminate\Http\JsonResponse;

class ProgressController extends Controller
{

    use GeneralTraits;

    public function startRead(StartTimeRequest $request): void
    {
        $dto = StartTimeDto::startTime($request);

        $progress = ProgressFacade::startRead($dto);
    }

    public function endRead(EndTimeRequest $request): JsonResponse
    {
        $dto = EndTimeDto::endTime($request);

        $progress = ProgressFacade::endRead($dto);

        return $this->returnData('progress', $progress);
    }

    public function showProgresses(): JsonResponse
    {
        $progresses = ProgressFacade::showProgresses();

        return $this -> returnData('progress', $progresses);
    }

    public function showUserProgress(ProgressRequest $request): JsonResponse
    {
        $dto = ProgressDto::progress($request);

        $progress = ProgressFacade::showUserProgress($dto);

        return $this->returnData('progress', $progress);
    }

    public function predictProgress(IdRequest $request): JsonResponse
    {
        $dto = IdDto::id($request);

        $prediction = ProgressFacade::predictProgress($dto);

        return $this->returnData('prediction', $prediction);
    }

    public function addToWallet(WalletRequest $request): JsonResponse
    {
        $dto = WalletDto::chargeWallet($request);

        $wallet = ProgressFacade::addToWallet($dto);

        return $this->returnData('wallet', $wallet);
    }

    public function showProgressForBook(IdRequest $request): JsonResponse
    {
        $dto = IdDto::id($request);

        $progressRatio = ProgressFacade::showProgressForBook($dto);

        return $this -> returnData('Progress Ratio', $progressRatio);
    }

    public function showProgressForUser(Request $request): JsonResponse
    {
        $dto = UserDto::user($request);

        $books = ProgressFacade::showProgressForUser($dto);

        return $this -> returnData('Books the user is reading right now', $books);
    }

    public function addBookMark(BookMarkRequest $request): JsonResponse
    {
        $dto = BookMarkDto::bookMark($request);

        ProgressFacade::addBookMark($dto);

        if($this -> getCurrentLang() == 'ar')
            return $this -> returnSuccessMessage(200, 'تم إضافة العلامة بنجاح');
        return $this -> returnSuccessMessage(200, 'The BookMark Has Been Added Successfully');
    }

    public function getBookMarks(getBookMarksRequest $request): JsonResponse
    {
        $dto = getBookMarksDto::bookMark($request);

        $bookMarks = ProgressFacade::getBookMarks($dto);

        if(!$bookMarks)
            return $this -> returnError(400, 'There is no bookmarks on this book');

        return $this -> returnData('BookMarks', $bookMarks);
    }

    public function showBookMark(showBookMarkRequest $request): JsonResponse
    {
        $dto = showBookMarkDto::bookMark($request);

        $bookMark = ProgressFacade::showBookMark($dto);

        if(!$bookMark)
            return $this -> returnError(400, 'There is no bookmark like this');

        return $this -> returnData('BookMark', $bookMark);
    }

    public function removeBookMark(showBookMarkRequest $request): JsonResponse
    {
        $dto = showBookMarkDto::bookMark($request);

        $bookMark = ProgressFacade::removeBookMark($dto);

        if($this -> getCurrentLang() == 'ar')
            return $this -> returnSuccessMessage(200, 'تم إزلة العلامة بنجاح');
        return $this -> returnSuccessMessage(200, 'The BookMark Has Been Deleted Successfully');
    }
}
