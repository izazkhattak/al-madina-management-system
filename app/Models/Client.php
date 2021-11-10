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
        'total_amount',
        'down_payment',
        'due_date',
        'monthly_installments'
    ];

    public function projectPlan() {
        return $this->belongsTo(ProjectPlan::class);
    }

    public function clientInstallments() {
        return $this->hasMany(ClientInstallment::class, 'client_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'client_id');
    }
}
