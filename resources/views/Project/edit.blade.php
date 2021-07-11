@extends('Project.add')

<?php

$edit_title = $project->title;
$edit_description = $project->description;

$id = $project->id;

?>

@section("editMethod")
	{{ method_field("PUT") }}
@endsection
