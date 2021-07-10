@extends('layouts.app_main')

@section('content')
<section class="content">
    <div class="container-fluid">
        <!-- Basic Validation -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>{{ isset($id) ? 'Update' : 'Add' }} Client</h2>
                        <ul class="header-dropdown">
                            <li class="dropdown">
                                <a href="javascript:void(0);" onclick="window.history.go(-1)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">arrow_back</i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <form action="{{ isset($id) ? route('clients.update', $id) : route('clients.store') }}" method="POST">
                            @csrf
                            @section("editMethod")
	                        @show
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" value="@yield('edit_name')" name="name" class="form-control">
                                    <label class="form-label">Name</label>
                                </div>
                                @error('name')
                                    <label class="error" role="alert">
                                        {{ $message }}
                                    </label>
                                @enderror
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" value="@yield('edit_phone')" name="phone" class="form-control">
                                    <label class="form-label">Phone</label>
                                </div>
                                @error('phone')
                                    <label class="error" role="alert">
                                        {{ $message }}
                                    </label>
                                @enderror
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" value="@yield('edit_cnic')" name="cnic" class="form-control">
                                    <label class="form-label">CNIC</label>
                                </div>
                                @error('cnic')
                                    <label class="error" role="alert">
                                        {{ $message }}
                                    </label>
                                @enderror
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select name="project_plan_id" class="form-control" id="project_plan_id">
                                        <option value="">Please select a plan</option>
                                        @forelse ($projectPlan as $plan)

                                        <option {{ isset($project_plan_id) && $project_plan_id == $plan->id ? 'selected' : '' }} value="{{ $plan->id }}">{{ $plan->total_amount }}</option>

                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                @error('project_plan_id')
                                    <label class="error" role="alert">
                                        {{ $message }}
                                    </label>
                                @enderror
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="number" value="@yield('edit_down_payment')" name="down_payment" class="form-control">
                                    <label class="form-label">Down payment</label>
                                </div>
                                @error('down_payment')
                                    <label class="error" role="alert">
                                        {{ $message }}
                                    </label>
                                @enderror
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="date" value="@yield('edit_due_date')" name="due_date" class="form-control">
                                    <label class="form-label">Down payment</label>
                                </div>
                                @error('due_date')
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
