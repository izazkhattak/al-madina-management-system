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
                                <select name="project_id" class="form-control" id="project_id" data-live-search="true">
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
                                <select name="project_plan_id" class="form-control" id="project_plan_id" data-live-search="true">
                                </select>
                            </div>
                        </div>
                        <div class="row hidden">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <select name="client_id" class="form-control" id="client_id" data-live-search="true">
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive p-t-10 table-reports-main hidden">
                            <table class="table table-striped table-hover table-bordered table-sm js-exportable dataTable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Due Date</th>
                                        <th>Paid Received</th>
                                        <th>Date Received</th>
                                        <th>Remaining Amount</th>
                                        <th>Total Amount</th>
                                        <th>Surcharge</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
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
                url: "{{ route('client-reports.get-project-plans') }}",
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
                url: "{{ route('client-reports.get-clients') }}",
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
            let project_id = $('#project_id').val();
            let project_plan_id = $('#project_plan_id').val();
            let client_id = $("#client_id").val();
            $('.table-reports-main table').DataTable().ajax.url("{{ route('client-reports.get-reports') }}?project_id=" + project_id + "&client_id=" + client_id).load();
            $('.table-reports-main table').css('width', '100%');
            $('.table-reports-main').removeClass('hidden');
        });

        //Exportable table
        $('.js-exportable').DataTable({
            dom: 'Bfrtip',
            responsive: true,
            buttons: [
            { extend: 'csv', footer: true },
            { extend: 'pdf', footer: true },
            { extend: 'excel', footer: true },
            { extend: 'print', footer: true,
            customize: function ( win ) {
                    $(win.document.body)
                        .css( 'font-size', '10pt' )
                        .prepend(
                            '<img src="{{ asset("images/green-farm-house-logo.png") }}" style="position:fixed; top:0; right:0; width:12%" />'
                        );
                }
                 }
            ],
            "serverSide": true,
            "processing": true,
            "pageLength": 25,
            "ajax": {
                type: 'GET',
                url: "{{ route('client-reports.get-reports') }}"
            },
            "columns": [
                { "data": "name" },
                { "data": "due_date" },
                { "data": "paid" },
                { "data": "paid_on" },
                { "data": "out_stand" },
                { "data": "due_amount" },
                { "data": "sur_charge" }
            ],
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                //******************************////
                //******Total Paid Calculation****************///
                //******************************////
                let pageTotal = api
                    .column( 2, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                // Update footer
                $( api.column( 2 ).footer() ).html(
                    'Total Paid: ' + pageTotal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                );
                //******************************////
                //******Total Remaning Calculation****************///
                //******************************////
                // let pageTotalRemaining = api
                //     .column( 4, { page: 'current'} )
                //     .data()
                //     .reduce( function (a, b) {
                //         return intVal(a) + intVal(b);
                //     }, 0 );

                // Update footer
                // $( api.column( 4 ).footer() ).html(
                //     'Total Remaining: ' + pageTotalRemaining.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                // );

                //******************************////
                //******Sur Charge Calculation****************///
                //******************************////
                let pageTotalSurchange = api
                    .column( 6, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                // Update footer
                $( api.column( 6 ).footer() ).html(
                    'Sur Charge: ' + pageTotalSurchange.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                );
            }
        });
    });
</script>

@endsection

