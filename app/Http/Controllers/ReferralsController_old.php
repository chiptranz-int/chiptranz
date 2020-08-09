<?php

namespace App\Http\Controllers;

use App\User;
use App\Referral;
use App\Youth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReferralsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //dd(Auth::user()->id);
        
        $defaultAmount = Db::table('referral_bonus')->where('type', 'default')->first();
        $commission = $defaultAmount->amount;

        $id = Auth::user()->id;
        $users = User::all()->where('id', $id);
        foreach ($users as $user) {
            # code...
            $name = $user->name;
            $email = $user->email;
        }
        $check = Referral::all()->where('user_id', $id);
        $checks = count($check);

        if ($checks == 0) 
        {
            # code...
            
        $refCode = substr($name, 0,3).substr(str_shuffle(sha1($email)), 0,7);
        $insert = Db::table('referrals')->insert(['user_id' => $id, 'ref_code' => $refCode]);
        //$records = Referral::all()->where('user_id', '=',  $id);
        }else{

        }

        $records = Referral::all()->where('user_id', '=',  $id);
        $totalShared = count($records);

        $record = Referral::all()->where('user_id', '=',  $id)->first();
        
        $ref_code = $record->ref_code;
        

        $refCodeUsed = User::all()->where('ref_code', $ref_code);
        $totalShared = count($refCodeUsed);
        
        $youth = Db::table('users')
        ->join('youth_savings', 'users.id', '=', 'youth_savings.user_id')
        ->where('users.ref_code', '=',  $ref_code)
        ->where('youth_savings.amount_deposited', '>=', 100)
        ->groupBy('youth_savings.user_id')
        ->get();
        if (count($youth) == 0) {
            # code...
        
        

        $steady = Db::table('users')
        ->join('steady_savings', 'users.id', '=', 'steady_savings.user_id')
        ->where('users.ref_code', '=',  $ref_code)
        ->where('steady_savings.amount_deposited', '>=', 100)
        ->groupBy('steady_savings.user_id')
        ->get();
        if (count($steady) == 0) {
            # code...
            $totalReferral = count($steady);
            $currentReward = $totalReferral * $commission;
            return view('referral.index',['ref_code' => $ref_code, 'currentReward' => $currentReward, 'totalReferral' => $totalReferral, 'commission' => $commission, 'totalShared' => $totalShared]);
            
        }else {
            $totalReferral = count($steady);
            $currentReward = $totalReferral * $commission;
            return view('referral.index',['ref_code' => $ref_code, 'currentReward' => $currentReward, 'totalReferral' => $totalReferral, 'commission' => $commission, 'totalShared' => $totalShared]);
        }
        }else{
            $totalReferral = count($youth);
            $currentReward = $totalReferral * $commission;
        
                   
        

        return view('referral.index',['ref_code' => $ref_code, 'currentReward' => $currentReward, 'totalReferral' => $totalReferral, 'commission' => $commission, 'totalShared' => $totalShared]);

            }
        
        


        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
