@extends('layouts.app_main')

@section('styles')
<style media="print" id = "table_style" type="text/css">
    body
    {
        font-family: Arial;
        font-size: 8pt;
    }
    .table
    {
        border: 1px solid #ccc;
        border-collapse: collapse;
    }
    .table th
    {
        background-color: #F7F7F7;
        color: #333;
        font-weight: bold;
    }
    .table th, .table td
    {
        padding: 5px;
        border: 1px solid #ccc;
    }
    .hidden-in-print, form, input {
        display: none;
    }
    .show-in-print {
        display: inline-block;
        width: 114px;
        margin: 0 0 7px;
        max-width: 100%;
        height: auto;
    }
    .text-right {
        text-align: right;
    }
    .text-center {
        text-align: center;
    }
</style>
    <style>
        td.details-control {
            background: url('{{ asset("images/details_open.png") }}') no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url('{{ asset("images/details_close.png") }}') no-repeat center center;
        }
        .shedule-table-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 10px;
            margin: 0 0 10px;
        }
        .shedule-table-head h5 {
            margin: 0
        }

        .show-in-print {
            display: none;
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
            <div class="shedule-table-head">
                <h5>Schedule</h5>
                <button type="button" class="btn btn-primary print-schedule-table" data-table="print-table-${d.id}">Print</button>
            </div>
        `;
        var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
        let totalAmount = 0;
        for(i = 0; i < d.schedules.length; i++) {
            totalAmount = d.schedules[i].amount_paid > 0 ? totalAmount + intVal(d.schedules[i].amount_paid) : totalAmount + 0;
            tablebodydata += `
                    <tr>
                        <td>${d.schedules[i].due_date}</td>
                        <td>${d.name}/${d.cnic}</td>
                        <td>${d.project}</td>
                        <td>
                            <span class="edit-row-text">${d.schedules[i].amount_paid > 0 ? d.schedules[i].amount_paid : ''}</span>
                            <form onsubmit="return submitForm(this)" method="POST" action="{{ url('schedule-submit/${d.schedules[i].id}') }}">
                                <input style="display:none" type="number" value="${d.schedules[i].amount_paid > 0 ? d.schedules[i].amount_paid : ''}" name="amount_paid">
                            </form>
                        </td>
                        <td>
                            <span class="remaining-row-text">${d.schedules[i].remaining_amount > 0 ? d.schedules[i].remaining_amount : ''}</span>
                        </td>
                        <td>${d.schedules[i].total_amount}</td>
                        <td>${d.schedules[i].installments > 0 ? d.schedules[i].installments : ''}</td>
                        <td class="hidden-in-print">
                            <span ${d.schedules[i].installments <= 0 ? 'style="display:none"': ''}>
                                <i class="hidden-in-print material-icons edit-shedule-row">mode_edit</i>
                                <i style="display:none;" class="hidden-in-print material-icons done-shedule-row">done</i>
                            <span>
                        </td>
                    </tr>
                `;
            }
            tablebodydata += `
                <tr>
                    <td colspan="4" class="text-right">Total Paid Amount: ${totalAmount}</td>
                    <td colspan="4"></td>
                </tr>
            `;
        // `d` is the original data object for the row
        return `${tableTitle}
        <div class="table-responsive" id="print-table-${d.id}">
            <img src="{{ asset('images/green-farm-house-logo.png') }}" class="show-in-print">
            <table class="table table-striped table-hover" id="print-table-${d.id}">
                <thead>
                    <tr>
                        <td style="font-weight: 500;">Date</td>
                        <td style="font-weight: 500;">Client</td>
                        <td style="font-weight: 500;">Project</td>
                        <td style="font-weight: 500;">Amount Paid</td>
                        <td style="font-weight: 500;">Remaining Amount</td>
                        <td style="font-weight: 500;">Total Amount</td>
                        <td style="font-weight: 500;">Installment</td>
                        <td style="font-weight: 500;" class="hidden-in-print"></td>
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
        $(document).on('click', '.print-schedule-table', function () {
            //Get the HTML of div
            let tableID = $(this).data('table');
            var printWindow = window.open('', '', '');
            printWindow.document.write('<html><head><title>Client Schedules</title>');

            //Print the Table CSS.
            var table_style = document.getElementById("table_style").innerHTML;
            printWindow.document.write('<style type = "text/css">');
            printWindow.document.write(table_style);
            printWindow.document.write('</style>');
            printWindow.document.write('</head>');

            //Print the DIV contents ie. the HTML Table.
            printWindow.document.write('<body>');
            printWindow.document.write(document.getElementById(tableID).outerHTML);
            printWindow.document.write('</body>');

            printWindow.document.write('</html>');
            printWindow.print();
            // printWindow.close();
        })

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

