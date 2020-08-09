<?php
/**
 * Created by PhpStorm.
 * User: MoFoLuWaSo
 * Date: 9/22/2019
 * Time: 10:59 PM
 */

namespace App\Helpers;


use App\Http\Controllers\PlanController;
use App\Models\AccountDetail;
use App\Models\MaturedSaving;
use App\Models\NextKin;
use App\Models\SteadyGrowth;
use App\Models\SteadySaving;
use App\Models\SteadyWithdrawal;
use App\Models\UserLog;
use App\Models\YouthGoal;
use App\Models\YouthSaving;
use App\Models\YouthWithdrawal;
use App\User;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Auth;

class ApplicationHelper extends PlanHelper
{

    public function getAllUsers()
    {
        $user = new User();
        $users = $user->where('user_type', 0)->latest()->paginate(30);
        return $users;
    }

    public function updateUserFlag($flag)
    {
        $user = new User();
        $user->where('id', Auth::user()->id)->update([
            'flag' => $flag,
        ]);
    }

    public function getUserEmailById($id)
    {
        $user = new User();
        $users = $user->select('email')->where('id', $id)->get()->toArray();
        if (!empty($users[0])) {
            return $users[0]['email'];
        } else {
            return 'signup@chiptranz.com';
        }
    }

    public function getToday()
    {
        date_default_timezone_set("Africa/Lagos");

        return date('Y-m-d');
    }

    public function getNDay($n)
    {
        date_default_timezone_set("Africa/Lagos");
        return date('Y-m-d', strtotime($n . ' days'));
    }

    public function userActivity($userId)
    {
        $log = new UserLog();
        $logs = $log->where('user_id', $userId)
            ->latest('created_at')->take(5)->get()->toArray();

        if (empty($logs[0])) {
            return array();
        } else {
            return $logs;
        }
    }

    public function getFrequency($frequency)
    {
        switch ($frequency) {

            case 1:
                return "Daily";
            case 2:
                return "Weekly";
            case 3:
                return "Monthly";
            default:
                return "Nill";
        }


    }

    public function nextKin($userId)
    {

        $kin = new NextKin();
        $kins = $kin->where('user_id', $userId)->get()->toArray();
        try {

            return $kins[0];
        } catch (Exception $e) {
            return array();
        }
    }

    public function savingsSummary($userId)
    {
        $saved = $this->totalSavedByUserId($userId);

    }

    public function savingsOnYouthPlan($userId)
    {

        $youths = $this->getAllYouthGoals($userId);

        $savingsGoal = array('balance' => 0, 'savings' => 0, 'returns' => 0, 'withdrawals' => 0);

        foreach ($youths as $youth) {
            $planId = $youth['id'];
            $startDate = $youth['start_date'];
            $frequency = $youth['frequency'];
            $frequencyId = $youth['frequency_id'];

            $today = $this->getToday();

            $amountSaved = $this->totalSavedOnYouth($userId, $planId);

            $daysSaved = $this->getDaysSaved($startDate, $today);

            $rate = $this->getUserInterestRate($frequencyId, $frequency);

            $savings = $this->computeSavings($amountSaved[0], $daysSaved, $rate, $youth['withdrawal_date'], $youth['id'], $youth['plan_type'], $userId);

            $savingsGoal['balance'] += $savings['balance'];
            $savingsGoal['savings'] += $savings['savings'];
            $savingsGoal['returns'] += $savings['returns'];
            $savingsGoal['withdrawals'] += $amountSaved[1];

        }

        return $savingsGoal;
    }

    public function collateYouthSavings($savings)
    {
        $eachSavings = array();

        foreach ($savings as $saving) {


            $save = $this->savingsOnAYouthPlan($saving['user_id'], $saving['id']);
            $saving['savings_summary'] = $save;
            $saving['plan_card'] = $this->getCardOnPlan($saving['transact_id']);
            $eachSavings [] = $saving;
        }

        return $eachSavings;

    }

    public function savingsOnAYouthPlan($userId, $id)
    {

        $youth = $this->getYouthGoalById($id);

        $savingsGoal = array('balance' => 0, 'savings' => 0, 'returns' => 0, 'withdrawals' => 0);


        $planId = $youth['id'];
        $startDate = $youth['start_date'];
        $frequency = $youth['frequency'];
        $frequencyId = $youth['frequency_id'];

        $today = $this->getToday();

        $amountSaved = $this->totalSavedOnYouth($userId, $planId);

        $daysSaved = $this->getDaysSaved($startDate, $today);

        $rate = $this->getUserInterestRate($frequencyId, $frequency);

        $savings = $this->computeSavings($amountSaved[0], $daysSaved, $rate, $youth['withdrawal_date'], $planId, $youth['plan_type'], $userId);


        $savingsGoal['balance'] += $savings['balance'];
        $savingsGoal['savings'] += $savings['savings'];
        $savingsGoal['returns'] += $savings['returns'];
        $savingsGoal['withdrawals'] += $amountSaved[1];


        return $savingsGoal;
    }

    public function savingsOnSteadyPlan($userId)
    {

        $steadies = $this->getAllSteadyGrowth($userId);

        $savingsGoal = array('balance' => 0, 'savings' => 0, 'returns' => 0, 'withdrawals' => 0);

        foreach ($steadies as $steady) {
            $planId = $steady['id'];
            $startDate = $steady['start_date'];
            $frequency = $steady['frequency'];
            $frequencyId = $steady['frequency_id'];

            $today = $this->getToday();

            $amountSaved = $this->totalSavedOnSteady($userId, $planId);

            $daysSaved = $this->getDaysSaved($startDate, $today);

            $rate = $this->getUserInterestRate($frequencyId, $frequency);

            $savings = $this->computeSavings($amountSaved[0], $daysSaved, $rate, $steady['withdrawal_date'], $steady['id'], $steady['plan_type'], $userId);

            $savingsGoal['balance'] += $savings['balance'];
            $savingsGoal['savings'] += $savings['savings'];
            $savingsGoal['returns'] += $savings['returns'];
            $savingsGoal['withdrawals'] += $amountSaved[1];

        }

        return $savingsGoal;
    }

    public function collateSteadySavings($savings)
    {
        $eachSavings = array();

        foreach ($savings as $saving) {
            $save = $this->savingsOnASteadyPlan($saving['user_id'], $saving['id']);
            $saving['savings_summary'] = $save;
            $saving['plan_card'] = $this->getCardOnPlan($saving['transact_id']);
            $eachSavings [] = $saving;
        }

        return $eachSavings;

    }

    public function savingsOnASteadyPlan($userId, $id)
    {

        $steady = $this->getSteadyGrowthById($id);

        $savingsGoal = array('balance' => 0, 'savings' => 0, 'returns' => 0, 'withdrawals' => 0);


        $planId = $steady['id'];
        $startDate = $steady['start_date'];
        $frequency = $steady['frequency'];
        $frequencyId = $steady['frequency_id'];

        $today = $this->getToday();

        $amountSaved = $this->totalSavedOnSteady($userId, $planId);

        $daysSaved = $this->getDaysSaved($startDate, $today);

        $rate = $this->getUserInterestRate($frequencyId, $frequency);

        $savings = $this->computeSavings($amountSaved[0], $daysSaved, $rate, $steady['withdrawal_date'], $steady['id'], $steady['plan_type'], $userId);

        $savingsGoal['balance'] += $savings['balance'];
        $savingsGoal['savings'] += $savings['savings'];
        $savingsGoal['returns'] += $savings['returns'];
        $savingsGoal['withdrawals'] += $amountSaved[1];


        return $savingsGoal;
    }

    public function getDaysSaved($startDate, $lastDate)
    {

        $start = new DateTime($startDate . " 12:00:00");

        $stop = new DateTime($lastDate . " 12:00:00");

        $interval = date_diff($start, $stop);

        $days = $interval->days;

        return $days;

    }


    public function computeSavings($amountSaved, $daysSaved, $rate, $withdrawalDate, $planId, $planType, $userId)
    {


        $interestRate = $rate / 100;

        //$interest = $amountSaved * ($interestRate);

        $increase = 0;
        if ($daysSaved != 0) {

            $increase = $amountSaved / $daysSaved;
        }

        $totalPrincipal = 0;
        $totalInterest = 0;
        $balance = 0;
        for ($i = 0; $i < $daysSaved; $i++) {
            $interest = 0;
            if ($i == 0) {
                $totalPrincipal = $increase;
            } else {
                $totalPrincipal += $increase;
            }


            $interest = $totalPrincipal * ($interestRate / 365);


            $totalInterest += $interest;


        }


        $balance = ($totalPrincipal + $totalInterest);

        $finalBalance = array(
            'balance' => round($balance, 2),
            'savings' => round($amountSaved, 2),
            'returns' => round($totalInterest, 2),
        );
        $thisday = $this->getToday();
        // try {
        $today = new DateTime($thisday . " 12:00:00");

        $withdrawDay = new DateTime($withdrawalDate . " 12:00:00");

        if ($withdrawDay <= $today) {

            return $this->lockPlan($planType, $planId, $finalBalance, $userId);

        }
        // } catch (Exception $e) {
        //  }


        return $finalBalance;


    }

    public function lockPlan($planType, $planId, $finalBalance, $userId)
    {

        if ($planType == 0) {
            $youth = new YouthGoal();
            $youth->where('id', $planId)->update([
                'status' => 3
            ]);
        } elseif ($planType == 1) {
            $steady = new SteadyGrowth();
            $steady->where('id', $planId)->update([
                'status' => 3
            ]);
        }

        $matured = new MaturedSaving();
        $maturity = $matured->where('plan_id', $planId)->get()->toArray();

        if (empty($maturity[0])) {
            $matured = new MaturedSaving();
            $matured->plan_id = $planId;
            $matured->user_id = $userId;
            $matured->plan_type = $planType;
            $matured->balance = $finalBalance['balance'];
            $matured->savings = $finalBalance['savings'];
            $matured->returns = $finalBalance['returns'];
            $matured->save();
            return $finalBalance;
        } else {

            $matured1 = new MaturedSaving();
            $maturity1 = $matured1->where('plan_id', $planId)
                ->update([
                    'balance' => $maturity[0]['returns'] + $finalBalance['savings'],
                    'savings' => $finalBalance['savings']
                ]);

            return array(
                'balance' => $maturity[0]['returns'] + $finalBalance['savings'],
                'savings' => $finalBalance['savings'],
                'returns' => $maturity[0]['returns']
            );


        }


    }

    public function generateNextSavingsDate($planId)
    {
        $youth = new YouthGoal();
        $youths = $youth->select('start_date', 'frequency')->where('id', $planId)->get()->toArray();

        $today = $this->getToday();

        $days = $this->getDaysSaved($youths[0]['start_date'], $today);

        $nextDate = $youths[0]['start_date'];
        $start = new DateTime($today . " 12:00:00");

        for ($i = 1; $i <= $days; $i++) {

            $nextDate = $this->nextSavingsDate($nextDate, $youths[0]['frequency']);


            $stop = new DateTime($nextDate . " 12:00:00");

            if ($stop > $start) {
                break;
            }
        }


    }

    public function getRequestCode()
    {
        $number = random_int(10000, 19999);
        return $number;
    }

    public function getRecipientCode($userId)
    {
        $bank = new AccountDetail();
        $code = $bank->select('recipient_code')->where('user_id', $userId)->get()->toArray();
        try {
            return $code[0]['recipient_code'];
        } catch (Exception $e) {

            return '';
        }

    }

    public function lockMaturedPlan($plans)
    {
        foreach ($plans as $plan) {
            $planId = $plan['id'];
            $startDate = $plan['start_date'];
            $frequency = $plan['frequency'];
            $frequencyId = $plan['frequency_id'];

            $today = $this->getToday();

            $amountSaved = $this->totalSavedOnYouth($plan['user_id'], $planId);

            $daysSaved = $this->getDaysSaved($startDate, $today);

            $rate = $this->getUserInterestRate($frequencyId, $frequency);

            $savings = $this->computeSavings($amountSaved[0], $daysSaved, $rate, $plan['withdrawal_date'], $plan['id'], $plan['plan_type'], $plan['user_id']);

        }
    }

    public function getActiveYouthPlan()
    {
        $today = $this->getToday();
        $youth = new YouthGoal();

        $youths = $youth->where('transact_id', '!=', 0)->whereDate('withdrawal_date', '>', $today)->orderBy('withdrawal_date', 'asc')->paginate(30);

        return $youths;

    }

    public function getExpiredYouthPlan()
    {
        $today = $this->getToday();
        $youth = new YouthGoal();

        $youths = $youth->where('transact_id', '!=', 0)->whereDate('withdrawal_date', '<=', $today)->orderBy('withdrawal_date', 'desc')->paginate(30);

        return $youths;

    }

    public function getAllYouthPlan()
    {
        $today = $this->getToday();
        $youth = new YouthGoal();

        $youths = $youth->where('transact_id', '!=', 0)->latest('withdrawal_date')->paginate(30);

        return $youths;

    }

    public function getActiveSteadyPlan()
    {
        $today = $this->getToday();
        $youth = new SteadyGrowth();

        $youths = $youth->where('transact_id', '!=', 0)->whereDate('withdrawal_date', '>', $today)->orderBy('withdrawal_date', 'asc')->paginate(30);

        return $youths;

    }

    public function getExpiredSteadyPlan()
    {
        $today = $this->getToday();
        $youth = new SteadyGrowth();

        $youths = $youth->where('transact_id', '!=', 0)->whereDate('withdrawal_date', '<=', $today)->orderBy('withdrawal_date', 'desc')->paginate(30);

        return $youths;

    }

    public function getAllSteadyPlan()
    {
        $today = $this->getToday();

        $youth = new SteadyGrowth();

        $youths = $youth->where('transact_id', '!=', 0)->latest('withdrawal_date')->paginate(30);

        return $youths;

    }

    public function userName($userId)
    {

        $user = new User();

        $users = $user->select('name', 'last_name')->where('id', $userId)->get()->toArray();

        if (!empty($users[0])) {
            return $users[0]['name'] . ' ' . $users[0]['last_name'];
        }

        return '';
    }

    public function daysExpiring($withdrawalDate)
    {

        $today = $this->getToday();

        return $this->getDaysSaved($today, $withdrawalDate);
    }

    public function generalLifetimeYouthSavings()
    {

        $saving = new YouthSaving();
        $total = $saving->where('status', 1)->sum('amount_deposited');

        return $total;
    }

    public function generalLifetimeYouthWithdrawals()
    {
        $withdraw = new YouthWithdrawal();

        $total = $withdraw->where('status', 1)->sum('amount');
        return $total;

    }

    public function generalLifetimeSteadySavings()
    {
        $saving = new SteadySaving();
        $total = $saving->where('status', 1)->sum('amount_deposited');

        return $total;
    }

    public function generalLifetimeSteadyWithdrawals()
    {
        $withdraw = new SteadyWithdrawal();

        $total = $withdraw->where('status', 1)->sum('amount');
        return $total;
    }


}