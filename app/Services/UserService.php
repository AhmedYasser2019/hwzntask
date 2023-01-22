<?php

namespace App\Services;

use Illuminate\Support\Facades\RateLimiter;

class UserService
{

    const MAX_TIME_EXCEEDED = 30;
    const NUMBER_OF_ALERT_TRIES = 3;
    const NUMBER_OF_BLOCK_TRIES = 4;
    const ALLOWED_DEVICES_NUMBER = 2;

    public function allowedTimeForEmail($email)
    {
        RateLimiter::hit($email, self::MAX_TIME_EXCEEDED);

    }

    public function blockUserAfterExceededMaximumTries($email) :bool
    {
        return RateLimiter::attempts($email) == self::NUMBER_OF_BLOCK_TRIES;
    }

    public function blockUser($user)
    {
        $user->update([
            'blocked' => true,
        ]);
    }

    public function alertUserAfterExceededMaximumTries($email) :bool
    {

       return RateLimiter::attempts($email) == self::NUMBER_OF_ALERT_TRIES;
    }

    public function checkIfUserBlocked($user)
    {
        return $user->blocked;
    }




}
