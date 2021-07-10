@extends('layouts.app_main')

@section('content')
<section class="content">
    <div class="container-fluid">
        <!-- Basic Validation -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>{{ isset($id) ? 'Update' : 'Add' }} Project Plan</h2>
                        <ul class="header-dropdown">
                            <li class="dropdown">
                                <a href="javascript:void(0);" onclick="window.history.go(-1)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">arrow_back</i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <form action="{{ isset($id) ? route('project-plans.update', $id) : route('project-plans.store') }}" method="POST">
                            @csrf
                            @section("editMethod")
	                        @show
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select name="project_id" class="form-control" id="project_id">
                                        <option value="">Please select a project</option>
                                        @forelse ($projects as $project)

                                        <option {{ isset($projectID) && $projectID == $project->id ? 'selected' : '' }} value="{{ $project->id }}">{{ $project->title }}</option>

                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                @error('project_id')
                                    <label class="error" role="alert">
                                        {{ $message }}
                                    </label>
                                @enderror
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="number" value="@yield('edit_installment_years')" name="installment_years" class="form-control">
                                    <label class="form-label">Installment years</label>
                                </div>
                                @error('installment_years')
                                    <label class="error" role="alert">
                                        {{ $message }}
                                    </label>
                                @enderror
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="number" value="@yield('edit_total_amount')" name="total_amount" class="form-control">
                                    <label class="form-label">Total amount</label>
                                </div>
                                @error('total_amount')
                                    <label class="error" role="alert">
                                        {{ $message }}
                                    </label>
                                @enderror
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="number" value="@yield('edit_sur_charge')" name="sur_charge" class="form-control">
                                    <label class="form-label">Sur charge</label>
                                </div>
                                @error('sur_charge')
                                    <label class="error" role="alert">
                                        {{ $message }}
                                    </label>
                                @enderror
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="number" value="@yield('edit_dealer_commission')" name="dealer_commission" class="form-control">
                                    <label class="form-label">Dealer commission</label>
                                </div>
                                @error('dealer_commission')
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
