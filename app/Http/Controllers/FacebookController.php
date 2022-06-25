<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Socialite;
use Exception;


class FacebookController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleFacebookCallback()
    {
        //try {
            $user = Socialite::driver('facebook')->user();
            $create['name'] = $user->getName();
            $create['email'] = $user->getEmail();
            $create['password'] = 'default';

            $createdUser = User::updateOrCreate($create, ['facebook_id' => $user->getId()]);

            
            Auth::loginUsingId($createdUser->id);

            return redirect('home');

        /*} catch (Exception $e) {
            return redirect('auth/facebook');
        }*/
    }
}