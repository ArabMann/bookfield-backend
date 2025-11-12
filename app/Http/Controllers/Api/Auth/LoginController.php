<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    //
    public function authenticated(LoginRequest $request)
    {

        $validation = $request->validated();

        if (Auth::attempt($validation)) {
            Log::info("This Message From Login " . $validation["email"]);
            $user = Auth::user();
            $token = $user->createToken("myToken")->plainTextToken;

            return (new UserResource($user))->additional([
                "success" => true,
                "message" => "Berhasil Login",
                "Token" => $token,
            ]);
        };

        Log::info("Email " . $validation["email"] . " dan Password Salah");
        return response()->json([
            "success" => false,
            "message" => "Tidak Berhasil Login"
        ]);
    }
}
