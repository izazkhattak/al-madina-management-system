@extends('layouts.app_main')

@section('styles')

    <style>
        td.details-control {
            background: url('{{ asset("images/details_open.png") }}') no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url('{{ asset("images/details_close.png") }}') no-repeat center center;
        }
    </style>

@endsection

@section('content')
<section>
    <div class="container-fluid">
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Clients
                        </h2>
                        <ul class="header-dropdown m-t--5">
                            <li>
                                <a href="{{ route('csv.download-unpaid-clients') }}" class="btn bg-brown waves-effect">Download Unpaid Clients</a>
                                <a href="{{ route('csv.download-clients') }}" class="btn bg-teal waves-effect">Download Clients</a>
                            </li>
                            <li>
                                <a href="{{ route('clients.create') }}" class="btn bg-indigo waves-effect">Add New</a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>CNIC</th>
                                        <th>Project</th>
                                        <th>Project plan</th>
                                        <th>Down payment</th>
                                        <th>Due date</th>
                                        <th>Monthly installments</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>CNIC</th>
                                        <th>Project</th>
                                        <th>Project plan</th>
                                        <th>Down payment</th>
                                        <th>Due date</th>
                                        <th>Monthly installments</th>
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
    /* Formatting function for row details - modify as you need */
    function format ( d ) {
        // `d` is the original data object for the row
        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
            '<tr>'+
                '<td colspan="2" class="text-center" style="font-weight: 600;">Schedules</td>'+
            '</tr>'+
            '<tr>'+
                '<td>Full name:</td>'+
                '<td>'+d.name+'</td>'+
            '</tr>'+
            '<tr>'+
                '<td>Phone:</td>'+
                '<td>'+d.phone+'</td>'+
            '</tr>'+
        '</table>';
    }

    var table = $('.js-basic-example').DataTable({
            dom: 'Bfrtip',
            responsive: true,
            "serverSide": true,
            "processing": true,
            "pageLength": 25,
            "ajax": {
                type: 'GET'
            },
            "columns": [
                {
                    "className": 'details-control',
                    "orderable": false,
                    "data": null,
                    "defaultContent": ''
                },
                { "data": "id", visible:false },
                { "data": "name" },
                { "data": "phone" },
                { "data": "cnic" },
                { "data": "project" },
                { "data": "total_amount" },
                { "data": "down_payment"},
                { "data": "due_date"},
                { "data": "monthly_installments" },
                { "data": "created_at", visible:false  },
                { "data": "actions", searchable: "true", "orderable": false }
            ]
        });
        $('.js-basic-example tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );

        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );
</script>
@endsection

