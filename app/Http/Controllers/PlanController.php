<?php

namespace App\Http\Controllers;

use App\Helpers\ApplicationHelper;
use App\Helpers\PlanHelper;
use App\Models\AccountDetail;
use App\Models\SteadyGrowth;
use App\Models\SteadyWithdrawal;
use App\Models\TransactionLog;
use App\Models\YouthGoal;
use App\Models\YouthWithdrawal;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
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


        if ($planType == 0) {

            $saved = $help->saveYouthGoal($request);
            $help->createYouthSavings($saved, $user->id, $help->getToday(), $request->get('amount'), $request->get('reference'), 1, 1);
            $help->updateUserFlag(1);
        } elseif ($planType == 1) {
            $saved = $help->saveSteadyGrowth($request);
            $help->createSteadySavings($saved, $user->id, $help->getToday(), $request->get('amount'), $request->get('reference'), 1, 1);
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
        if ($planType == 0) {

            $saved = $help->saveYouthGoal($request);


        } elseif ($planType == 1) {
            $saved = $help->saveSteadyGrowth($request);
        }


        return response()->json(['success' => true], 200);


    }


    public function steadyPlan()
    {

        $help = new PlanHelper();

        $user = Auth::user();
        $steady = $this->collatePlansSteady($help->getSteadyGrowth($user->id), 1);
        $cards = $help->getCardUserCards($user->id);
        return response()->json(['user' => $user, 'steady' => $steady, 'cards' => $cards], 200);
    }


    public function youthPlan()
    {

        $help = new PlanHelper();

        $user = Auth::user();
        $youth = $this->collatePlans($help->getYouthGoals($user->id), 0);
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

        $savings = $help->getYouthSavings($planId, $user->id);
        return response()->json(['youthSavings' => $savings], 200);


    }

    public function steadySavings($planId)
    {
        $help = new ApplicationHelper();

        $user = Auth::user();

        $savings = $help->getSteadySavings($planId, $user->id);
        return response()->json(['steadySavings' => $savings], 200);
    }


    public function updateYouthGoals(Request $request)
    {

        $help = new ApplicationHelper();
        $savings = $help->updateYouthGoals($request);

        return response()->json($savings, 200);


    }

    public function updateSteadyGrowth(Request $request)
    {

        $help = new ApplicationHelper();
        $savings = $help->updateSteadyGrowth($request);

        return response()->json($savings, 200);


    }

    public function getPlans()
    {

        $user = Auth::user();
        $help = new PlanHelper();

        $youth = $help->getYouthGoals($user->id);
        $steady = $help->getSteadyGrowth($user->id);
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

        return response()->json(['bank' => $bank, 'cards' => $cards, 'user' => $user, 'banks' => $banks], 200);

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

        }

        $cards = $help->getCardUserCards($user->id);
        $bank = $help->getAccountDetails($user->id);
        $banks = $help->getBankList();

        return response()->json(['banks' => $banks, 'bank' => $bank, 'cards' => $cards, 'user' => $user], 200);

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

        return response()->json(['success' => false], 200);

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
                        return response()->json(['success' => false, 'message' => 'You cannot withdraw more than you have on this plan, please withdraw within your balance range', 'balance' => 'Total Balance: ' . $balance], 200);
                    } elseif ($amount <= $balance) {
                        $status = $help->processPayment($amount, $recipientCode);

                        $paid = $this->checkPaymentStatus($status, $planId, $user->id, new YouthWithdrawal());
                    }


                } elseif ($planType == 1) {
                    //steady
                    $steadySummary = $help->savingsOnASteadyPlan($user->id, $planId);

                    $balance = round($steadySummary['balance'], 2);

                    if ($amount > $balance) {
                        return response()->json(['success' => false, 'message' => 'You cannot withdraw more than you have on this plan, please withdraw within your balance range', 'balance' => 'Total Balance: ' . $balance], 200);
                    } elseif ($amount <= $balance) {
                        $status = $help->processPayment($amount, $recipientCode);
                        $paid = $this->checkPaymentStatus($status, $planId, $user->id, new SteadyWithdrawal());


                    }

                }

            } else {
                return response()->json(['success' => false, 'message' => 'You have not added your bank account. Please add it from the Settings=>Payment Menu', 'balance' => ''], 200);
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

        return response()->json(['success' => false, 'message' => 'Withdrawals cannot be processed now, please try again later.', 'balance' => 'Total Balance: ' . $balance], 200);


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


}
