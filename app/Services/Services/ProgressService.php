<?php

namespace App\Services\Services;

use App\DTO\BookMark\BookMarkDto;
use App\DTO\BookMark\getBookMarksDto;
use App\DTO\BookMark\showBookMarkDto;
use App\DTO\IdDto;
use App\DTO\Progress\EndTimeDto;
use App\DTO\Progress\ProgressDto;
use App\DTO\Progress\StartTimeDto;
use App\DTO\UserDto;
use App\DTO\WalletDto;
use App\Models\Book;
use App\Models\BookMark;
use App\Models\Progress;
use App\Services\Contracts\ProgressContract;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class ProgressService implements ProgressContract
{
    public function startRead(StartTimeDto $data): void
    {
        $progress = Progress::where('user_id', $data->user->id)
            ->where('book_id', $data->id)
            ->first();

        if ($progress) {
            $lastEndPage = $progress->end_page_number ?? 0;

            $progress->start_page_number = $data->startPage;
            $progress->start_time = Carbon::now();
            $progress->save();
        } else {
            Progress::create([
                'user_id' => $data->user->id,
                'book_id' => $data->id,
                'start_time' => Carbon::now(),
                'start_page_number' => $data->startPage,
            ]);
        }
    }


    public function endRead(EndTimeDto $data): ?Progress
    {
        $progress = Progress::where('user_id', $data->user->id)
            ->where('book_id', $data->id)
            ->first();

        if (!$progress) {
            return null;
        }

        $readTime = $progress->read_time;

        $progress->end_time = Carbon::now();
        $progress->end_page_number = $data->endPage;

        $start = Carbon::parse($progress->start_time);
        $end = Carbon::parse($progress->end_time);

        $diff = $end->diffInMinutes($start);

        $progress->read_time = $readTime->addMinutes($diff);

        $progress->save();

        return $progress;
    }


    public function showUserProgress(ProgressDto $data): Progress
    {
        return Progress::where('user_id', $data->user->id)
            -> get();
    }

    public function showProgresses(): Collection
    {
        return Progress::all();
    }

    public function predictProgress(IdDto $data): string
    {
        $wordsPerPage = 300;
        $wordsPerMinute = 200;

        $pageCount = Book::where('id', $data->id)
            -> first()
            -> pages_number;

        $totalWords = $pageCount * $wordsPerPage;

        $readingTimeMinutes = $totalWords / $wordsPerMinute;

        $readingTime = Carbon::now()->addMinutes($readingTimeMinutes);

        return $readingTime->format('Y-m-d H:i');
    }

    public function addToWallet(WalletDto $data): bool
    {
        $user = $data->user;
        if(!$user)
            return false;
        else
        {
            $user->wallet += $data->money;
            $user
                -> save();
            return true;
        }
    }

    public function showProgressForBook(IdDto $data)
    {
        $progress = Progress::where('user_id', $data->user->id)
            -> where('book_id', $data->id)
            -> first();

        return $progress->ratio;
    }

    public function showProgressForUser(UserDto $data): array
    {
        $book_ids = Progress::where('user_id', $data->user->id)
            -> where('ratio', '<', 100)
            -> get()
            -> pluck('book_id');

        $books = [];

        foreach($book_ids as $book_id)
        {
            $books[] = Book::where('id', $book_id)
                -> first();
        }

        return $books;
    }

    public function addBookMark(BookMarkDto $data): void
    {
        BookMark::create([
            'book_id' => $data->book_id,
            'user_id' => $data->user->id,
            'page_number' => $data->page_number,
            'book_mark' => $data->book_mark,
            'note' => $data->note,
        ]);
    }

    public function getBookMarks(getBookMarksDto $data): ?Collection
    {
        if($bookMark = BookMark::where('user_id', $data->user->id)
            -> where('book_id', $data->book_id)
            -> get()
            -> pluck('note', 'book_mark'))
            return $bookMark;

        return null;
    }

    public function showBookMark(showBookMarkDto $data): ?string
    {
        if($bookmark = BookMark::where('user_id', $data->user->id)
            -> where('book_id', $data->book_id)
            -> where('book_mark', $data->book_mark)
            -> first())
            return $bookmark->note;

        return null;
    }

    public function removeBookMark(showBookMarkDto $data): int
    {
        $bookmark = BookMark::where('user_id', $data->user->id)
            -> where('book_id', $data->book_id)
            -> where('book_mark', $data->book_mark)
            -> first();

        if(!$bookmark)
            return 0;

        $bookmark
            -> delete();

        return 1;
    }
}
