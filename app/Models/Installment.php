<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $fillable = [
        'client_id',
        'payment_date',
        'plenty',
        'amount_paid',
        'remaining_amount'
    ];

    public function client() {
        return $this->belongsTo(Client::class);
    }
}
