<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApplicationHelper;
use App\Models\NextKin;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiHomeController extends Controller
{
    //

    public function getUser(Request $request)
    {


        return response()->json(Auth::user(), 200);
        // return response()->json(['success' => false], 200);

    }

    public function getNextKin()
    {

        $help = new ApplicationHelper();
        $user = Auth::user();
        $kin = $help->nextKin($user->id);
        if (empty($kin)) {
            $kin = array(

                'name' => '',
                'last_name' => '',
                'email' => '',
                'telephone' => '',
                'bank_account' => '',
                'bank_name' => '',
                'gender' => null,

            );


        }


        return response()->json(['kin' => $kin, 'user' => $user], 200);

    }

    public function saveNextKin(Request $request)
    {

        $name = $request->get('name');
        $lastName = $request->get('last_name');
        $email = $request->get('email');
        $telephone = $request->get('telephone');
        $bankAccount = $request->get('bank_account');
        $bankName = $request->get('bank_name');
        $gender = $request->get('gender');

        $help = new ApplicationHelper();
        $user = Auth::user();
        $kin = $help->nextKin($user->id);

        if (empty($kin)) {

            $kin = new NextKin();
            $kin->user_id = $user->id;
            $kin->name = $name;
            $kin->last_name = $lastName;
            $kin->email = $email;
            $kin->telephone = $telephone;
            $kin->bank_account = $bankAccount;
            $kin->bank_name = $bankName;
            $kin->gender = $gender;
            $kin->save();

        } else {
            $kin = new NextKin();
            $kin->where('user_id', $user->id)->update([
                'name' => $name,
                'last_name' => $lastName,
                'email' => $email,
                'telephone' => $telephone,
                'bank_account' => $bankAccount,
                'bank_name' => $bankName,
                'gender' => $gender,
            ]);

        }


        return response()->json($user, 200);

    }


    public function getSummary()
    {

        $user = Auth::user();

        $help = new ApplicationHelper();

        $activity = $help->userActivity($user->id);

        $activePlans = $help->activePlans($user->id);

        $youthSummary = $help->savingsOnYouthPlan($user->id);

        $steadySummary = $help->savingsOnSteadyPlan($user->id);

        $savingsSummary = array(

            'balance' => round(($youthSummary['balance'] + $steadySummary['balance']), 2),
            'savings' => round(($youthSummary['savings'] + $steadySummary['savings']), 2),
            'returns' => round(($youthSummary['returns'] + $steadySummary['returns']), 2),
            'withdrawals' => round(($youthSummary['withdrawals'] + $steadySummary['withdrawals']), 2),
        );


        $savingsHistory = $help->getYouthSavingsByUserId($user->id);

        return response()->json(['user' => $user, 'activity' => $activity, 'savingsHistory' => $savingsHistory, 'activePlans' => $activePlans, 'savingsSummary' => $savingsSummary], 200);

    }


    public function updateUser(Request $request)
    {

        $name = $request->get('name');

        $lastName = $request->get('last_name');

        $telephone = $request->get('telephone');

        $gender = $request->get('gender');

        $birth = $request->get('birth_date');


        $user = Auth::user();

        $userId = $user->id;

        $person = new User();

        $me = $person->where('id', $userId)->update([
            'name' => $name,
            'last_name' => $lastName,
            'telephone' => $telephone,
            'gender' => $gender,
            'birth_date' => $birth,
        ]);

        if ($me) {

            return response()->json(['success' => true], 200);
        }
        return response()->json(['success' => false], 402);

    }


    public function changePassword(Request $request)
    {

        /*
                $oldPassword = $request->get('old_password');





               // $pass =  Auth::attempt(['email' => $user, 'password' => $request->get('old_password')]);
                if (!Hash::check('old_password', $user->getAuthPassword())) {
                   return response()->json(['error' => ['Old Password Confirmation Failed']], 401);
                }
         */

        $user = Auth::user();
        $validator = Validator::make($request->all(), [

            'password' => ['required', 'string', 'min:8'],
            'password_confirmation' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $newUser = new User();
        $newUser->where('id', $user->id)->update([
            'password' => Hash::make($request->get('password')),
        ]);

        return response()->json(['success' => true, 'message' => 'Password Successfully Changed'], 200);
    }
}
