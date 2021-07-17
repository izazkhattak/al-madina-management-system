@extends('Dealers.add')

<?php

$edit_name = $dealer->name;
$edit_phone = $dealer->phone;
$edit_cnic = $dealer->cnic;
$edit_total_amount = $dealer->total_amount;

$id = $dealer->id;
$project_plan_id = $dealer->project_plan_id;

?>

@section("editMethod")
	{{ method_field("PUT") }}
@endsection
