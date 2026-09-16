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
                <li class="nav-item">
                    <a href="{{ Route('production.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-indian-rupee"></i>
                        <p>
                            Transactions
                            <i class="right fas fa-caret-down"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="weekly_production_planning.html" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Weekly Production Planning</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="daily_production.html" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Daily Production Entry</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="machine_maintenance.html" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Machine Wise Maintenance</p>
                            </a>
                        </li>
                    </ul>
                </li>
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
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Masters
                            <i class="right fas fa-caret-down"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ Route('finishedItemType') }}" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Finished Item Type</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ Route('finishedItem') }}" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Finished Item</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ Route('itemSize') }}" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Item Size</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="bom.html" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Bill of Materials (BOM)</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ Route('machine') }}" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Machine</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ Route('maintenanceType') }}" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Maintenance Type</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>