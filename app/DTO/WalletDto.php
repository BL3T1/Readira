<?php

namespace App\DTO;

use App\Http\Requests\WalletRequest;
use App\Models\User;

class WalletDto
{
    public function __construct(
        public readonly User $user,
        public readonly int $money,
    )
    {
    }

    public function chargeWallet(WalletRequest $request):WalletDto
    {
        return new self(
            user: $request->user(),
            money: $request->money,
        );
    }
}
