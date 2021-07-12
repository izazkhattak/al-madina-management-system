<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'client_id',
        'project_id',
        'installment_id',
        'due_amount',
        'due_date',
        'paid',
        'paid_on',
        'out_stand',
        'sur_charge',
    ];
}
