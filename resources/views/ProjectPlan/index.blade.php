@extends('layouts.app_main')

@section('content')
<section class="content">
    <div class="container-fluid">
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Project Plans
                        </h2>
                        <ul class="header-dropdown m-t--5">
                            <li>
                                <a href="{{ route('project-plans.create') }}" type="button" class="btn bg-indigo waves-effect">Add New</a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Project</th>
                                        <th>Installment Year</th>
                                        <th>total amount</th>
                                        <th>Sur-Charge</th>
                                        <th>Dealer Commission</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Project</th>
                                        <th>Installment Year</th>
                                        <th>total amount</th>
                                        <th>Sur-Charge</th>
                                        <th>Dealer Commission</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @forelse ($plans as $plan)

                                        <tr onclick="{{ 'window.location.href='.'"'.route('project-plans.show', $plan->id).'"' }}">
                                            <td>{{ $plan->id }}</td>
                                            <td>{{ $plan->project->title }}</td>
                                            <td>{{ $plan->installment_years }}</td>
                                            <td>{{ $plan->total_amount }}</td>
                                            <td>{{ $plan->sur_charge }}</td>
                                            <td>{{ $plan->dealer_commission }}</td>
                                            <td>{{ $plan->created_at }}</td>
                                            <td>
                                                <a class="btn padding-0 btn-circle" href="{{ route('project-plans.edit', $plan->id) }}">
                                                    <button type="button" class="btn bg-green btn-circle waves-effect waves-circle waves-float">
                                                        <i class="material-icons">mode_edit</i>
                                                    </button>
                                                </a>
                                                <form class="btn padding-0 btn-circle" action="{{ route('project-plans.destroy', $plan->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn bg-pink btn-circle waves-effect waves-circle waves-float">
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

<script type="application/javascript" src="{{ asset('plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}" defer></script>
<script type="application/javascript" src="{{ asset('plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }}" defer></script>
<script type="application/javascript" src="{{ asset('plugins/jquery-datatable/extensions/export/jszip.min.js') }}" defer></script>
<script type="application/javascript" src="{{ asset('plugins/jquery-datatable/extensions/export/pdfmake.min.js') }}" defer></script>
<script type="application/javascript" src="{{ asset('plugins/jquery-datatable/extensions/export/vfs_fonts.js') }}" defer></script>
<script type="application/javascript" src="{{ asset('plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }}" defer></script>
<script type="application/javascript" src="{{ asset('plugins/jquery-datatable/extensions/export/buttons.print.min.js') }}" defer></script>

<script type="application/javascript" src="{{ asset('js/pages/tables/jquery-datatable.js') }}" defer></script>
@endsection

