<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientInstallment extends Model
{
    protected $fillable = [
        'client_id',
        'payment_date',
        'amount_paid',
        'plenty',
        'remaining_amount',
        'payment_method',
        'cheque_draft_no'
    ];

    public function client() {
        return $this->belongsTo(Client::class);
    }
}
