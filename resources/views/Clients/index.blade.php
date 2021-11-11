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
        let i, tablebodydata = '', tableTitle = '';
        tableTitle = `
            <div>
                <h5 style="margin-top:0;">Schedule</h5>
            </div>
        `;
        for(i = 0; i < d.schedules.length; i++) {
            tablebodydata += `
                    <tr>
                        <td>${d.schedules[i].due_date}</td>
                        <td>${d.name}/${d.cnic}</td>
                        <td>${d.project}</td>
                        <td>
                            <form onsubmit="return submitForm(this)" method="POST" action="{{ url('schedule-submit/${d.schedules[i].id}') }}">
                                <span class="edit-row-text">${d.schedules[i].amount_paid}</span>
                                <input style="display:none" type="number" value="${d.schedules[i].amount_paid}" name="amount_paid">
                            </form>
                        </td>
                        <td>
                            <span class="remaining-row-text">${d.schedules[i].remaining_amount}</span>
                        </td>
                        <td>${d.schedules[i].total_amount}</td>
                        <td>${d.schedules[i].installments}</td>
                        <td>
                            <span ${d.schedules[i].installments <= 0 ? 'style="display:none"': ''}>
                                <i class="material-icons edit-shedule-row">mode_edit</i>
                                <i style="display:none;" class="material-icons done-shedule-row">done</i>
                            <span>
                        </td>
                    </tr>
                `;
            }
        // `d` is the original data object for the row
        return `${tableTitle}
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <td style="font-weight: 500;">Date</td>
                        <td style="font-weight: 500;">Client</td>
                        <td style="font-weight: 500;">Project</td>
                        <td style="font-weight: 500;">Amount Paid</td>
                        <td style="font-weight: 500;">Remaining Amount</td>
                        <td style="font-weight: 500;">Total Amount</td>
                        <td style="font-weight: 500;">Installment</td>
                        <td style="font-weight: 500;"></td>
                    </tr>
                </thead>
                <tbody>
                    ${tablebodydata}
                <tbody>
            </table>
        </div>`;
    }

    function submitForm(form) {
        let this_form = $(form);
        this_form.closest('tr').find('.done-shedule-row').trigger('click');
        return false;
    }

    $(document).ready(function() {
        $(document).on('click', '.edit-shedule-row', function() {
            let this_this = $(this);
            this_this.closest('tr').find('input').show();
            this_this.closest('tr').find('.edit-row-text').hide();
            this_this.closest('tr').find('.done-shedule-row').show();
            this_this.hide();
        });

        $(document).on('click', '.done-shedule-row', function() {
            let this_this = $(this);

            this_this.closest('tr').find('input').hide();
            this_this.closest('tr').find('.edit-row-text').show();
            this_this.closest('tr').find('.edit-shedule-row').show();
            this_this.hide();

            if (this_this.closest('tr').find('input').val() > 0) {
                $.ajax({
                    type: this_this.closest('tr').find('form').attr('method'),
                    url: this_this.closest('tr').find('form').attr('action'),
                    data: this_this.closest('tr').find('form').serialize(),
                    success: function(response) {
                        if (response?.success) {
                            this_this.closest('tr').find('.edit-row-text').text(response?.schedule?.amount_paid);
                            this_this.closest('tr').find('.remaining-row-text').text(response?.schedule?.remaining_amount);
                        } else {
                            alert(response?.message)
                        }

                    }
                });
            }

        });
    })
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

