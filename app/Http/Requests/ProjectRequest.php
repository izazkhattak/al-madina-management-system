<?php

namespace App\Http\Requests;

class ProjectRequest extends BaseFormRequest
{

    protected function storeRules()
    {
        return [
            'title' => [
                'required'
            ],
            'description' => [
                'required'
            ],
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
