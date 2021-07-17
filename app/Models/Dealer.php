<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'cnic',
        'project_plan_id',
        'total_amount',
        'monthly_installments'
    ];

    public function projectPlan() {
        return $this->belongsTo(ProjectPlan::class);
    }
}
