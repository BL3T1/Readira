<?php

namespace App\Services\Contracts;

use App\DTO\BookMark\BookMarkDto;
use App\DTO\BookMark\getBookMarksDto;
use App\DTO\BookMark\showBookMarkDto;
use App\DTO\IdDto;
use App\DTO\Progress\EndTimeDto;
use App\DTO\Progress\ProgressDto;
use App\DTO\Progress\StartTimeDto;
use App\DTO\UserDto;
use App\DTO\WalletDto;
use App\Models\Progress;
use Illuminate\Support\Collection;

interface ProgressContract
{

    public function startRead(StartTimeDto $data): void;

    public function endRead(EndTimeDto $data): ?Progress;

    public function showUserProgress(ProgressDto $data): Progress;

    public function showProgresses(): Collection;

    public function predictProgress(IdDto $data): string;

    public function addToWallet(WalletDto $data): bool;

    public function showProgressForBook(IdDto $data);

    public function showProgressForUser(UserDto $data): array;

    public function addBookMark(BookMarkDto $data): void;

    public function getBookMarks(getBookMarksDto $data): ?Collection;

    public function showBookMark(showBookMarkDto $data): ?string;

    public function removeBookMark(showBookMarkDto $data): int;
}
