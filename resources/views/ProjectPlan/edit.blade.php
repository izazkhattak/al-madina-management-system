@extends('ProjectPlan.add')

<?php
$edit_installment_years = $projectPlan->installment_years;
$edit_total_amount = $projectPlan->total_amount;
$edit_sur_charge = $projectPlan->sur_charge;
$edit_dealer_commission = $projectPlan->dealer_commission;

$id = $projectPlan->id;
$projectID = $projectPlan->project_id;

?>

@section("editMethod")
	{{ method_field("PUT") }}
@endsection
