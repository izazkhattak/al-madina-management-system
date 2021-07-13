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
                            Installments
                        </h2>
                        <ul class="header-dropdown m-t--5">
                            <li>
                                <a href="{{ route('installments.create') }}" type="button" class="btn bg-indigo waves-effect">Add New</a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Client</th>
                                        <th>Payment date</th>
                                        <th>Plenty</th>
                                        <th>Amount paid</th>
                                        <th>Remaining amount</th>
                                        <th>Dealer commission</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Client</th>
                                        <th>Payment date</th>
                                        <th>Plenty</th>
                                        <th>Amount paid</th>
                                        <th>Remaining amount</th>
                                        <th>Dealer commission</th>
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
                { "data": "id" },
                { "data": "name" },
                { "data": "payment_date" },
                { "data": "plenty" },
                { "data": "amount_paid" },
                { "data": "remaining_amount" },
                { "data": "dealer_commission" },
                { "data": "created_at" },
                { "data": "actions", searchable: "true", "orderable": false }
            ]
        });
</script>
@endsection

