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
                            Reports
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <select name="project_id" class="form-control" id="project_id">
                                    <option value="">Please select a project</option>
                                    @forelse ($projects as $project)

                                    <option {{ isset($projectID) && $projectID == $project->id ? 'selected' : '' }} value="{{ $project->id }}">{{ $project->title }}</option>

                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="row hidden">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <select name="project_plan_id" class="form-control" id="project_plan_id">
                                </select>
                            </div>
                        </div>
                        <div class="row hidden">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <select name="client_id" class="form-control" id="client_id">
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive p-t-10 table-reports-main hidden">
                            <table class="table table-bordered table-striped table-hover js-exportable dataTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Due Amount</th>
                                        <th>Due Date</th>
                                        <th>Paid</th>
                                        <th>Paid On</th>
                                        <th>DS/DD No.</th>
                                        <th>Out/Stand</th>
                                        <th>Surcharge</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Due Amount</th>
                                        <th>Due Date</th>
                                        <th>Paid</th>
                                        <th>Paid On</th>
                                        <th>DS/DD No.</th>
                                        <th>Out/Stand</th>
                                        <th>Surcharge</th>
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
<script type="application/javascript" src="{{ asset('plugins/jquery-datatable/jquery.dataTables.js') }}" defer></script>
<script type="application/javascript" src="{{ asset('plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}" defer></script>

<script type="application/javascript" src="{{ asset('plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}" defer></script>
<script type="application/javascript" src="{{ asset('plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }}" defer></script>
<script type="application/javascript" src="{{ asset('plugins/jquery-datatable/extensions/export/jszip.min.js') }}" defer></script>
<script type="application/javascript" src="{{ asset('plugins/jquery-datatable/extensions/export/pdfmake.min.js') }}" defer></script>
<script type="application/javascript" src="{{ asset('plugins/jquery-datatable/extensions/export/vfs_fonts.js') }}" defer></script>
<script type="application/javascript" src="{{ asset('plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }}" defer></script>
<script type="application/javascript" src="{{ asset('plugins/jquery-datatable/extensions/export/buttons.print.min.js') }}" defer></script>

<script defer>
    $(document).ready(() => {
        $(document).on('change', '#project_id', function() {
            $.ajax({
                type: 'GET',
                url: "{{ route('reports.get-project-plans') }}",
                data: {
                    project_id: $(this).val()
                },
                success: function(response) {
                    if (response.success) {
                        $('#project_plan_id').closest('.row').removeClass('hidden');
                        $('#project_plan_id').html(response.html);
                        $('#project_plan_id').selectpicker('refresh');
                    }
                },
                error: function(error) {
                    alert('Something went wrong, please try again!')
                }
            })
        });

        $(document).on('change', '#project_plan_id', function() {
            $.ajax({
                type: 'GET',
                url: "{{ route('reports.get-clients') }}",
                data: {
                    project_id: $('#project_id').val(),
                    project_plan_id: $(this).val()
                },
                success: function(response) {
                    if (response.success) {
                        $('#client_id').closest('.row').removeClass('hidden');
                        $('#client_id').html(response.html);
                        $('#client_id').selectpicker('refresh');
                    }
                },
                error: function(error) {
                    alert('Something went wrong, please try again!')
                }
            })
        });

        $(document).on('change', '#client_id', function() {
            $('.table-reports-main table').DataTable().ajax.reload();
            $('.table-reports-main table').css('width', '100%');
            $('.table-reports-main').removeClass('hidden');
        });

        //Exportable table
        $('.js-exportable').DataTable({
            dom: 'Bfrtip',
            responsive: true,
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "serverSide": true,
            "processing": true,
            "ajax": {
                type: 'GET',
                url: "{{ route('reports.get-reports') }}",
                data: function() {
                    return {
                        project_id: $('#project_id').val(),
                        project_plan_id: $('#project_plan_id').val(),
                        client_id: $("#client_id").val()
                    }
                }
            },
            "columns": [
                { "data": "id" },
                { "data": "due_amount" },
                { "data": "due_date" },
                { "data": "paid" },
                { "data": "paid_on" },
                { "data": "ds_dd_no" },
                { "data": "out_stand" },
                { "data": "sur_charge" }
            ]
        });
    });
</script>

@endsection

