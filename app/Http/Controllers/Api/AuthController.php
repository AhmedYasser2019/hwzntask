<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Contracts\IUser;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponse;

    public function login(Request $request, IUser $user)
    {

        $validation = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
            'password' => 'required',
            'device' => 'required', // device name
            'device_id' => 'required', // device Id
            'type' => 'required',
        ]);
        if ($validation->fails()) {
            $data = $validation->errors()->first();
            return $this->apiResponse($data, 422, null);
        }


        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {

            // store device
            $user->storeDevice($request, auth()->id());
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
