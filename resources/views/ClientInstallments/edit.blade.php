@extends('ClientInstallments.add')

<?php

$edit_payment_date = $clientInstallment->payment_date;
$edit_plenty = $clientInstallment->plenty;
$edit_amount_paid = $clientInstallment->amount_paid;
$edit_remaining_amount = $clientInstallment->remaining_amount;

$edit_payment_method = $clientInstallment->payment_method;
$edit_cheque_draft_no = $clientInstallment->cheque_draft_no;

$id = $clientInstallment->id;
$client_id = $clientInstallment->client_id;

?>

@section("editMethod")
	{{ method_field("PUT") }}
@endsection
