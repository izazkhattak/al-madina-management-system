@extends('layouts.app_main')

@section('content')
<section>
    <div class="container-fluid">
        <!-- Basic Validation -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>{{ isset($id) ? 'Update' : 'Add' }} Dealer Installment</h2>
                        <ul class="header-dropdown">
                            <li class="dropdown">
                                <a href="javascript:void(0);" onclick="window.history.go(-1)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">arrow_back</i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <form action="{{ isset($id) ? route('dealer-installments.update', $id) : route('dealer-installments.store') }}" method="POST">
                            @csrf
                            @section("editMethod")
	                        @show

                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select name="dealer_id" class="form-control" id="dealer_id" data-live-search="true">
                                        <option value="">Please select a dealer</option>
                                        @forelse ($dealers as $dealer)

                                        <option {{ (isset($dealer_id) && $dealer_id == $dealer->id) || old('dealer_id') == $dealer->id ? 'selected' : '' }} value="{{ $dealer->id }}">{{ $dealer->name.' / '.$dealer->cnic.' / '. $dealer->projectPlan->installment_years.' Years / '.$dealer->projectPlan->project->title}}</option>

                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                @error('dealer_id')
                                    <label class="error" role="alert">
                                        {{ $message }}
                                    </label>
                                @enderror
                            </div>

                            <div class="form-group form-float">
                                <div class="form-line" id="bs_datepicker_container">
                                    <input type="text" readonly value="{{ old('payment_date', isset($edit_payment_date) ? $edit_payment_date : '') }}" name="payment_date" class="form-control">
                                    <label class="form-label">Payment date</label>
                                </div>
                                @error('payment_date')
                                    <label class="error" role="alert">
                                        {{ $message }}
                                    </label>
                                @enderror
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" value="{{ old('amount_paid', isset($edit_amount_paid) ? number_format($edit_amount_paid) : '') }}" name="amount_paid" class="money-format-input form-control">
                                    <label class="form-label">Amount paid</label>
                                </div>
                                @error('amount_paid')
                                    <label class="error" role="alert">
                                        {{ $message }}
                                    </label>
                                @enderror
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select name="payment_method" class="form-control" id="payment_method" data-live-search="true">
                                        <option value="">Please select payment method</option>
                                        @forelse (config('al_madina.cheque_draft_options') as $keyName => $item)

                                        <option {{ (isset($edit_payment_method) && $edit_payment_method == $keyName) || old('payment_method') == $keyName ? 'selected' : '' }} value="{{ $keyName }}">{{ $item }}</option>

                                        @empty

                                        @endforelse
                                    </select>
                                </div>
                                @error('payment_method')
                                    <label class="error" role="alert">
                                        {{ $message }}
                                    </label>
                                @enderror
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" value="{{ old('cheque_draft_no', isset($edit_cheque_draft_no) ? $edit_cheque_draft_no : '') }}" name="cheque_draft_no" class="form-control">
                                    <label class="form-label">Cheque Draft No.</label>
                                </div>
                                @error('cheque_draft_no')
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

    <script defer>
        //Bootstrap datepicker plugin
        $('#bs_datepicker_container input').datepicker({
            autoclose: true,
            container: '#bs_datepicker_container',
            format: 'yyyy-mm-dd'
        });
    </script>
@endsection
