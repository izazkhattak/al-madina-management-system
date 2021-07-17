@extends('layouts.app_main')

@section('content')
<section>
    <div class="container-fluid">
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Dealer Installments
                        </h2>
                        <ul class="header-dropdown m-t--5">
                            <li>
                                <a href="{{ route('dealer-installments.create') }}" type="button" class="btn bg-indigo waves-effect">Add New</a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Project</th>
                                        <th>Dealer</th>
                                        <th>Payment date</th>
                                        <th>Amount paid</th>
                                        <th>Remaining amount</th>
                                        <th>Paymnent Method</th>
                                        <th>Cheque Draft No.</th>
                                        {{-- <th>Dealer commission</th> --}}
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Project</th>
                                        <th>Dealer</th>
                                        <th>Payment date</th>
                                        <th>Amount paid</th>
                                        <th>Remaining amount</th>
                                        <th>Paymnent Method</th>
                                        <th>Cheque Draft No.</th>
                                        {{-- <th>Dealer commission</th> --}}
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Basic Examples -->
    </div>
</section>

@endsection

@section('scripts')
{{-- <!-- Jquery DataTable Plugin Js --> --}}
<script type="application/javascript" src="{{ asset('plugins/jquery-datatable/jquery.dataTables.js') }}"></script>
<script type="application/javascript" src="{{ asset('plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
<script type="application/javascript">
    $('.js-basic-example').DataTable({
            dom: 'Bfrtip',
            responsive: true,
            "serverSide": true,
            "processing": true,
            "pageLength": 25,
            "ajax": {
                type: 'GET'
            },
            "columns": [
                { "data": "id", },
                { "data": "project"},
                { "data": "name", name: 'dealer.name'},
                { "data": "payment_date" },
                { "data": "amount_paid" },
                { "data": "remaining_amount" },
                { "data": "payment_method" },
                { "data": "cheque_draft_no" },
                // { "data": "dealer_commission" },
                { "data": "created_at" , visible:false },
                { "data": "actions", searchable: "true", "orderable": false }
            ]
        });
</script>
@endsection

