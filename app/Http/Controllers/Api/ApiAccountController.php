<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAccountController extends Controller
{
    //
    public function verifyOldPassword(Request $request)
    {
        $password = Hash::make($request->get('old-password'));
        $user = Auth::user();
        if ($user->password == $password) {
            return response()->json(['success'], 200);
        }

        return response()->json(['failed'], 300);
    }

    public function processPasswordChange(Request $request)
    {

        $password = $request->get('password');

        $passwordConfirm = $request->get('password_confirmation');

        $validator = Validator::make($request->all(), [

            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = new User();

        $user->where('id', Auth::user()->id)->update([

            'password' => Hash::make($password),
        ]);

        return response()->json(['success'=>true], 200);
    }
}
