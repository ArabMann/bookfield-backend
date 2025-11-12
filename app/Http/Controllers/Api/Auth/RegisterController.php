<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    //

    public function store(StoreRegisterRequest $request){
        
        $response = DB::transaction(function ()use($request){
            $validation = $request->validated();
            $validation["role_id"] = 2;

            $userRegister = User::create($validation);

            return (new UserResource($userRegister))->additional([
                "success" => true,
                "message" => "Anda Berhasil Membuat Account"
            ]);
        });

        return $response;
    }
}
