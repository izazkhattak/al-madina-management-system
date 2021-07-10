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
}
