<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ApiLoginRequest;
use App\Repositories\Contracts\IUser;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponse;

    public function login(ApiLoginRequest $request, IUser $userRepository)
    {

        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {

            // store device
            $userRepository->storeDevice($request, auth()->id());
            //

            if (auth()->user()->devices()->count() < 3) {
                return $this->apiResponse(
                    'success login',
                    200,
                    [
                        'name' => auth()->user()->name,
                        'email' => auth()->user()->email,
                        'token' => Auth::user()->createToken('LaravelSanctumAuth')->plainTextToken,
                    ]
                );
            } else {
                return $this->apiResponse(
                    'You Are Logged in from two devices',
                    412,
                    null
                );
            }

        } else {
            return $this->apiResponse(
                'wrong credentials',
                412,
                null
            );
        }


    }
}
