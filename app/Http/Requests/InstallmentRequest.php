<?php

namespace App\Http\Requests;

class InstallmentRequest extends BaseFormRequest
{

    protected function storeRules()
    {
        return [
            'client_id' => [
                'required'
            ],
            'payment_date' => [
                'required'
            ],
            'amount_paid' => [
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
