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
                    <a href="{{ Route('crm.dashboard') }}" class="nav-link">
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
                            <a href="{{ Route('enquiry') }}" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Enquiry</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ Route('enquiryFollowup') }}" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Enquiry Followup</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ Route('quotation') }}" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Quotation</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ Route('quotationFollowup') }}" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Quotation Followup</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ Route('salesOrder') }}" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Sales Order</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ Route('sales') }}" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Sales</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ Route('salesReturn') }}" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Sales Return</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ Route('receipt') }}" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Receipt</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ Route('receiptFollowup') }}" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Receipt Followup</p>
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
                            <a href="{{ Route('customer') }}" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Customer</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ Route('leadSource') }}" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Lead Source</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ Route('termsConditions') }}" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Terms & Conditions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ Route('priceList') }}" class="nav-link">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Price List</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>