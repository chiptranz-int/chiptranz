<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YouthGoal extends Model
{
    //
    protected $fillable = ['user_id','plan_type','status','transact_id','frequency','amounts','next_savings','withdrawal_date','start_date','plan_name','frequency_id'];
}
