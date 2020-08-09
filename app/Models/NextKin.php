<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NextKin extends Model
{
    //
    protected $table = "next_kins";

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'telephone',
        'bank_account',
        'bank_name',
        'gender'
    ];
}
