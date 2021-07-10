<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <!-- Menu -->
        <div class="menu">
            <ul class="list pt-3">
                {{-- <li class="header">MAIN NAVIGATION</li> --}}
                <li>
                    <a href="{{ url('home') }}">
                        <i class="material-icons">home</i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('projects') }}">
                        <i class="material-icons">settings_input_composite</i>
                        <span>Project</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('project-plans') }}">
                        <i class="material-icons">wb_incandescent</i>
                        <span>Project Plan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('clients') }}">
                        <i class="material-icons">account_circle</i>
                        <span>Clients</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- #Menu -->
        <!-- Footer -->
        <div class="legal">
            <div class="copyright">
                &copy; 2021 - {{ date('Y') }} <a href="javascript:void(0);">{{ config('app.name') }}</a>.
            </div>
            <div class="version">
                <b>Version: </b> 1.1
            </div>
        </div>
        <!-- #Footer -->
    </aside>
    <!-- #END# Left Sidebar -->
</section>
