<?php

namespace App\Jobs;

use App\Mail\PlanCompleted as PlanMailCompleted;
use App\Models\MaturedSaving;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class PlanCompleted implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $plans;
    public function __construct($plans)
    {
        $this->plans = $plans;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // for each plan
        foreach ($this->plans as $plan) {
            // get the user email
            $user = User::findorfail($plan->user_id);

            // we try to get the final balance of the user using user id, plan id and the plan type.
            $matured = MaturedSaving::where([
                ['user_id', $plan->user_id],[ 'plan_id', $plan->id],[ 'plan_type', $plan->plan_type]
                ])->first();

            if (!is_null($matured)) {
                // if we have a hit
                // send out an email
                Mail::to($user->email)->send(new PlanMailCompleted($plan->plan_name, $matured->balance, $user->name));
                                
            } else {
                // if we dont, thats a problem. TODO
            }
        }
    }
}
