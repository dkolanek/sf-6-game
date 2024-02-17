<?php

namespace App\Message;

class SmsKey
{
    public function __construct(
        private int $userId
    )
    {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

}
