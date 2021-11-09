<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'due_date',
        'client_id',
        'project_id',
        'amount_paid',
        'remaining_amount',
        'total_amount',
        'installments'
    ];
}
