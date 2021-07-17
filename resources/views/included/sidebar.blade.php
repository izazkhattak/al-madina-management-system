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
                    <a href="{{ route('projects.index') }}">
                        <i class="material-icons">settings_input_composite</i>
                        <span>Project</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('project-plans.index') }}">
                        <i class="material-icons">wb_incandescent</i>
                        <span>Project Plan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('clients.index') }}">
                        <i class="material-icons">account_circle</i>
                        <span>Clients</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('clients.index') }}">
                        <i class="material-icons">account_circle</i>
                        <span>Client Installments</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('clients.index') }}">
                        <i class="material-icons">account_circle</i>
                        <span>Client Reports</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('installments.index') }}">
                        <i class="material-icons">gavel</i>
                        <span>Dealers</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('installments.index') }}">
                        <i class="material-icons">gavel</i>
                        <span>Dealer Installments</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('reports.index') }}">
                        <i class="material-icons">report</i>
                        <span>Dealer Reports</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- #Menu -->
    </aside>
    <!-- #END# Left Sidebar -->
</section>
