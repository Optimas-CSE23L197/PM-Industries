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
                    <a href="{{ route('rawMaterialsInventory.dashboard') }}" class="nav-link">
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
                            <a href="{{ route('rawMaterialsInventory.purchaseOrderList') }}" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Purchase Order</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('rawMaterialsInventory.purchaseList') }}" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Purchase</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('rawMaterialsInventory.purchaseRtnList') }}" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Purchase Return</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('rawMaterialsInventory.issueToDeptList') }}" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Issue to Departments</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('rawMaterialsInventory.rtnFrmDeptList') }}" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Return from Departments</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('rawMaterialsInventory.stkAdjList') }}" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Stock Adjustment</p>
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
                            <a href="{{ route('rawMaterialsInventory.rawMaterialTypeList') }}" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Raw Item Type</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('rawMaterialsInventory.rawItemList') }}" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Raw Item</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('rawMaterialsInventory.storeList') }}" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Store</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('rawMaterialsInventory.supplierList') }}" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Supplier</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('rawMaterialsInventory.departmentList') }}" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Department</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('rawMaterialsInventory.opStkList') }}" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Opening Stock</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>