@extends('ProjectPlan.add')

@section("editId", $projectPlan->id)
@section("edit_installment_years", $projectPlan->installment_years)
@section("edit_total_amount", $projectPlan->total_amount)
@section("edit_sur_charge", $projectPlan->sur_charge)
@section("edit_dealer_commission", $projectPlan->dealer_commission)


<?php $id = $projectPlan->id; ?>
<?php $projectID = $projectPlan->project_id; ?>

@section("editMethod")
	{{ method_field("PUT") }}
@endsection
