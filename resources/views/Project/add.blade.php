@extends('layouts.app_main')

@section('content')
<section>
    <div class="container-fluid">
        <!-- Basic Validation -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>{{ isset($id) ? 'Update' : 'Add' }} Project</h2>
                        <ul class="header-dropdown">
                            <li class="dropdown">
                                <a href="javascript:void(0);" onclick="window.history.go(-1)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">arrow_back</i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <form action="{{ isset($id) ? route('projects.update', $id) : route('projects.store') }}" method="POST">
                            @csrf
                            @section("editMethod")
	                        @show
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" value="{{ old('title', isset($edit_title) ? $edit_title : '') }}" class="form-control @error('title') is-invalid @enderror" name="title">
                                    <label class="form-label">Title</label>
                                </div>
                                @error('title')
                                    <label class="error" role="alert">
                                        {{ $message }}
                                    </label>
                                @enderror
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <textarea name="description" cols="30" rows="5" class="form-control @error('title') is-invalid @enderror no-resize">{{ old('description', isset($edit_description) ? $edit_description : '') }}</textarea>
                                    <label class="form-label">Description</label>
                                </div>
                                @error('description')
                                    <label class="error" role="alert">
                                        {{ $message }}
                                    </label>
                                @enderror
                            </div>
                            <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Basic Validation -->
    </div>
</section>
@endsection
