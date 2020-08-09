<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YouthSaving extends Model
{
    //

    protected $fillable = [

        'transact_id',
        'amount_deposited',
        'date_deposited',
        'deposit_type',
        'status',
        'ref_no',
        'user_id',
        'plan_id',
    ];
}
