<?php

namespace App\Http\Requests;

class ProjectPlanRequest extends BaseFormRequest
{

    protected function storeRules()
    {
        return [
            'project_id' => [
                'required'
            ],
            'installment_years' => [
                'required'
            ],
            'total_amount' => [
                'required'
            ],
            'sur_charge' => [
                'required'
            ],
            'dealer_commission' => [
                'required'
            ]
        ];
    }

    protected function updateRules()
    {
        $rules = $this->storeRules();

        array_walk($rules, function(&$value, $key) {
            array_unshift($value, 'sometimes');
        });

        return $rules;
    }
}
