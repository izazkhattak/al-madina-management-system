<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectPlan extends Model
{
    protected $fillable = [
        'project_id',
        'installment_years',
        'total_amount',
        'sur_charge',
        'dealer_commission'
    ];

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function clientInstallment() {
        return $this->hasManyThrough(ClientInstallment::class, Client::class, 'project_plan_id', 'client_id');
    }

    public function dealerInstallment() {
        return $this->hasManyThrough(DealerInstallment::class, Dealer::class, 'project_plan_id', 'dealer_id');
    }
}
