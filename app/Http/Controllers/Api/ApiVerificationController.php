<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ApiVerificationController extends Controller
{
    //

    use VerifiesEmails;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');

    }

    public function verifyUser($token)
    {
        $verifyUser = VerifyUser::where('token', $token)->first();
        if (isset($verifyUser)) {
            $user = $verifyUser->user;
            if (!$user->verified) {
                $verifyUser->user->verified = 1;
                $verifyUser->user->save();
                $status = "success";
            } else {
                $status = "already-verified";
            }
            return new RedirectResponse(env("yourdomain")+"/profile/edit?verified=$status");
        } else {
            $status = "duplicate-email";
            return new RedirectResponse(env("yourdomain")+"/profile/edit?verified=$status");
        }
        return new RedirectResponse(env("yourdomain")+"?andParams=$status");

    }
}
