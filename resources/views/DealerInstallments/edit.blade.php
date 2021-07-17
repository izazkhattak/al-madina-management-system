@extends('DealerInstallments.add')

<?php

$edit_payment_date = $dealerInstallment->payment_date;
$edit_amount_paid = $dealerInstallment->amount_paid;
$edit_remaining_amount = $dealerInstallment->remaining_amount;
$edit_payment_method = $dealerInstallment->payment_method;
$edit_cheque_draft_no = $dealerInstallment->cheque_draft_no;

?>


<?php $id = $dealerInstallment->id; ?>
<?php $dealer_id = $dealerInstallment->dealer_id; ?>

@section("editMethod")
	{{ method_field("PUT") }}
@endsection
