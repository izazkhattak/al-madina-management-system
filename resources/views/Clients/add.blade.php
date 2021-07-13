@extends('layouts.app_main')

@section('content')
<section>
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
                                    <input type="text" value="{{ old('name', isset($edit_name) ? $edit_name : '') }}" name="name" class="form-control">
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
                                    <input type="text" value="{{ old('phone', isset($edit_phone) ? $edit_phone : '') }}" name="phone" class="phone-number form-control">
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
                                    <input type="text" value="{{ old('cnic', isset($edit_cnic) ? $edit_cnic : '') }}" name="cnic" class="cnic-format form-control">
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
                                    <select {{ isset($isEditableProjectPlan) && $isEditableProjectPlan == 'no' ? 'disabled' : '' }} name="project_plan_id" class="form-control" id="project_plan_id" data-live-search="true">
                                        <option value="">Please select a plan</option>
                                        @forelse ($projectPlan as $plan)

                                        <option {{ isset($project_plan_id) && $project_plan_id == $plan->id ? 'selected' : '' }} value="{{ $plan->id }}">{{ $plan->project->title . ' - ' . number_format($plan->total_amount, 2) }}</option>

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
                                    <input type="text" value="{{ old('down_payment', isset($edit_down_payment) ? number_format($edit_down_payment, 2) : '') }}" name="down_payment" class="money-format-input form-control">
                                    <label class="form-label">Down payment</label>
                                </div>
                                @error('down_payment')
                                    <label class="error" role="alert">
                                        {{ $message }}
                                    </label>
                                @enderror
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line" id="bs_datepicker_container">
                                    <input type="text" readonly value="{{ old('due_date', isset($edit_due_date) ? $edit_due_date : '') }}" name="due_date" class="form-control">
                                    <label class="form-label">Due Date</label>
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


@section('scripts')
    <!-- Bootstrap Datepicker Plugin Js -->
    <script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>

    <!-- Jquery Spinner Plugin Js -->
    <script src="{{ asset('plugins/jquery-spinner/js/jquery.spinner.js') }}"></script>

    <!-- Input Mask Plugin Js -->
    <script src="{{ asset('plugins/jquery-inputmask/jquery.inputmask.bundle.js') }}"></script>

    <script defer>
        var $demoMaskedInput = $('body');
        //Dollar Money
        $demoMaskedInput.find('.cnic-format').inputmask('99999-9999999-9', { placeholder: '_____-_______-_' });
        //Phone Number
        $demoMaskedInput.find('.phone-number').inputmask('+99 (999) 999-99-99', { placeholder: '+__ (___) ___-__-__' });
        //Bootstrap datepicker plugin
        $('#bs_datepicker_container input').datepicker({
            autoclose: true,
            container: '#bs_datepicker_container',
            format: 'yyyy-mm-dd'
        });
    </script>
@endsection
