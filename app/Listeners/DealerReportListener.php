<?php

namespace App\Listeners;

use App\Models\DealerReport;

// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Queue\InteractsWithQueue;

class DealerReportListener
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
        $installment = $event->dealerInstallment;
        $installment->load('dealer.projectPlan.project');

        $reportData = array(
            'dealer_id' => $installment->dealer->id,
            'project_id' => $installment->dealer->projectPlan->project->id,
            'dealer_installment_id' => $installment->id,
            'due_amount' => $installment->dealer->total_amount,
            'paid' => $installment->amount_paid,
            'paid_on' => $installment->payment_date,
            'out_stand' => $installment->remaining_amount,
            'cheque_draft_no' => $installment->cheque_draft_no,
        );

        // Insert Report data record.
        if ($report = DealerReport::where('dealer_installment_id', $installment->id)->first()) {
            $report->update($reportData);
        } else {
            DealerReport::create($reportData);
        }

        return true;
    }
}
