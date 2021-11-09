<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends BaseFormRequest
{

    protected function storeRules()
    {
        return [
            'name' => [
                'required'
            ],
            'phone' => [
                'required'
            ],
            'cnic' => [
                'required'
            ],
            'project_plan_id' => [
                'required', 'exists:project_plans,id'
            ],
            'total_amount' => [
                'required'
            ],
            'down_payment' => [
                'required'
            ],
            'due_date' => [
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
