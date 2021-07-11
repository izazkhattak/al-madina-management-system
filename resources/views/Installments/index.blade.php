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
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
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
                                    @forelse ($installments as $item)
                                    {{-- onclick="{{ 'window.location.href='.'"'.route('installments.show', $item->id).'"' }}" --}}
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->client->name }}</td>
                                            <td>{{ $item->payment_date }}</td>
                                            <td>{{ $item->plenty }}</td>
                                            <td>{{ number_format($item->amount_paid, 2) }}</td>
                                            <td>{{ number_format($item->remaining_amount, 2) }}</td>
                                            <td>{{ $item->client->projectPlan->dealer_commission }}%</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>
                                                <a class="btn padding-0 btn-circle" href="{{ route('installments.edit', $item->id) }}">
                                                    <button type="button" class="btn bg-green btn-circle waves-effect waves-circle waves-float">
                                                        <i class="material-icons">mode_edit</i>
                                                    </button>
                                                </a>
                                                <form class="btn padding-0 btn-circle" action="{{ route('installments.destroy', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn bg-pink btn-circle waves-effect waves-circle waves-float" data-type="form-confirm">
                                                        <i class="material-icons">delete_forever</i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                    @empty

                                    @endforelse
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
<script type="application/javascript" src="{{ asset('js/pages/tables/jquery-datatable.js') }}" defer></script>
@endsection

