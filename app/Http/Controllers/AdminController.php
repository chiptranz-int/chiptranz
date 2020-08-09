<?php

namespace App\Http\Controllers;

use App\Helpers\ApplicationHelper;
use App\Models\YouthSaving;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    public $help;

    public function __construct()
    {
        $this->middleware('auth');
        $this->help = new ApplicationHelper();
    }

    public function customers()
    {

        if (Auth::user()->user_type == 0) {
            return view('home');
        }
        $customers = $this->help->getAllUsers();

        return view('admin.customers')->with(compact(['customers']));
    }

    public function searchCustomers(Request $request)
    {
        if (Auth::user()->user_type == 0) {
            return view('home');
        }
        $query = $request->get('query');

        $user = new User();
        $customers = $user->where(function ($quest) use ($query) {
            $quest->orWhere('name', 'regexp', $query)
                ->orWhere('last_name', 'regexp', $query)
                ->orWhere('email', 'regexp', $query)
                ->orWhere('telephone', 'regexp', $query);

        })
            ->where('user_type', 0)
            ->latest()->paginate('30');

        return view('admin.customers')->with(compact(['customers']));
    }

    public function youthGoals(Request $request)
    {
        if (Auth::user()->user_type == 0) {
            return view('home');
        }
        $query = $request->get('item');
        $page = [];
        $type = 'all';
        if ($query == 'all') {
            $type = 'all';
            $page = $this->help->getAllYouthPlan();
        } elseif ($query == 'active') {
            $type = 'active';
            $page = $this->help->getActiveYouthPlan();
        } elseif ($query == 'expired') {
            $type = 'expired';
            $page = $this->help->getExpiredYouthPlan();
        }

        $plans = $this->filterPlan($page);

        return view('admin.youths')->with(compact(['page', 'plans', 'type']));

    }

    public function steadyPlans(Request $request)
    {
        if (Auth::user()->user_type == 0) {
            return view('home');
        }
        $query = $request->get('item');
        $page = [];
        $type = 'all';
        if ($query == 'all') {
            $type = 'all';
            $page = $this->help->getAllSteadyPlan();
        } elseif ($query == 'active') {
            $type = 'active';
            $page = $this->help->getActiveSteadyPlan();
        } elseif ($query == 'expired') {
            $type = 'expired';
            $page = $this->help->getExpiredSteadyPlan();
        }

        $plans = $this->filterPlan($page);

        return view('admin.steady')->with(compact(['page', 'plans', 'type']));
    }

    public function filterPlan($plans)
    {

        $thePlan = [];

        foreach ($plans as $plan) {
            $name = $this->help->userName($plan['user_id']);

            $plan['name'] = $name;

            $plan['expires'] = $this->help->daysExpiring($plan['withdrawal_date']);

            $thePlan[] = $plan;
        }

        return $thePlan;
    }

    public function dashboard()
    {
        if (Auth::user()->user_type == 0) {
            return view('home');
        }
        $totalYouthSavings = $this->help->generalLifetimeYouthSavings();

        $totalYouthWithdrawal = $this->help->generalLifetimeYouthWithdrawals();

        $totalSteadySavings = $this->help->generalLifetimeSteadySavings();
        $totalSteadyWithdrawal = $this->help->generalLifetimeSteadyWithdrawals();

        $save = new YouthSaving();
        $saving = $save->where('status', 1)->latest('updated_at')->take(15)->get()->toArray();
        $savings = [];
        foreach ($saving as $theSave) {
            $name = $this->help->userName($theSave['user_id']);

            $theSave['name'] = $name;

            $savings[] = $theSave;
        }



        return view('admin.dashboard')->with(compact(['totalYouthSavings', 'totalYouthWithdrawal',
            'totalSteadySavings', 'totalSteadyWithdrawal', 'savings']));

    }


    public function youthSavingsHistory($id, $userId)
    {
        if (Auth::user()->user_type == 0) {
            return view('home');
        }
        $goal = $this->help->getYouthGoalById($id);
        $planName = '';

        if (!empty($goal)) {
            $planName = $goal['plan_name'];
        }

        $totalSaved = $this->help->getTotalYouthSavings($userId, $id);

        $totalWithdrawn = $this->help->getTotalYouthWithdrawals($userId, $id);

        $savings = $this->help->getYouthSavings($id, $userId);

        $type = 'Youth Savings';

        $name = $this->help->userName($userId);

        return view('admin.savings')->with(compact(['planName', 'totalSaved', 'totalWithdrawn', 'savings', 'type', 'name']));
    }

    public function steadySavingsHistory($id, $userId)
    {
        if (Auth::user()->user_type == 0) {
            return view('home');
        }
        $goal = $this->help->getSteadyGrowthById($id);
        $planName = '';

        if (!empty($goal)) {
            $planName = $goal['plan_name'];
        }

        $totalSaved = $this->help->getTotalSteadySavings($userId, $id);

        $totalWithdrawn = $this->help->getTotalSteadyWithdrawals($userId, $id);

        $savings = $this->help->getSteadySavings($id, $userId);

        $type = 'Steady Savings';

        $name = $this->help->userName($userId);

        return view('admin.savings')->with(compact(['planName', 'totalSaved', 'totalWithdrawn', 'savings', 'type', 'name']));
    }


}
