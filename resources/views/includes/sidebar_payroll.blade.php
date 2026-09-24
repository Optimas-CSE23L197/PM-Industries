<aside class="main-sidebar sidebar-light-dark elevation-4">
    <!-- Brand Logo -->
    <span class="brand-link bg-light py-2">
        <img src="{{ asset('assets/dist/img/logo.png') }}" class="brand-image ml-2">
        <span class="brand-text font-weight-bold">
            PM Industries
        </span>
    </span>
    <!-- Sidebar Menu -->
    <div class="sidebar text-sm">
        <nav class="mt-2">
            <ul class="nav nav-flat nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                {{-- ============== DASHBOARD ============== --}}
                <li class="nav-item">
                    <a href="{{ route('payroll.dashboard') }}" class="nav-link {{ request()->routeIs('payroll.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- ============== TRANSACTIONS ============== --}}
                <li class="nav-item {{ request()->routeIs('payroll.workerAdvance*') || request()->routeIs('payroll.contractorBill*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('payroll.workerAdvance*') || request()->routeIs('payroll.contractorBill*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-indian-rupee"></i>
                        <p>
                            Transactions
                            <i class="right fas fa-caret-down"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('payroll.workerAdvance') }}" class="nav-link {{ request()->routeIs('payroll.workerAdvance') ? 'active' : '' }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Advance to Worker</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('payroll.contractorBill') }}" class="nav-link {{ request()->routeIs('payroll.contractorBill') ? 'active' : '' }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Contractor Bill</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- ============== REPORTS ============== --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file-lines"></i>
                        <p>
                            Reports
                            <i class="right fas fa-caret-down"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Something</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- ============== MASTERS ============== --}}
                <li class="nav-item {{ request()->routeIs('payroll.contractor*') || request()->routeIs('payroll.worker') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('payroll.contractor*') || request()->routeIs('payroll.worker') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Masters
                            <i class="right fas fa-caret-down"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('payroll.contractor') }}" class="nav-link {{ request()->routeIs('payroll.contractor') ? 'active' : '' }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Contractor</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('payroll.worker') }}" class="nav-link {{ request()->routeIs('payroll.worker') ? 'active' : '' }}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Worker</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>
</aside>