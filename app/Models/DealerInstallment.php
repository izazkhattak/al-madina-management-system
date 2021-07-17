<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DealerInstallment extends Model
{
    protected $fillable = [
        'dealer_id',
        'payment_date',
        'amount_paid',
        'remaining_amount',
        'payment_method',
        'cheque_draft_no'
    ];

    public function dealer() {
        return $this->belongsTo(Dealer::class);
    }
}
