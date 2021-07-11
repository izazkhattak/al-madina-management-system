@extends('Installments.add')

<?php

$edit_payment_date = $installment->payment_date;
$edit_plenty = $installment->plenty;
$edit_amount_paid = $installment->amount_paid;
$edit_remaining_amount = $installment->remaining_amount;

?>


<?php $id = $installment->id; ?>
<?php $client_id = $installment->client_id; ?>

@section("editMethod")
	{{ method_field("PUT") }}
@endsection
