<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Auth\AuthLogin;
use App\Http\Requests\Auth\AuthRegister;
use App\Http\Resources\AuthResource;
use App\Models\ShoppingSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends ApiController
{
    public function register(AuthRegister $request){
        $user = User::create($request->validated());
        $user->assignRole("user");
        $user->sendEmailVerificationNotification();
        ShoppingSession::create(["user_id"=>$user->id]);
        return $this->successResponse("Başarılı bir şekilde kayıt oldunuz. Lütfen email adresinizi onaylayınız.");
    }

    public function login(AuthLogin $request)
    {
        if(Auth::attempt(["email"=>$request->email,"password"=>$request->password],$request->remember_me)){
            $response = [
                "user" => AuthResource::make(auth()->user()->load("cart")),
                "token" => auth()->user()->createToken("token_name")->plainTextToken
            ];
            return $this->successResponse($response);
        }
        return $this->errorResponse("Böyle bir kullanıcı bulunamadı.",404);
    }


    public function verify_resend(Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('success', 'Onaylama e-postası terkardan gönderildi.');
    }
}

