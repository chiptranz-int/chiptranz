<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApplicationHelper;
use App\Helpers\PaystackApi;
use App\Models\SteadySaving;
use App\Models\UserTransact;
use App\Models\YouthSaving;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ApiPaymentsController extends Controller
{
    //

    public function redirectToGateway()
    {
        $paystack = new PaystackApi();

        return $paystack->getAuthorizationUrl()->redirectNow();
    }

    public function handleGatewayCall($trxref)
    {


        $paystack = new PaystackApi();
        /*$paymentDetails =  ['data'=>
            array('reference'=>$trxref,
                'status'=>'success',
                'authorization'=>array(
                    'authorization_code'=>'Auth_test',
                    'last4'=>0567,
                    )

                )];*/

        $paymentDetails = $paystack->getPaymentData($trxref);
        if (!empty($paymentDetails)) {

            $reference = $paymentDetails->data->reference;
            $status = $paymentDetails->data->status;

            $code = $paymentDetails->data->authorization->authorization_code;
            $digit = $paymentDetails->data->authorization->last4;
            $bank = $paymentDetails->data->authorization->bank;
            $cardType = $paymentDetails->data->authorization->card_type;
            $expMonth = $paymentDetails->data->authorization->exp_month;
            $expYear = $paymentDetails->data->authorization->exp_year;


            // Now you have the payment details,
            // you can store the authorization_code in your db to allow for recurrent subscriptions
            // you can then redirect or do whatever you want


            if ($status == "success") {

                $user = Auth::user()->id;
                $transact = new UserTransact();
                $users = $transact->where('user_id', $user)
                    ->where('last_four_digit', $digit)
                    ->get()->toArray();
                if (empty($users[0])) {

                    $transacts = new UserTransact();
                    $transacts->user_id = $user;
                    $transacts->amount_deposited = 100;
                    $transacts->auth_code = $code;
                    $transacts->ref_no = $trxref;
                    $transacts->last_four_digit = $digit;
                    $transacts->bank_name = $bank;
                    $transacts->card_type = $cardType;
                    $transacts->expiry_date = $expYear . "-" . $expMonth . "-01";
                    $transacts->save();
                    $transactId = $transacts->id;

                    return response()->json([
                        'transaction_id' => $transactId,
                        'reference' => $trxref], 200);


                } else {

                    $transactId = $users[0]['id'];

                    return response()->json([
                        'transaction_id' => $transactId,
                        'reference' => $trxref], 200);

                }

            }
        }

    }

    public function handleGatewaySubsequentCall($trxref)
    {


        $paystack = new PaystackApi();
        /*$paymentDetails =  ['data'=>
            array('reference'=>$trxref,
                'status'=>'success',
                'authorization'=>array(
                    'authorization_code'=>'Auth_test',
                    'last4'=>0567,
                    )

                )];*/
        $help = new ApplicationHelper();
        $user = Auth::user();

            $paymentDetails = $paystack->getPaymentData($trxref);
        try {
            if (!empty($paymentDetails)) {
                $reference = $paymentDetails->data->reference;
                $status = $paymentDetails->data->status;

                $code = $paymentDetails->data->authorization->authorization_code;
                $digit = $paymentDetails->data->authorization->last4;
                $bank = $paymentDetails->data->authorization->bank;
                $cardType = $paymentDetails->data->authorization->card_type;
                $expMonth = $paymentDetails->data->authorization->exp_month;
                $expYear = $paymentDetails->data->authorization->exp_year;


                // Now you have the payment details,
                // you can store the authorization_code in your db to allow for recurrent subscriptions
                // you can then redirect or do whatever you want


                if ($status == "success") {


                    $transacts = new UserTransact();
                    $transacts->user_id = $user->id;
                    $transacts->amount_deposited = 100;
                    $transacts->auth_code = $code;
                    $transacts->ref_no = $reference;
                    $transacts->last_four_digit = $digit;
                    $transacts->bank_name = $bank;
                    $transacts->card_type = $cardType;
                    $transacts->expiry_date = $expYear . "-" . $expMonth . "-01";
                    $transacts->save();


                    if (!empty($transacts->id)) {
                        $goal = $help->getYouthGoals($user->id);
                        if (!empty($goal[0])) {
                            $this->saveAmount($goal[0]['id'], $transacts->id, new YouthSaving(), $reference);
                        } else {
                            $steady = $help->getSteadyGrowth($user->id);
                            if (!empty($steady[0])) {
                                $this->saveAmount($steady[0]['id'], $transacts->id, new SteadySaving(), $reference);
                            }
                        }
                    }


                }


                $cards = $help->getCardUserCards($user->id);
                $bank = $help->getAccountDetails($user->id);
                $banks = $help->getBankList();
                return response()->json(['success' => true, 'bank' => $bank, 'banks' => $banks, 'cards' => $cards, 'user' => $user], 200);
            }



        } catch (Exception $e) {

        }

        return response()->json(['success' => false,$paymentDetails], 402);


    }


    public function saveAmount($id, $transactId, $savings, $ref_no)
    {

        $savings->plan_id = $id;
        $savings->user_id = Auth::user()->id;
        $savings->amount_deposited = 100;
        $savings->ref_no = $ref_no;
        $savings->date_deposited = Carbon::now();
        $savings->transact_id = $transactId;
        $savings->status = 1;
        $savings->save();
    }

    public function saveUserAmount(Request $request)
    {

        $amount = $request->get('amounts');
        $planId = $request->get('plan_id');
        $transactId = $request->get('transact_id');
        $planType = $request->get('plan_type');
        $user = Auth::user();

        $help = new ApplicationHelper();
        $authCode = $help->getCardAuthCode($transactId);
        if (!empty($authCode)) {

            $results = $help->recurrentCharge($authCode, ($amount * 100), $user->email);
            $saved = $help->verifyAndSafeOneTime($results, $planId, $user->id, $help->getToday(), $amount, $planType);

            if ($saved) {
                return response()->json(['success' => true], 200);
            }
        }
        return response()->json(['success' => false], 402);


    }
}
