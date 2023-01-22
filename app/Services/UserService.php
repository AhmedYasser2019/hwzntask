<?php

namespace App\Services;

use Illuminate\Support\Facades\RateLimiter;

class UserService
{

    const MAX_TIME_EXCEEDED = 30;
    const NUMBER_OF_ALERT_TRIES = 3;
    const NUMBER_OF_BLOCK_TRIES = 4;

    public function allowedTimeForEmail($email)
    {
        RateLimiter::hit($email, self::MAX_TIME_EXCEEDED);

    }

    public function blockUserAfterExceededMaximumTries($user)
    {
        if (RateLimiter::attempts($user->email) == self::NUMBER_OF_BLOCK_TRIES) {
            $this->blockUser($user);
        }
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
