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
                            All Clients Reports
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
                        <div class="block-header summery-header-block hidden">
                            <h2>Summary Infos</h2>
                        </div>

                        <div class="row clearfix summery-boxes hidden">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="info-box bg-pink hover-expand-effect">
                                    <div class="icon">
                                        <i class="material-icons">playlist_add_check</i>
                                    </div>
                                    <div class="content">
                                        <div class="text">TOTAL AMOUNT</div>
                                        <div class="number total-amount">125</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="info-box bg-cyan hover-expand-effect">
                                    <div class="icon">
                                        <i class="material-icons">help</i>
                                    </div>
                                    <div class="content">
                                        <div class="text">TOTAL INSTALLMENTS</div>
                                        <div class="number total-paid">257</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="info-box bg-light-green hover-expand-effect">
                                    <div class="icon">
                                        <i class="material-icons">forum</i>
                                    </div>
                                    <div class="content">
                                        <div class="text">TOTAL BALANCE</div>
                                        <div class="number total-balance">243</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive summery-table hidden">
                            <table class="table table-striped table-hover js-exportable dataTable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Total Amount</th>
                                        <th>Total Installments</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
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

<script defer>
    $(document).ready(() => {
        $(document).on('change', '#project_id', function() {
            let project_id = $('#project_id').val();
            $('.summery-table table').DataTable().ajax.url("{{ route('all-client-reports.reports') }}?project_id=" + project_id).load(function(response) {
                console.log('nice', response);
                $('.summery-table, .summery-header-block, .summery-boxes').removeClass('hidden');
                $('.summery-boxes .total-amount').html(parseInt(response.boxes_data.total_amount).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('.summery-boxes .total-paid').html(parseInt(response.boxes_data.total_paid).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('.summery-boxes .total-balance').html((parseInt(response.boxes_data.total_amount) - parseInt(response.boxes_data.total_paid)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            });
            $('.summery-table table').css('width', '100%');
        });

        //Exportable table
        $('.js-exportable').DataTable({
            dom: 'Bfrtip',
            responsive: true,
            "serverSide": true,
            "processing": true,
            "pageLength": 25,
            "ajax": {
                type: 'GET',
                url: "{{ route('all-client-reports.reports') }}"
            },
            "columns": [
                { "data": "name" },
                { "data": "total_amount" },
                { "data": "total_paid" }
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
                //******************************///
                let pageTotal = api
                    .column( 1, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                // Update footer
                $( api.column( 1 ).footer() ).html(
                    'Total Amount: ' + pageTotal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                );

                //******************************////
                //******Total Remaining Calculation****************///
                //******************************///
                let pageTotalRemaining = api
                    .column( 2, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                $( api.column( 2 ).footer() ).html(
                    'Total Installments: ' + pageTotalRemaining.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                );
            }
        });
    });
</script>

@endsection

