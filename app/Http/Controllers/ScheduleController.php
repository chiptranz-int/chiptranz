<?php

namespace App\Http\Controllers;

use App\Helpers\ApplicationHelper;
use App\Models\SteadyGrowth;
use App\Models\YouthGoal;
use Exception;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    //

    public function initializeYouthsDeductions()
    {

        $help = new ApplicationHelper();

        $today = $help->getToday();

        $goals = $help->getUnInitializeYouthGoals($today);


        $help->initializeYouthSavings($goals);


    }

    public function processYouthsDeductions()
    {

        $help = new ApplicationHelper();

        $youths = $help->retrieveUnprocessedYouthSavings();

        $this->processDeductions($help, $youths, 0);


    }


    public function initializeSteadyDeductions()
    {
        $help = new ApplicationHelper();

        $today = $help->getToday();

        $steady = $help->getUnInitializeSteadyGrowth($today);


        $help->initializeSteadySavings($steady);
    }

    public function processSteadyDeductions()
    
        {

            $help = new ApplicationHelper();
    
            $steady = $help->retrieveUnprocessedSteadySavings();
    
            $this->processDeductions($help, $steady, 1);
    
    
        }
    
    


    public function processDeductions(ApplicationHelper $help, $plans, $planType)
    {
        $notifer = new PlanNotifierController();

        $response = '';
        foreach ($plans as $plan) {
            try {
                $authCode = $help->getCardAuthCode($plan['transact_id']);
                $amount = $plan['amount_deposited'] * 100;
                $email = $help->getUserEmailById($plan['user_id']);
                if (!empty($authCode)) {

                    $results = $help->recurrentCharge($authCode, $amount, $email);

                    $help->verifyAndSafe($results, $plan['id'], $planType);
                    // this part of the function is success 
                    $this->planNotifier->newSavingsMade($plan['id'], $amount, $planType, null, null);

                }
            } catch (Exception $e) {
                $this->planNotifier->newSavingsMade($plan['id'], $amount, $planType, null, null, 'failure');
            }

        }
    }

    public function deductions()
    {

        $help = new ApplicationHelper();

        $authorizationCode = "Auth_test";

        $email = "folateju483@gmail.com";
        $amount = 100;
        $results = $help->recurrentCharge($authorizationCode, $amount, $email);
        $data = $results['data'];
        print_r($data);
        $success = "success";
        $status = $data['status'];
        $reference = $data['reference'];
        print_r("Status " . $status);
        print_r("Reference " . $reference);
    }


    public function nextDate($planId)
    {
        $help = new ApplicationHelper();
        $help->generateNextSavingsDate($planId);
    }

    public function lockMaturedPlan(){

        $help = new ApplicationHelper();
        $today = $help->getToday();
        $youth = new YouthGoal();
        $youthSavings = $youth->where('withdrawal_date', $today)->get()->toArray();
        $help->lockMaturedPlan($youthSavings);

        $steady = new SteadyGrowth();
        $steadySavings = $steady->where('withdrawal_date', $today)->get()->toArray();
        $help->lockMaturedPlan($steadySavings);


    }

}
