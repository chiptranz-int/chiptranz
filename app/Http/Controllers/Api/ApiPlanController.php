<?php


namespace App\Http\Controllers\Api;


use App\Helpers\ApplicationHelper;
use App\Helpers\PaystackApi;
use App\Helpers\PlanHelper;
use App\Http\Controllers\Controller;
use App\Models\AccountDetail;
use App\Models\SteadyGrowth;
use App\Models\SteadySaving;
use App\Models\SteadyWithdrawal;
use App\Models\UserTransact;
use App\Models\YouthGoal;
use App\Models\YouthSaving;
use App\Models\YouthWithdrawal;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiPlanController extends Controller
{


    public function createFirstSavings(Request $request)
    {

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'plan_name' => ['required', 'string', 'max:255'],
            'frequency' => ['required', 'numeric'],
            'reference' => ['required', 'string', 'max:255'],
            'plan_type' => ['required', 'numeric'],
            'start_date' => ['required', 'date'],
            'withdrawal_date' => ['required', 'date'],
            'amounts' => ['required', 'numeric'],

        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();
        $reference = $input['reference'];

        $pay = new PaystackApi();


        $saved = 0;
        try {
            $paymentDetails = $pay->getPaymentData($reference);

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


                    $planType = $input['plan_type'];
                    if (!empty($transacts->id)) {

                        if ($planType == 0) {

                            $input['transact_id'] = $transacts->id;
                            $input['frequency_id'] = 1;
                            $input['user_id'] = $user->id;
                            $input['status'] = 0;

                            $youth = YouthGoal::create($input);

                            $saved = $this->saveAmount($youth->id, $transacts->id, new YouthSaving(), $reference, 100);
                        } else {
                            $input['transact_id'] = $transacts->id;
                            $input['frequency_id'] = 2;
                            $input['user_id'] = $user->id;
                            $input['status'] = 0;

                            $steady = SteadyGrowth::create($input);

                            $saved = $this->saveAmount($steady->id, $transacts->id, new SteadySaving(), $reference, 100);
                        }
                    }


                }
            } else {
                return response()->json(['error' => 'Payment cannot be verified'], 402);
            }
        } catch (Exception $e) {

        }


        // $cards = $help->getCardUserCards($user->id);
        // $bank = $help->getAccountDetails($user->id);
        // $banks = $help->getBankList();
        //return response()->json(['bank' => $bank, 'banks' => $banks, 'cards' => $cards, 'user' => $user], 200);

        if ($saved > 0) {
            $help = new ApplicationHelper();
            $help->updateUserFlag(1);
            return response()->json(['success' => true], 200);
        }


        return response()->json(['error' => 'Payment not successful'], 402);


    }

    public function saveAmount($id, $transactId, $savings, $ref_no, $amount)
    {

        $savings->plan_id = $id;
        $savings->user_id = Auth::user()->id;
        $savings->amount_deposited = $amount;
        $savings->ref_no = $ref_no;
        $savings->date_deposited = Carbon::now();
        $savings->transact_id = $transactId;
        $savings->status = 1;
        $savings->save();
        return $savings->id;
    }

    public function payStackDetails()
    {
        $help = new PlanHelper();

        return response()->json($help->payStackInformation(), 200);
    }

    public function savePlanSetup(Request $request)
    {

        $user = Auth::user();
        $planType = $request->get('plan_type');
        $help = new ApplicationHelper();

        $saved = 0;
        if ($planType == 0) {

            $saved = $help->saveYouthGoal($request);
            $help->createYouthSavings($saved, $user->id, $help->getToday(), $request->get('amounts'), $request->get('reference'), 1, 1);

        } elseif ($planType == 1) {
            $saved = $help->saveSteadyGrowth($request);
            $help->createSteadySavings($saved, $user->id, $help->getToday(), $request->get('amounts'), $request->get('reference'), 1, 1);
        }

        if ($saved > 0) {

            $help->updateUserFlag(1);
        }

        return response()->json(['success' => true], 200);


    }

    public function saveNewPlanSetup(Request $request)
    {

        $user = Auth::user();
        $planType = $request->get('plan_type');
        $help = new ApplicationHelper();

        $saved = 0;
        try {
            if ($planType == 0) {

                $saved = $help->saveYouthGoal($request);

            } elseif ($planType == 1) {
                $saved = $help->saveSteadyGrowth($request);
            }

        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => 'Plan Creation Failed'], 402);
        }

        if ($saved > 0) {

            return response()->json(['success' => true, 'message' => 'New Plan Successfully Created'], 200);
        }
        return response()->json(['success' => false, 'error' => 'Plan Creation Failed'], 402);

    }


    public function steadyPlan()
    {

        $help = new ApplicationHelper();

        $user = Auth::user();
        $steady = $this->collatePlansSteady($help->collateSteadySavings($help->getSteadyGrowth($user->id)), 1);
        $cards = $help->getCardUserCards($user->id);
        return response()->json(['user' => $user, 'steady' => $steady, 'cards' => $cards], 200);
    }


    public function youthPlan()
    {

        $help = new ApplicationHelper();

        $user = Auth::user();

        $youth = $this->collatePlans($help->collateYouthSavings($help->getYouthGoals($user->id)), 0);
        $cards = $help->getCardUserCards($user->id);
        return response()->json(['user' => $user, 'youth' => $youth, 'cards' => $cards], 200);
    }

    public function collatePlans($plans, $planType)
    {
        $newPlans = array();

        $help = new ApplicationHelper();

        foreach ($plans as $plan) {
            $saved = $help->totalSaved($plan['user_id'], $plan['id'], $planType);

            $plan['total_saved'] = $saved;
            $plan['interest_rate'] = $help->getInterestRate($plan['frequency_id'], $plan['frequency']);
            $plan['next_save'] = $help->getYouthNextSavingDate($plan['id'], $plan['user_id'], $plan['frequency'], $plan['start_date'], $plan['withdrawal_date'], $plan['status']);
            $plan['plan_card'] = $help->getCardOnPlan($plan['transact_id']);

            //$plan['cards'] = $help->getCardUserCards($plan['user_id']);
            $newPlans[] = $plan;
        }

        return $newPlans;
    }

    public function collatePlansSteady($plans, $planType)
    {
        $newPlans = array();

        $help = new ApplicationHelper();

        foreach ($plans as $plan) {
            $saved = $help->totalSaved($plan['user_id'], $plan['id'], $planType);

            $plan['total_saved'] = $saved;
            $plan['interest_rate'] = $help->getInterestRate($plan['frequency_id'], $plan['frequency']);
            $plan['next_save'] = $help->getSteadyNextSavingDate($plan['id'], $plan['user_id'], $plan['frequency'], $plan['start_date'], $plan['withdrawal_date'], $plan['status']);
            $plan['plan_card'] = $help->getCardOnPlan($plan['transact_id']);

            //$plan['cards'] = $help->getCardUserCards($plan['user_id']);
            $newPlans[] = $plan;
        }

        return $newPlans;
    }


    public function youthSavings($planId)
    {

        $help = new ApplicationHelper();

        $user = Auth::user();
        $youth = $help->collateYouthSavings([$help->getYouthGoalById($planId)]);
        $savings = $help->getYouthSavings($planId, $user->id);
        $withdrawals = $help->getYouthWithdrawalsById($planId, $user->id);
        return response()->json(['youth' => $youth, 'youthSavings' => $savings, 'withdrawals' => $withdrawals], 200);


    }

    public function steadySavings($planId)
    {
        $help = new ApplicationHelper();

        $user = Auth::user();
        $steady = $help->collateSteadySavings([$help->getSteadyGrowthById($planId)]);
        $savings = $help->getSteadySavings($planId, $user->id);
        $withdrawals = $help->getSteadyWithdrawalsById($planId, $user->id);
        return response()->json(['steadySavings' => $savings, 'steady' => $steady, 'withdrawals' => $withdrawals], 200);
    }


    public function updateYouthGoals(Request $request)
    {

        $help = new ApplicationHelper();
        $savings = $help->updateYouthGoals($request);
        if ($savings) {

            return response()->json(['success' => true], 200);
        }

        return response()->json(['success' => false], 402);

    }

    public function updateSteadyGrowth(Request $request)
    {

        $help = new ApplicationHelper();
        $savings = $help->updateSteadyGrowth($request);

        if ($savings) {

            return response()->json(['success' => true], 200);
        }

        return response()->json(['success' => false], 402);


    }

    public function getPlans()
    {

        $user = Auth::user();
        $help = new ApplicationHelper();

        $youth = $help->collateYouthSavings($help->getYouthGoals($user->id));
        $steady = $help->collateSteadySavings($help->getSteadyGrowth($user->id));

        $plans = array_merge($youth, $steady);
        $cards = $help->getCardUserCards($user->id);
        return response()->json(['plans' => $plans, 'cards' => $cards, 'user' => $user], 200);

    }

    public function payOptions()
    {

        $user = Auth::user();

        $help = new PlanHelper();
        $cards = $help->getCardUserCards($user->id);
        $bank = $help->getAccountDetails($user->id);
        $banks = $help->getBankList();
        if(!empty($bank)){
$bank['bank_name'] = $this->getBankName($banks,$bank['bank_code']);

        }

        return response()->json(['bank' => $bank, 'cards' => $cards, 'user' => $user], 200);

    }

    public function getBankName($banks, $code){

        foreach ($banks as $bank){
            if($code == $bank['code']){
                return $bank['name'];
            }
        }
        return "";
    }

    public function removeCard($cardId)
    {

        $user = Auth::user();

        $help = new PlanHelper();
        $count = $help->countUserCard($user->id);
        if ($count > 1) {
            $num = $help->removeCardById($cardId);
            if ($num > 0) {
                $transactId = $help->getLastUserCard($user->id);
                if ($transactId != 0) {
                    $help->updateAllPlanOnOldCard($cardId, $transactId, $user->id);
                }
            }


            $cards = $help->getCardUserCards($user->id);
            $bank = $help->getAccountDetails($user->id);


            return response()->json(['success' => true, 'bank' => $bank, 'cards' => $cards, 'user' => $user], 200);
        } else {
            return response()->json(['success' => false], 402);
        }
    }

    public function sendConfirmation()
    {
        //send verification code
        $user = Auth::user();
        $telephone = $user->telephone;
        if (substr($telephone, 0, 1) == "0") {
            $telephone = "+234" . substr($telephone, 1, strlen($telephone) - 2);
        } elseif (substr($telephone, 0, 1) == "2") {

            $telephone = "+" . substr($telephone, 0, strlen($telephone) - 1);

        }

        $help = new ApplicationHelper();
        try {

            $code = $help->getRequestCode();
            $help->sendCodeToMobile($telephone, $code);
            return response()->json(['code' => $code, 'user' => $user, 'success' => true], 200);

        } catch (Exception $e) {

        }

        return response()->json(['success' => false], 402);

    }


    public function transferRecipient(Request $request)
    {
        $bankCode = $request->get('bank_code');
        $accountNumber = $request->get('account_number');
        $help = new ApplicationHelper();
        $user = Auth::user();
        $result = $help->createTransferRecipient($user->name . " " . $user->lastname, trim($accountNumber), $bankCode, "NGN");
        $message = "";
        $success = false;

        try {

            if ($result->status == 1 && $result->data->active == 1) {
                $data = $result->data->details;

                $accountName = $result->data->name;
                $accountNumber = $data->account_number;
                $bankCode = $data->bank_code;
                $currency = $result->data->currency;
                $recipient = $result->data->recipient_code;
                $recipientId = $result->data->id;


                $oldAccount = new AccountDetail();
                $accountExist = $oldAccount->where('user_id', $user->id)->get()->toArray();


                if (!empty($accountExist[0])) {
                    $oldAccount->where('user_id', $user->id)
                        ->update([
                            'user_id' => $user->id,
                            'account_name' => $accountName,
                            'account_number' => $accountNumber,
                            'bank_code' => $bankCode,
                            'recipient_code' => $recipient,
                            'recipient_id' => $recipientId,
                            'currency' => $currency,
                        ]);
                    $message = 'Account Information Successfully Updated';
                } else {

                    $account = new AccountDetail();
                    $account->user_id = $user->id;
                    $account->account_name = $accountName;
                    $account->account_number = $accountNumber;
                    $account->bank_code = $bankCode;
                    $account->recipient_code = $recipient;
                    $account->recipient_id = $recipientId;
                    $account->currency = $currency;
                    $account->save();
                    $message = 'Account Information Successfully Created';
                }
                $success = true;

            } else {
                $message = 'Problem encountered while updating your Account Information! Please review your information and try again';
            }
        } catch (Exception $e) {
            $message = 'Updating of Account Information cannot be completed! Please try again';
        }


        $cards = $help->getCardUserCards($user->id);
        $bank = $help->getAccountDetails($user->id);
        $banks = $help->getBankList();

        return response()->json(['success' => $success, 'bank' => $bank, 'cards' => $cards, 'user' => $user, 'banks' => $banks, 'message' => $message], 200);


    }

    public function getUserWithdrawals()
    {

        $user = Auth::user();
        $help = new ApplicationHelper();

        $bank = $help->getAccountDetails($user->id);

        $youth = $help->getYouthGoals($user->id);
        $steady = $help->getSteadyGrowth($user->id);
        $plans = array_merge($youth, $steady);

        $steadyWithdrawals = $help->getSteadyWithdrawals($user->id);
        $youthWithdrawals = $help->getYouthWithdrawals($user->id);

        return response()->json(['bank' => $bank, 'user' => $user, 'plans' => $plans, 'steadyWithdrawals' => $steadyWithdrawals, 'youthWithdrawals' => $youthWithdrawals], 200);


    }

    public function initiateTransfer(Request $request)
    {
        $planId = $request->get('plan_id');
        $planType = $request->get('plan_type');
        $amount = $request->get('amount');
        $requestType = $request->get('request_type');

        $help = new ApplicationHelper();
        $user = Auth::user();
        $paid = false;
        $recipientCode = $help->getRecipientCode($user->id);
        $balance = 0;

        $plan = $help->checkWithdrawal($planType, $planId);
        if ($plan) {
            if (!empty($recipientCode)) {


                if ($planType == 0) {
                    //youth
                    $youthSummary = $help->savingsOnAYouthPlan($user->id, $planId);

                    $balance = round($youthSummary['balance'], 2);

                    if ($amount > $balance) {
                        return response()->json(['success' => false, 'message' => 'You cannot withdraw more than you have on this plan, please withdraw within your balance range', 'balance' => 'Total Balance: ' . $balance], 402);
                    } elseif ($amount <= $balance) {
                        $status = $help->processPayment($amount, $recipientCode);

                        $paid = $this->checkPaymentStatus($status, $planId, $user->id, new YouthWithdrawal());
                    }


                } elseif ($planType == 1) {
                    //steady
                    $steadySummary = $help->savingsOnASteadyPlan($user->id, $planId);

                    $balance = round($steadySummary['balance'], 2);

                    if ($amount > $balance) {
                        return response()->json(['success' => false, 'message' => 'You cannot withdraw more than you have on this plan, please withdraw within your balance range', 'balance' => 'Total Balance: ' . $balance], 402);
                    } elseif ($amount <= $balance) {
                        $status = $help->processPayment($amount, $recipientCode);
                        $paid = $this->checkPaymentStatus($status, $planId, $user->id, new SteadyWithdrawal());


                    }

                }

            } else {
                return response()->json(['success' => false, 'message' => 'You have not added your bank account. Please add it from the Settings=>Payment Menu', 'balance' => ''], 402);
            }


        } else {
            return response()->json(['success' => false, 'message' => 'Your savings have not yet reached maturity. Please try again on or after the maturity date', 'balance' => ''], 200);
        }


        if ($paid) {
            if ($requestType == 1) {
                //full and close plan
                $help->closePlan($planType, $planId);

            }

            return response()->json(['success' => true, 'message' => 'Withdrawal successfully processed! Please note that pending deposits are resolved into your account within 24hours of initiation.', 'balance' => $balance], 200);
        }

        return response()->json(['success' => false, 'message' => 'Withdrawals cannot be processed now, please try again later.', 'balance' => 'Total Balance: ' . $balance], 402);


    }

    public function checkPaymentStatus($status, $planId, $userId, $withdraw)
    {


        try {

            if ($status->data->status == "pending" || $status->data->status == "success") {

                $result = $status->data;

                $withdraw->user_id = $userId;
                $withdraw->plan_id = $planId;
                $withdraw->amount = ($result->amount / 100);
                $withdraw->withdraw_date = Carbon::now();
                //$withdraw->status = $status->data->status == "pending" ? 0 : 1;
                $withdraw->status = 1;
                $withdraw->reference = $result->transfer_code;
                $withdraw->save();

                return true;
            }


        } catch (Exception $e) {

        }

        return false;
    }

    public function getBanks()
    {
        $help = new ApplicationHelper();
        $banks = $help->getBankList();
        return response()->json(['banks' => $banks], 200);
    }


    public function userCards()
    {
        $user = Auth::user();
        $help = new ApplicationHelper();
        $cards = $help->getCardUserCards($user->id);

        return response()->json(['cards' => $cards], 200);

    }

}