@extends('Clients.add')

<?php

$edit_name = $client->name;
$edit_phone = $client->phone;
$edit_cnic = $client->cnic;
$edit_total_amount = $client->total_amount;
$edit_down_payment = $client->down_payment;
$edit_due_date = $client->due_date;

$id = $client->id;
$project_plan_id = $client->project_plan_id;

?>

@section("editMethod")
	{{ method_field("PUT") }}
@endsection
