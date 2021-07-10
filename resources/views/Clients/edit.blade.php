@extends('Clients.add')

@section("editId", $client->id)
@section("edit_name", $client->name)
@section("edit_phone", $client->phone)
@section("edit_cnic", $client->cnic)
@section("edit_down_payment", $client->down_payment)
@section("edit_due_date", $client->due_date)


<?php $id = $client->id; ?>
<?php $project_plan_id = $client->project_plan_id; ?>

@section("editMethod")
	{{ method_field("PUT") }}
@endsection
