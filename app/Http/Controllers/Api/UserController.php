<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public $successStatus = 200;

    public function login()
    {

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('ChipTranz')->accessToken;
            return response()->json(['success' => $success,'user'=>$user], $this->successStatus);
        } else {
            return response()->json(['error' => 'Invalid Authentication'], 401);
        }
    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'telephone' => ['required', 'numeric', 'min:10'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('ChipTranz')->accessToken;
        //$success['name'] = $user->name;
        //$success['last_name'] = $user->last_name;
        return response()->json(['success' => $success,'user'=>$user], $this->successStatus);

    }
}