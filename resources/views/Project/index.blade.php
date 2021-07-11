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
                            Projects
                        </h2>
                        <ul class="header-dropdown m-t--5">
                            <li>
                                <a href="{{ route('projects.create') }}" type="button" class="btn bg-indigo waves-effect">Add New</a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Created at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Created at</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @forelse ($projects as $project)
                                    {{-- onclick="{{ 'window.location.href='.'"'.route('projects.show', $project->id).'"' }}" --}}
                                        <tr>
                                            <td>{{ $project->id }}</td>
                                            <td>{{ $project->title }}</td>
                                            <td>{{ $project->description }}</td>
                                            <td>{{ $project->created_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <a class="btn padding-0 btn-circle" href="{{ route('projects.edit', $project->id) }}">
                                                    <button type="button" class="btn bg-green btn-circle waves-effect waves-circle waves-float">
                                                        <i class="material-icons">mode_edit</i>
                                                    </button>
                                                </a>
                                                <form class="btn padding-0 btn-circle" action="{{ route('projects.destroy', $project->id) }}" method="POST">
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

