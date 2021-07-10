@extends('Project.add')

@section("editId", $project->id)
@section("editTitle", $project->title)
@section("editDescription", $project->description)


<?php $id = $project->id; ?>

@section("editMethod")
	{{ method_field("PUT") }}
@endsection
