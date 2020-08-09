<?php

namespace App\Http\Controllers;

use App\Jobs\PlanCompleted;
use App\Mail\PlanNewSaving;
use App\Mail\PlanSavingFailed;
use App\Models\SteadyGrowth;
use App\Models\YouthGoal;
use App\Models\YouthSaving;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Mail;

class PlanNotifierController extends Controller
{
    //
    public function getCompletedPlans()
    {
        // get current date 
        $today =  Carbon::now()->toDateString();
        // fetch steady growth that fits the current date
        $steadyPlans = SteadyGrowth::where('withdrawal_date', $today)->get();
        // pass this list of plans to the job so it can handle mailing each of them.
        dispatch(new PlanCompleted($steadyPlans));

        // fetch youth goals that does
        $youthPlans = YouthGoal::where('withdrawal_date', $today)->get();
        // pass this list of plans to the job so it can handle mailing each of them.
        dispatch(new PlanCompleted($youthPlans));
    }

    public function newSavingsMade($planId, $amount, $planType = null, $tnxId = null, $refNo = null, $type='success')
    {
        // if plan type is not null, then we know the plan we are heading for
        if (!is_null($planType)) {
            if ($planType == 0) {
                // youth
                $plan = YouthGoal::findorfail($planId);
            } else {
                // steady
                $plan = SteadyGrowth::findorfail($planId);
            }
        } else {
            // if not, find from the savings using the tnxid and refNo, then get the plan we are heading for
            $exist = YouthSaving::where([['ref_no', $refNo], ['transact_id', $tnxId]])->first();
            if (isset($exist)) {
                $plan = YouthGoal::findorfail($planId);
            } else {
                // steady
                $plan = SteadyGrowth::findorfail($planId);
            }
        }

        //if we have a plan at this point continue
        if (isset($plan)) {
            // get the plan details
            // get the user details
            // format a 4 required data, user first name, plan name, amount and next charge date
            $data = [
                'name' => Auth::user()->name,
                'planName' => $plan->plan_name,
                'nextDate' => is_null($plan->next_savings) ? 'N/A' : Carbon::parse($plan->next_savings)->toFormattedDateString(),
                'amount' => number_format($amount,2)
            ];
            // TODO check if it is a success or failure
            
            // send it to the mailer
            if($type=='success') {
                Mail::to(Auth::user()->email)->send(new PlanNewSaving($data));
            } else {
                Mail::to(Auth::user()->email)->send(new PlanSavingFailed($data));
            }
        }
    }
}
