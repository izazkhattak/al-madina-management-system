<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientReport extends Model
{
    protected $fillable = [
        'client_id',
        'project_id',
        'client_installment_id',
        'due_amount',
        'due_date',
        'paid',
        'paid_on',
        'out_stand',
        'sur_charge',
    ];

    public function client() {
        return $this->belongsTo(Client::class);
    }
    public function project() {
        return $this->belongsTo(Project::class);
    }
}
