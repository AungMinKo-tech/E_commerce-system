<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    //redirect
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    //callback
    public function callback($provider)
    {
        $socialLoginData = Socialite::driver($provider)->user();

        // dd($socialLoginData);

        $user = User::updateOrCreate([
            'provider_id' => $socialLoginData->id,
        ], [
            'name' => $socialLoginData->name,
            'email' => $socialLoginData->email,
            'nickname' => $socialLoginData->nickname,
            // 'profile'=> $socialLoginData->profile,
            'provider' => $provider,
            'provider_id' => $socialLoginData->id,
            'provider_token' => $socialLoginData->token,
        ]);

        Auth::login($user);

        return to_route('user#home');
    }
}
