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
</script>
@endsection

