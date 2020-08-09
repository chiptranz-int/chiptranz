<?php

namespace App\Http\Controllers\Api;



use App\Helpers\ApplicationHelper;
use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\User;
use Carbon\Carbon;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ApiResetPasswordController extends Controller
{
    //


    use ResetsPasswords;




    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user)
            return response()->json([
                'success'=>false,
                'message' => "We can't find a user with that e-mail address."
            ], 404);
        $token = app(PasswordBroker::class)->createToken($user);

        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => $token,
             ]
        );
        if ($user && $passwordReset)
            $user->notify(
                new PasswordResetRequest($passwordReset->token."?email=".$user->email)
            );
        return response()->json([
            'success'=>true,
            'message' => 'We have e-mailed your password reset link!'
        ],200);

    }
    /**
     * Find token password reset
     *
     * @param  [string] $token
     * @return [string] message
     * @return [json] passwordReset object
     */
    public function findToken($token)
    {
        $passwordReset = PasswordReset::where('token', $token)
            ->first();
        if (!$passwordReset)
            return response()->json([
                'success'=>false,
                'message' => 'This password reset token is invalid.'
            ], 404);
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json([
                'success'=>false,
                'message' => 'This password reset token is invalid.'
            ], 404);
        }
        return response()->json($passwordReset);
    }
     /**
     * Reset password
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @param  [string] token
     * @return [string] message
     * @return [json] user object
     */
   /* public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed',
            'token' => 'required|string'
        ]);
        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();
        if (!$passwordReset)
            return response()->json([
                'success'=>false,
                'message' => 'This password reset token is invalid.'
            ], 404);
        $user = User::where('email', $passwordReset->email)->first();
        if (!$user)
            return response()->json([
                'success'=>false,
                'message' => "We can't find a user with that e-mail address."
            ], 404);
        $user->password = Hash::make($request->password);
        $user->save();
        $passwordReset->delete();
        $user->notify(new PasswordResetSuccess($passwordReset));
        return response()->json($user);
    }
*/
    public function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
            $this->resetPassword($user, $password);
        }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
            ?  response()->json(['success'=>true,'message'=>trans($response)],200)
            : response()->json(['success'=>false, 'message'=>trans($response)],402);
    }
}
