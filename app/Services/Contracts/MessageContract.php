<?php

namespace App\Services\Contracts;

use App\DTO\MessageDto;

interface MessageContract
{

    public function sendMessage(MessageDto $data);

}
