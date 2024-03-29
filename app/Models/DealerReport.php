<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DealerReport extends Model
{
    protected $fillable = [
        'dealer_id',
        'project_id',
        'dealer_installment_id',
        'due_amount',
        'due_date',
        'paid',
        'paid_on',
        'out_stand',
        'cheque_draft_no',
    ];

    public function dealer() {
        return $this->belongsTo(Dealer::class);
    }
}
