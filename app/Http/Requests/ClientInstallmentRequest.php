<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientInstallmentRequest extends BaseFormRequest
{

    protected function storeRules()
    {
        return [
            'client_id' => [
                'required', 'exists:clients,id'
            ],
            'payment_date' => [
                'required'
            ],
            'amount_paid' => [
                'required'
            ],
            'payment_method' => [
                'required'
            ],
            'cheque_draft_no' => [
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
