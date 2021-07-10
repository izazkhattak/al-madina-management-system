<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'cnic',
        'project_plan_id',
        'down_payment',
        'due_date',
        'monthly_installments'
    ];
}
