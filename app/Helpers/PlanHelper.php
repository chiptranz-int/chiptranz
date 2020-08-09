<?php
/**
 * Created by PhpStorm.
 * User: MoFoLuWaSo
 * Date: 9/22/2019
 * Time: 10:58 PM
 */

namespace App\Helpers;


use App\Models\AccountDetail;
use App\Models\Frequency;
use App\Models\SteadyGrowth;
use App\Models\SteadySaving;
use App\Models\SteadyWithdrawal;
use App\Models\TransactionLog;
use App\Models\UserTransact;
use App\Models\YouthGoal;
use App\Models\YouthSaving;
use App\Models\YouthWithdrawal;
use Aws\AwsClient;
use Aws\Credentials\Credentials;
use Aws\Sms\SmsClient;
use Aws\Sns\SnsClient;
use DateTime;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;


class PlanHelper
{


    /*===========================================
    |Everything about youth goals
    |starts from here
    |     (Youth Goals)
    |======================================
    |
    |
    */


    public function saveYouthGoal($request)
    {
        date_default_timezone_set("Africa/Lagos");
        $user = Auth::user();
        $planName = $request->get('plan_name');
        $frequency = $request->get('frequency');
        $amount = $request->get('amounts');
        $startDate = $request->get('start_date');
        $withdrawalDate = $request->get('withdrawal_date');
        $transact = $request->get('transact_id');
        $frequencyId = $this->getLatestFrequencyId(0);
        $account = new YouthGoal();
        $account->user_id = $user->id;
        $account->plan_name = $planName;
        $account->start_date = $startDate;
        $account->withdrawal_date = $withdrawalDate;
        $account->amounts = $amount;
        $account->frequency = $frequency;
        $account->frequency_id = $frequencyId;
        $account->transact_id = $transact;
        $account->status = 0;
        $account->plan_type = 0;
        $account->save();

        return $account->id;
    }


    public function getYouthGoals($userId)
    {
        $plan = new YouthGoal();
        //$plans = $plan->whereRaw("(user_id = '$userId') and (status = 0 or status = 1)")
        $plans = $plan->where("user_id", $userId)
            ->latest()->get()->toArray();
        if (empty($plans[0])) {
            return array();
        } else {
            return $plans;
        }

    }

    public function getAllYouthGoals($userId)
    {
        $plan = new YouthGoal();
        $plans = $plan->where('user_id', $userId)
            ->latest()->get()->toArray();
        if (empty($plans[0])) {
            return array();
        } else {
            return $plans;
        }

    }

    public function getYouthGoalById($id)
    {
        $youth = new YouthGoal();
        $goal = $youth->where('id', $id)
            ->get()->toArray();

        try {
            return $goal[0];
        } catch (Exception $e) {
            return array();
        }
    }


    public function getTotalYouthSavings($userId, $planId, $status = 1)
    {
        $plan = new YouthSaving();

        $totalSavings = $plan->select('amount_deposited')->where('user_id', $userId)
            ->where('plan_id', $planId)
            ->where('status', $status)
            ->sum('amount_deposited');

        return $totalSavings;

    }

    public function getTotalYouthWithdrawals($userId, $planId, $status = 1)
    {


        $plan = new YouthWithdrawal();

        $totalSavings = $plan->select('amount')->where('user_id', $userId)
            ->where('plan_id', $planId)
            ->where('status', $status)
            ->sum('amount');

        return $totalSavings;

    }

    public function getYouthWithdrawals($userId)
    {


        $plan = new YouthWithdrawal();

        $totalSavings = $plan->where('user_id', $userId)
            ->latest()
            ->get()->toArray();

        return $totalSavings;

    }

    public function getYouthWithdrawalsById($planId, $userId)
    {


        $plan = new YouthWithdrawal();

        $totalSavings = $plan->where('plan_id', $planId)
            ->where('user_id', $userId)
            ->latest()
            ->get()->toArray();

        return $totalSavings;

    }

    public function totalSavedOnYouth($userId, $planId)
    {
        $totalYouthSaved = $this->getTotalYouthSavings($userId, $planId, 1);
        $totalYouthWithdraw = $this->getTotalYouthWithdrawals($userId, $planId, 1);
        return [($totalYouthSaved - $totalYouthWithdraw), $totalYouthWithdraw];

    }

    public function getTotalYouthSavedByUserId($userId)
    {
        $plan = new YouthSaving();

        $totalSavings = $plan->select('amount_deposited')
            ->where('user_id', $userId)
            ->where('status', 1)
            ->sum('amount_deposited');

        return $totalSavings;

    }

    public function getYouthSavingsDepositDateTypeStatus($planId, $userId, $date, $type)
    {
        $plan = new YouthSaving();

        $savings = $plan->select('id', 'status')
            ->where('date_deposited', $date)
            ->where('plan_id', $planId)
            ->where('user_id', $userId)
            ->where('deposit_type', $type)
            ->get()->toArray();

        if (empty($savings[0])) {

            return array();
        } else {


            return $savings[0];
        }


    }

    public function getTotalYouthWithdrawalsByUserId($userId)
    {


        $plan = new YouthWithdrawal();

        $totalSavings = $plan->select('amount')
            ->where('user_id', $userId)
            ->where('status', 1)
            ->sum('amount');

        return $totalSavings;

    }

    public function createYouthSavings($planId, $userId, $date, $amount, $reference, $status, $depositType)
    {

        $plan = $this->getYouthGoalById($planId);
        if (!empty($plan)) {
            $youth = new YouthSaving();

            $youth->plan_id = $planId;
            $youth->user_id = $userId;
            $youth->amount_deposited = $amount;
            $youth->date_deposited = $date;
            $youth->transact_id = $plan['transact_id'];
            $youth->deposit_type = $depositType;
            $youth->status = $status;
            $youth->ref_no = $reference;
            $youth->save();
            return $youth->id;
        }


        return 0;


    }

    public function updateYouthGoals($request)
    {
        $id = $request->get('id');

        $planName = $request->get('plan_name');
        $amounts = $request->get('amounts');
        $frequency = $request->get('frequency');
        $status = $request->get('status');
        $nextSavings = $request->get('next_savings');
        $transactId = $request->get('transact_id');


        $youth = new YouthGoal();
        $s = $youth->where('id', $id)
            ->update([
                'plan_name' => $planName,
                'amounts' => $amounts,
                'frequency' => $frequency,
                'status' => $status,
                'next_savings' => $nextSavings,
                'transact_id' => $transactId,
            ]);

        return $s;
    }


    public function getYouthNextSavingDate($planId, $userId, $frequency, $startDate, $withdrawalDate, $status)
    {
        $today = date('Y-m-d');
        $now = new DateTime($today);
        $start = new DateTime($startDate);
        $stop = new DateTime($withdrawalDate);
        $savings = $this->getLatestYouthSavings($planId, $userId);

        $dDay = "";

        switch ($status) {
            case 0:
                if (!empty($savings)) {

                    $dDay = $this->nextSavingsDate($savings['date_deposited'], $frequency);

                } else {
                    $dDay = $this->firstSavingsDate($startDate);

                }
                break;
            case 1:
                if ($start > $now) {

                    $dDay = $this->firstSavingsDate($startDate);
                } else {
                    $dDay = $this->nextSavingsDate($today, $frequency);
                }
                break;
            case 2:
                $dDay = "Liquidated";
                break;
            case 3:
                $dDay = "Completed";
                break;
            default:
                break;

        }
        return $dDay;

    }

    public function getLatestYouthSavings($planId, $userId)
    {
        $youth = new YouthSaving();
        $savings = $youth->select('date_deposited')->where('user_id', $userId)
            ->where('plan_id', $planId)
            ->latest('date_deposited')
            ->take(1)->get()->toArray();
        if (!empty($savings[0])) {
            return $savings[0];
        } else {
            return array();
        }

    }

    public function getYouthSavings($planId, $userId)
    {
        $youth = new YouthSaving();
        $savings = $youth->select('id', 'amount_deposited', 'ref_no', 'date_deposited', 'deposit_type','updated_at')
            ->where('user_id', $userId)
            ->where('plan_id', $planId)
            ->where('status', 1)
            ->latest('date_deposited')
            ->get()->toArray();

        return $savings;
    }

    public function getYouthSavingsByUserId($userId)
    {
        $youth = new YouthSaving();
        $savings = $youth->select('youth_savings.id', 'youth_goals.plan_name', 'youth_savings.plan_id', 'youth_savings.user_id', 'youth_savings.amount_deposited', 'youth_savings.ref_no', 'youth_savings.date_deposited', 'youth_savings.deposit_type')
            ->join('youth_goals', 'youth_goals.id', '=', 'youth_savings.plan_id')
            ->where('youth_savings.user_id', $userId)
            ->where('youth_savings.status', 1)
            ->latest('youth_savings.date_deposited')
            ->take(10)->get()->toArray();

        return $savings;
    }

    public function getUnInitializeYouthGoals($today)
    {

        $youth = new YouthGoal();
        $youths = $youth->select('start_date', 'next_savings', 'id', 'user_id', 'frequency', 'transact_id', 'amounts')
            ->whereRaw("((start_date =  '$today' and next_savings <= '$today') or (start_date < '$today' and next_savings IS NULL) or (start_date < '$today' and next_savings <= '$today' ))")
            ->whereRaw("(status = 0 and transact_id != 0 and withdrawal_date > '$today' )")
            ->get()->toArray();

        return $youths;

    }


    public function initializeYouthSavings($goals)
    {


        foreach ($goals as $goal) {
            $date = $this->determineDepositDate($goal['start_date'], $goal['next_savings']);

            $saved = $this->saveYouthSavings($goal['id'], $goal['user_id'], $goal['amounts'], $date, $goal['transact_id'], 0, 0);

            if ($saved) {
                $this->updateYouthNextSavingsDate($goal['id'], $date, $goal['frequency']);
            }

        }


    }

    public function saveYouthSavings($planId, $userId, $amount, $date, $transactId, $depositType, $status)
    {

        $oldSavings = $this->getYouthSavingsDepositDateTypeStatus($planId, $userId, $date, $depositType);


        if (empty($oldSavings)) {
            $youth = new YouthSaving();
            $youth->plan_id = $planId;
            $youth->user_id = $userId;
            $youth->amount_deposited = $amount;
            $youth->date_deposited = $date;
            $youth->transact_id = $transactId;
            $youth->deposit_type = $depositType;
            $youth->status = $status;

            $youth->save();
            return true;

        } else {
            if ($oldSavings['status'] == 0) {

                $plan = new YouthSaving();
                $plan->where('date_deposited', $date)
                    ->where('deposit_type', $depositType)
                    ->where('status', $status)
                    ->update([
                        'transact_id' => $transactId,
                        'amount_deposited' => $amount
                    ]);
            }
        }

        return false;
    }


    public function updateYouthSavings($savingsId, $refno, $status)
    {


        $youth = new YouthSaving();
        $youth->where('id', $savingsId)->update([
            'ref_no' => $refno,
            'status' => $status,

        ]);


    }

    public
    function retrieveUnprocessedYouthSavings()
    {


        $youth = new YouthSaving();
        $youths = $youth->select('id', 'plan_id', 'user_id', 'amount_deposited', 'transact_id')
            ->where('deposit_type', 0)
            ->where('status', 0)
            ->get()->toArray();

        return $youths;

    }

    public
    function updateYouthNextSavingsDate($goalId, $lastDate, $frequency)
    {

        $nextDate = $this->nextSavingsDate($lastDate, $frequency);


        $goal = new YouthGoal();
        $goal->where('id', $goalId)
            ->update([
                'next_savings' => $nextDate,
            ]);

    }


    /*===========================================
    |Everything about steady growth
    |starts from here
    |     (Steady Growth)
    |========================================
    |
    |
    */
    public function saveSteadyGrowth($request)
    {
        date_default_timezone_set("Africa/Lagos");
        $user = Auth::user();
        $planName = $request->get('plan_name');
        $frequency = $request->get('frequency');
        $amount = $request->get('amounts');
        $startDate = $request->get('start_date');
        $withdrawalDate = $request->get('withdrawal_date');
        $transact = $request->get('transact_id');
        $frequencyId = $this->getLatestFrequencyId(1);
        $account = new SteadyGrowth();
        $account->user_id = $user->id;
        $account->plan_name = $planName;
        $account->start_date = $startDate;
        $account->withdrawal_date = $withdrawalDate;
        $account->amounts = $amount;
        $account->frequency = $frequency;
        $account->frequency_id = $frequencyId;
        $account->transact_id = $transact;
        $account->status = 0;
        $account->save();

        return $account->id;
    }


    public function getSteadyGrowth($userId)
    {
        $plan = new SteadyGrowth();
        //$plans = $plan->where("user_id = '$userId') and (status = 0 or status = 1)")
        $plans = $plan->where("user_id", $userId)
            ->latest()->get()->toArray();
        if (empty($plans[0])) {
            return array();
        } else {
            return $plans;
        }

    }


    public function getAllSteadyGrowth($userId)
    {
        $plan = new SteadyGrowth();
        $plans = $plan->where('user_id', $userId)
            ->latest()->get()->toArray();
        if (empty($plans[0])) {
            return array();
        } else {
            return $plans;
        }

    }

    public function getSteadyGrowthById($id)
    {
        $youth = new SteadyGrowth();
        $goal = $youth->where('id', $id)
            ->get()->toArray();

        try {
            return $goal[0];
        } catch (Exception $e) {
            return array();
        }
    }

    public function getTotalSteadySavings($userId, $planId, $status = 1)
    {
        $plan = new SteadySaving();

        $totalSavings = $plan->select('amount_deposited')->where('user_id', $userId)
            ->where('plan_id', $planId)
            ->where('status', $status)
            ->sum('amount_deposited');

        return $totalSavings;

    }

    public function getTotalSteadyWithdrawals($userId, $planId, $status = 1)
    {


        $plan = new SteadyWithdrawal();

        $totalSavings = $plan->select('amount')->where('user_id', $userId)
            ->where('plan_id', $planId)
            ->where('status', $status)
            ->sum('amount');

        return $totalSavings;

    }

    public function getSteadyWithdrawals($userId)
    {


        $plan = new SteadyWithdrawal();

        $totalSavings = $plan->where('user_id', $userId)
            ->latest()
            ->get()->toArray();

        return $totalSavings;

    }
    public function getSteadyWithdrawalsById($planId, $userId)
    {


        $plan = new SteadyWithdrawal();

        $totalSavings = $plan->where('plan_id', $planId)
            ->where('user_id', $userId)
            ->latest()
            ->get()->toArray();

        return $totalSavings;

    }

    public function totalSavedOnSteady($userId, $planId)
    {
        $totalYouthSaved = $this->getTotalSteadySavings($userId, $planId, 1);
        $totalYouthWithdraw = $this->getTotalSteadyWithdrawals($userId, $planId, 1);
        return [($totalYouthSaved - $totalYouthWithdraw), $totalYouthWithdraw];

    }

    public function getTotalSteadySavedByUserId($userId)
    {
        $plan = new SteadySaving();

        $totalSavings = $plan->select('amount_deposited')
            ->where('user_id', $userId)
            ->where('status', 1)
            ->sum('amount_deposited');

        return $totalSavings;

    }

    public function getSteadySavingsDepositDateTypeStatus($planId, $userId, $date, $type)
    {
        $plan = new SteadySaving();

        $savings = $plan->select('id', 'status')
            ->where('date_deposited', $date)
            ->where('plan_id', $planId)
            ->where('user_id', $userId)
            ->where('deposit_type', $type)
            ->get()->toArray();

        if (empty($savings[0])) {

            return array();
        } else {


            return $savings[0];
        }


    }

    public function getTotalSteadyWithdrawalsByUserId($userId)
    {


        $plan = new SteadyWithdrawal();

        $totalSavings = $plan->select('amount')
            ->where('user_id', $userId)
            ->where('status', 1)
            ->sum('amount');

        return $totalSavings;

    }

    public function createSteadySavings($planId, $userId, $date, $amount, $reference, $status, $depositType)
    {

        $plan = $this->getSteadyGrowthById($planId);
        if (!empty($plan)) {
            $youth = new SteadySaving();

            $youth->plan_id = $planId;
            $youth->user_id = $userId;
            $youth->amount_deposited = $amount;
            $youth->date_deposited = $date;
            $youth->transact_id = $plan['transact_id'];
            $youth->deposit_type = $depositType;
            $youth->status = $status;
            $youth->ref_no = $reference;
            $youth->save();
            return $youth->id;
        }


        return 0;


    }

    public function updateSteadyGrowth($request)
    {
        $id = $request->get('id');

        $planName = $request->get('plan_name');
        $amounts = $request->get('amounts');
        $frequency = $request->get('frequency');
        $status = $request->get('status');
        $nextSavings = $request->get('next_savings');
        $transactId = $request->get('transact_id');


        $youth = new SteadyGrowth();
       $m = $youth->where('id', $id)
            ->update([
                'plan_name' => $planName,
                'amounts' => $amounts,
                'frequency' => $frequency,
                'status' => $status,
                'next_savings' => $nextSavings,
                'transact_id' => $transactId,
            ]);

        return $m;
    }


    public function getSteadyNextSavingDate($planId, $userId, $frequency, $startDate, $withdrawalDate, $status)
    {
        $today = date('Y-m-d');
        $now = new DateTime($today);
        $start = new DateTime($startDate);
        $stop = new DateTime($withdrawalDate);
        $savings = $this->getLatestSteadySavings($planId, $userId);

        $dDay = "";

        switch ($status) {
            case 0:
                if (!empty($savings)) {

                    $dDay = $this->nextSavingsDate($savings['date_deposited'], $frequency);

                } else {
                    $dDay = $this->firstSavingsDate($startDate);

                }
                break;
            case 1:
                if ($start > $now) {

                    $dDay = $this->firstSavingsDate($startDate);
                } else {
                    $dDay = $this->nextSavingsDate($today, $frequency);
                }
                break;
            case 2:
                $dDay = "Liquidated";
                break;
            case 3:
                $dDay = "Completed";
                break;
            default:
                break;

        }
        return $dDay;

    }

    public function getLatestSteadySavings($planId, $userId)
    {
        $youth = new SteadySaving();
        $savings = $youth->select('date_deposited')->where('user_id', $userId)
            ->where('plan_id', $planId)
            ->latest('date_deposited')
            ->take(1)->get()->toArray();
        if (!empty($savings[0])) {
            return $savings[0];
        } else {
            return array();
        }

    }

    public function getSteadySavings($planId, $userId)
    {
        $youth = new SteadySaving();
        $savings = $youth->select('id', 'amount_deposited', 'ref_no', 'date_deposited', 'deposit_type','updated_at')
            ->where('user_id', $userId)
            ->where('plan_id', $planId)
            ->where('status', 1)
            ->latest('date_deposited')
            ->get()->toArray();

        return $savings;
    }

    public function getSteadySavingsByUserId($userId)
    {
        $youth = new SteadySaving();
        $savings = $youth->select('youth_savings.id', 'youth_goals.plan_name', 'youth_savings.plan_id', 'youth_savings.user_id', 'youth_savings.amount_deposited', 'youth_savings.ref_no', 'youth_savings.date_deposited', 'youth_savings.deposit_type')
            ->join('youth_goals', 'youth_goals.id', '=', 'youth_savings.plan_id')
            ->where('youth_savings.user_id', $userId)
            ->where('youth_savings.status', 1)
            ->latest('youth_savings.date_deposited')
            ->take(10)->get()->toArray();

        return $savings;
    }

    public function getUnInitializeSteadyGrowth($today)
    {

        $youth = new SteadyGrowth();
        $youths = $youth->select('start_date', 'next_savings', 'id', 'user_id', 'frequency', 'transact_id', 'amounts')
            ->whereRaw("((start_date =  '$today' and next_savings <= '$today') or (start_date < '$today' and next_savings IS NULL) or (start_date < '$today' and next_savings <= '$today' ))")
            ->whereRaw("(status = 0 and transact_id != 0 and withdrawal_date > '$today' )")
            ->get()->toArray();

        return $youths;

    }


    public function initializeSteadySavings($goals)
    {


        foreach ($goals as $goal) {
            $date = $this->determineDepositDate($goal['start_date'], $goal['next_savings']);

            $saved = $this->saveSteadySavings($goal['id'], $goal['user_id'], $goal['amounts'], $date, $goal['transact_id'], 0, 0);

            if ($saved) {
                $this->updateSteadyNextSavingsDate($goal['id'], $date, $goal['frequency']);
            }

        }


    }

    public function saveSteadySavings($planId, $userId, $amount, $date, $transactId, $depositType, $status)
    {

        $oldSavings = $this->getSteadySavingsDepositDateTypeStatus($planId, $userId, $date, $depositType);


        if (empty($oldSavings)) {
            $youth = new SteadySaving();
            $youth->plan_id = $planId;
            $youth->user_id = $userId;
            $youth->amount_deposited = $amount;
            $youth->date_deposited = $date;
            $youth->transact_id = $transactId;
            $youth->deposit_type = $depositType;
            $youth->status = $status;

            $youth->save();
            return true;

        } else {
            if ($oldSavings['status'] == 0) {

                $plan = new SteadySaving();
                $plan->where('date_deposited', $date)
                    ->where('deposit_type', $depositType)
                    ->where('status', $status)
                    ->update([
                        'transact_id' => $transactId,
                        'amount_deposited' => $amount
                    ]);
            }
        }

        return false;
    }


    public function updateSteadySavings($savingsId, $refno, $status)
    {


        $youth = new SteadySaving();
        $youth->where('id', $savingsId)->update([
            'ref_no' => $refno,
            'status' => $status,

        ]);


    }

    public
    function retrieveUnprocessedSteadySavings()
    {


        $youth = new SteadySaving();
        $youths = $youth->select('id', 'plan_id', 'user_id', 'amount_deposited', 'transact_id')
            ->where('deposit_type', 0)
            ->where('status', 0)
            ->get()->toArray();

        return $youths;

    }

    public
    function updateSteadyNextSavingsDate($goalId, $lastDate, $frequency)
    {

        $nextDate = $this->nextSavingsDate($lastDate, $frequency);


        $goal = new SteadyGrowth();
        $goal->where('id', $goalId)
            ->update([
                'next_savings' => $nextDate,
            ]);

    }

    public function activePlans($userId)
    {

        $youth = $this->getYouthGoals($userId);
        $steady = $this->getSteadyGrowth($userId);
        $activePlans = array_merge($youth, $steady);
        return $activePlans;
    }

    public function transactionHistory($userId, $type, $status)
    {

        $plan = new TransactionLog();
        $plans = $plan->where('user_id', $userId)
            ->where('status', $status)
            ->where('log_type', $type)
            ->paginate();

        return $plans;
    }


    public function getUserInterestRate($frequencyId, $frequency)
    {
        $plan = new Frequency();

        $frequencies = $plan->select('frequency')->where('id', $frequencyId)
            ->get()->toArray();

        $interests = json_decode($frequencies[0]['frequency'], 1);
        return $interests[$frequency];
    }


    public
    function totalSaved($userId, $planId, $planType)
    {

        $totalSaved = 0;
        $totalWithdrawn = 0;

        if ($planType == 0) {
            $totalSaved = $this->getTotalYouthSavings($userId, $planId, 1);
            $totalWithdrawn = $this->getTotalYouthWithdrawals($userId, $planId, 1);

        } elseif ($planType == 1) {
            $totalSaved = $this->getTotalSteadySavings($userId, $planId, 1);
            $totalWithdrawn = $this->getTotalSteadyWithdrawals($userId, $planId, 1);
        }

        return ($totalSaved - $totalWithdrawn);
    }

    public
    function totalSavedByUserId($userId)
    {


        $totalYouthSaved = $this->getTotalYouthSavedByUserId($userId);
        $totalYouthWithdrawn = $this->getTotalYouthWithdrawalsByUserId($userId);

        $totalSteadySaved = $this->getTotalSteadySavedByUserId($userId);
        $totalSteadyWithdrawn = $this->getTotalSteadyWithdrawalsByUserId($userId);
        $totalSavedYouth = $totalYouthSaved - $totalYouthWithdrawn;
        $totalSavedSteady = $totalSteadySaved - $totalSteadyWithdrawn;

        return array(
            'totalSaved' => ($totalSavedYouth + $totalSavedSteady),
            'totalWithdrawal' => ($totalYouthWithdrawn + $totalSteadyWithdrawn),
        );

    }


    public
    function payStackInformation()
    {
        $user = Auth::user();
        $paystack = new PaystackApi();

        return [
            'email' => $user->email,
            'first_name' => $user->name,
            'last_name' => $user->last_name,
            'reference' => $paystack->genTranxRef(),
            //'sKey' => config('paystack.secretKey'),
            'pKey' => config('paystack.publicKey'),

        ];

    }

    public
    function generateToken()
    {

        $paystack = new PaystackApi();

        return [

            'reference' => $paystack->genTranxRef(),


        ];

    }

    public
    function getLatestFrequencyId($planType)
    {
        $frequency = new Frequency();
        $frequencies = $frequency->select('id')->where('plan_type', $planType)
            ->latest('id')->get()->toArray();
        try {

            return $frequencies[0]['id'];
        } catch (Exception $e) {
            return 1;
        }
    }

    public
    function getInterestRate($frequencyId, $freq)
    {
        $frequency = new Frequency();
        $frequencies = $frequency->select('frequency')->where('id', $frequencyId)->get()->toArray();


        $interest = json_decode($frequencies[0]['frequency'], 1);


        return $interest[$freq];

    }

    public
    function nextSavingsDate($lastSavingsDate, $frequency)
    {

        if ($frequency == 1) {
            return date('Y-m-d', strtotime($lastSavingsDate . ' +1 day'));
        } elseif ($frequency == 2) {
            return date('Y-m-d', strtotime($lastSavingsDate . ' +1 week'));
        } elseif ($frequency == 3) {
            return date('Y-m-d', strtotime($lastSavingsDate . ' +1 month'));
        } else {
            return date('Y-m-d');
        }
    }

    public
    function firstSavingsDate($startDate)
    {


        return date('Y-m-d', strtotime($startDate));

    }

    public
    function getCardOnPlan($transactId)
    {
        $transact = new UserTransact();
        $card = $transact->select('id', 'bank_name', 'card_type', 'last_four_digit')
            ->where('id', $transactId)->get()->toArray();
        try{

        return $card[0];
        }catch (Exception $e){
            return array();
        }
    }

    public
    function getCardUserCards($userId)
    {
        $transact = new UserTransact();
        $card = $transact->select('id', 'bank_name', 'card_type', 'last_four_digit')
            ->where('user_id', $userId)->get()->toArray();
        return $card;
    }

    public function countUserCard($userId)
    {
        $transact = new UserTransact();
        return $transact->select('id')->where('user_id', $userId)->count('id');
    }

    public function getLastUserCard($userId)
    {
        $transact = new UserTransact();
        $card = $transact->select('id')->where('user_id', $userId)->latest()->get()->toArray();
        if (!empty($card[0])) {
            return $card[0]['id'];
        } else {
            return 0;
        }
    }

    public function updateAllPlanOnOldCard($oldCardId, $newCardId, $userId)
    {

        $this->updateCardOnPlan(new YouthGoal(), $oldCardId, $newCardId, $userId);
        $this->updateCardOnPlan(new YouthSaving(), $oldCardId, $newCardId, $userId);
        $this->updateCardOnPlan(new SteadyGrowth(), $oldCardId, $newCardId, $userId);
        $this->updateCardOnPlan(new SteadySaving(), $oldCardId, $newCardId, $userId);

    }

    public function updateCardOnPlan($plan, $oldCardId, $newCardId, $userId)
    {

        $plan->where('user_id', $userId)
            ->where('transact_id', $oldCardId)
            ->update([
                'transact_id' => $newCardId
            ]);
    }

    public function removeCardById($cardId)
    {
        try {
            UserTransact::destroy($cardId);

            return 1;
        } catch (Exception $e) {

        }

        return 0;
    }

    public
    function getCardAuthCode($transactId)
    {
        $transact = new UserTransact();

        $card = $transact->select('auth_code')
            ->where('id', $transactId)->get()->toArray();
        if (!empty($card[0])) {

            return $card[0]['auth_code'];

        } else {

            return array();
        }
    }

    public
    function determineDepositDate($startDate, $nextSavings)
    {

        if (empty($nextSavings)) {
            return $startDate;
        } else {
            return $nextSavings;
        }

    }


    public
    function recurrentCharge($authorizationCode, $amount, $email)
    {
        //The following is for recurrent charge on the account using the authorization code
        //$authorizationCode = "AUTH_72btv547";
        //$testRef = "0bxco8lyc2aa0fq";
        //$email ="bojack@horsinaround.com";
        $params = array(

            "authorization_code" => $authorizationCode,
            "email" => $email,
            "amount" => $amount,

        );

        $key = config('paystack.secretKey');
        $authBearer = 'Bearer ' . $key;
        $response = $this->httpPost(config('paystack.paymentUrl') . '/transaction/charge_authorization', $params,
            [
                'Authorization: ' . $authBearer . '',
                'Content-Type: application/json',
                'Accept: application/json'
            ]);

        return json_decode($response, 1);


    }

    public function httpPost($url, $params, $header)
    {


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));

        $output = curl_exec($ch);

        curl_close($ch);


        return $output;


    }

    public function httpGet($url, $header)
    {


//Initialize cURL.
        $ch = curl_init();

//Set the URL that you want to GET by using the CURLOPT_URL option.
        curl_setopt($ch, CURLOPT_URL, $url);

//Set CURLOPT_RETURNTRANSFER so that the content is returned as a variable.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//Set CURLOPT_FOLLOWLOCATION to true to follow redirects.
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

//Execute the request.
        $output = curl_exec($ch);

//Close the cURL handle.
        curl_close($ch);

//Print the data out onto the page.


        return $output;

    }

    public
    function verifyAndSafe($results, $savingsId, $planType)
    {
        try {
            $data = $results['data'];
            $success = "success";
            $status = $data['status'];

            if ($status == $success) {

                $reference = $data['reference'];
                if ($planType == 0) {
                    $this->updateYouthSavings($savingsId, $reference, 1);
                } elseif ($planType == 1) {
                    $this->updateSteadySavings($savingsId, $reference, 1);
                }


                return true;

            }
        } catch (Exception $e) {

        }

        return false;
    }

    public function verifyAndSafeOneTime($results, $savingsId, $userId, $date, $amount, $planType)
    {
        try {
            $data = $results['data'];
            $success = "success";
            $status = $data['status'];

            if ($status == $success) {

                $reference = $data['reference'];
                if ($planType == 0) {
                    $this->createYouthSavings($savingsId, $userId, $date, $amount, $reference, 1, 1);
                } elseif ($planType == 1) {
                    $this->createSteadySavings($savingsId, $userId, $date, $amount, $reference, 1, 1);
                }


                return true;

            }
        } catch (Exception $e) {

        }

        return false;
    }

    public function getBankList()
    {


        try {
            $bankList = file_get_contents("bank.json");
            $bankData = json_decode($bankList, 1)['data'];
            $banks = array();
            $i = 0;
            foreach ($bankData as $bank) {
                $i++;
                $banks [] = array('name' => $bank['name'], 'code' => $bank['code'], 'id' => $i);
            }
            return $bankData;
        } catch (Exception $e) {
            return array();
        }

    }

    public function getAccountDetails($userId)
    {
        $bank = new AccountDetail();
        $banks = $bank->where('user_id', $userId)->get()->toArray();
        if (!empty($banks[0])) {
            return $banks[0];
        } else {
            return array();
        }
    }

    public function createTransferRecipient($name, $account, $bank, $currency)
    {
        $params = array(

            "type" => "nuban",
            "name" => $name,
            "description" => "ChipTranz Customer",
            "account_number" => $account,
            "bank_code" => $bank,
            "currency" => $currency,

        );

        $key = config('paystack.secretKey');
        $response = $this->httpPost("https://api.paystack.co/transferrecipient", $params,
            [
                'Authorization: Bearer ' . $key . '',
                'Content-Type: application/json',
            ]);

        return json_decode($response);
    }

    public function processPayment($amount, $recipient)
    {
        $params = array(

            "source" => "balance",
            "reason" => "ChipTranz Account Transaction",
            "amount" => ($amount * 100),
            "recipient" => $recipient,

        );
        $key = config('paystack.secretKey');
        $response = $this->httpPost("https://api.paystack.co/transfer", $params,
            [
                'Authorization: Bearer ' . $key . '',
                'Content-Type: application/json',
            ]);

        return json_decode($response);
    }

    public function sendCodeToMobile($mobile, $code)
    {

        //$info = ;

        $sms = new SnsClient([
            'version' => 'latest',
            'credentials' => new Credentials(
                config('services.ses.key'),
                config('services.ses.secret')
            ),
            'region' => config('services.ses.region'),
        ]);

        //$sms =  AWS::createClient('sns');

        $sms->publish([
            'Message' => $code . ' is your ChipTranz verification code. Thank you.',
            'PhoneNumber' => $mobile,
            'Subject' => 'ChipTranz',
            'MessageAttributes' => [
                'AWS.SNS.SMS.SMSType' => [
                    'DataType' => 'String',
                    'StringValue' => 'Transactional',
                ]
            ],

        ]);

//
//        $params = array(
//
//            "source" => "balance",
//            "reason" => "ChipTranz Account Transaction",
//            "amount" => ($amount*100),
//            "recipient" => $recipient,
//
//        );
//        $key = config('paystack.secretKey');
//        $response = $this->httpPost("https://api.paystack.co/transfer",$params,
//            [
//                'Authorization: Bearer '.$key.'',
//                'Content-Type: application/json',
//            ]);
//
//        return json_decode($response);


    }

    public function closePlan($planType, $id)
    {

        if ($planType == 0) {
            $plan = new YouthGoal();
            $plan->where('id', $id)->update(['status' => 2]);
        } elseif ($planType == 1) {
            $plan = new SteadyGrowth();
            $plan->where('id', $id)->update(['status' => 2]);
        }
    }

    public function checkWithdrawal($planType, $planId)
    {

        $today = date('Y-m-d');

        if ($planType == 0) {
            $youth = new YouthGoal();
            $withdraw = $youth->select('withdrawal_date')->whereDate('withdrawal_date', '<=', $today)
                ->where('id', $planId)->get()->toArray();
            if (!empty($withdraw[0])) {

                return true;

            }
        } else {
            $steady = new SteadyGrowth();
            $withdraw = $steady->select('withdrawal_date')->whereDate('withdrawal_date', '<=', $today)
                ->where('id', $planId)->get()->toArray();
            if (!empty($withdraw[0])) {

                return true;

            }
        }

        return false;
    }



}