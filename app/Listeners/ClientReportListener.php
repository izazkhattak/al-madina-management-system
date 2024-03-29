<?php

namespace App\Listeners;

use App\Models\ClientReport;

// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Queue\InteractsWithQueue;

class ClientReportListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $installment = $event->clientInstallment;
        $installment->load('client.projectPlan.project');

        $reportData = array(
            'client_id' => $installment->client->id,
            'project_id' => $installment->client->projectPlan->project->id,
            'client_installment_id' => $installment->id,
            'due_amount' => $installment->client->total_amount,
            'due_date' => $installment->client->due_date,
            'paid' => $installment->amount_paid,
            'paid_on' => $installment->payment_date,
            'out_stand' => $installment->remaining_amount,
            'sur_charge' => $installment->plenty,
        );

        // Insert Report data record.
        if ($report = ClientReport::where('client_installment_id', $installment->id)->first()) {
            $report->update($reportData);
        } else {
            ClientReport::create($reportData);
        }

        return true;
    }
}
