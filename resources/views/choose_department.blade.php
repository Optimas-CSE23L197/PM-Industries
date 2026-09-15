<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="PM Industries ERP - Enterprise Resource Planning System for managing sales, purchases, inventory, production, accounts, customers, suppliers and business operations.">
    <meta name="keywords"
        content="PM Industries ERP, RCC Pipe ERP, Hume Pipe ERP, Manufacturing ERP, Production Management, Inventory Management, Sales Management, Purchase Management, Accounting ERP, Nagpur">

    <!-- Page Title & logo -->
    <title>Departments | PM Industries ERP</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/dist/img/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/dist/img/logo.png') }}">
    
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,600,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/main.css') }}">

    <style>
        .dept-card {
            transition: all .25s ease;
            border: 1px solid rgba(0, 0, 0, .08);
            border-radius: 12px;
            cursor: pointer;
            overflow: hidden;
            background: #fff;
        }

        .dept-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, .12) !important;
            border-color: #E67E22;
        }

        .dept-icon-wrapper {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.7rem;
            margin-bottom: 1rem;
        }

        .bg-inventory {
            background: #e8f1fb;
            color: #2563eb;
        }

        .bg-production {
            background: #fff0e3;
            color: #E67E22;
        }

        .bg-payroll {
            background: #eaf7ef;
            color: #198754;
        }

        .bg-crm {
            background: #f1eafe;
            color: #6f42c1;
        }

        .bg-dispatch {
            background: #e8f7f7;
            color: #0f8b8d;
        }

        .bg-security {
            background: #f1f3f5;
            color: #495057;
        }

        .welcome-header {
            background: linear-gradient(135deg, #17202A 0%, #263746 100%);
            color: #fff;
            border-radius: 12px;
            padding: 2rem 1.5rem;
            margin-bottom: 2rem;
        }

        .welcome-header .brand-line {
            width: 45px;
            height: 3px;
            background: #E67E22;
            border-radius: 5px;
            margin: 10px auto;
        }

        .module-link {
            color: #E67E22;
        }

        .dept-card:hover .module-link {
            color: #CA6F1E;
        }
    </style>
</head>

<body class="text-sm layout-fixed sidebar-collapse">
    <div class="wrapper">

        <!-- Loader -->
        <div id="loader"></div>

        <!-- Header -->
        <div id="header-container">
            @include('includes.header_common')
        </div>

        <!-- Page Content -->
        <div class="content-wrapper py-3">
            <section class="content">
                <div class="container">
                    <!-- Welcome Header -->
                    <div class="welcome-header text-center shadow-sm">
                        <i class="fas fa-info-circle float-right text-lg" onclick="location.href='{{Route("compList")}}';" data-toggle="tooltip" data-placement="top" data-html="true" title="Company Details" style="cursor:pointer;"></i>
                        <br>
                        <img src="{{ asset('assets/dist/img/logo.png') }}" alt="PM Industries Logo"
                            style="height:65px;width:65px;object-fit:contain;background:#fff;border-radius:10px;padding:5px;">
                        <h3 class="font-weight-bold mb-1 mt-3">
                            Welcome to PM Industries ERP
                        </h3>
                        <div class="brand-line"></div>
                        <p class="text-white-50 mb-0">
                            Select your department module to continue
                        </p>
                    </div>

                    <!-- Department Modules -->
                    <div class="row">

                        <!-- Raw Material Inventory -->
                        <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
                            <div class="card dept-card h-100 shadow-sm border-0"
                                onclick="location.href='{{ route('rawMaterialsInventory.dashboard') }}';">
                                <div class="card-body p-4 d-flex flex-column">
                                    <div class="dept-icon-wrapper bg-inventory">
                                        <i class="fas fa-boxes-stacked"></i>
                                    </div>
                                    <h4 class="font-weight-bold text-dark mb-1">
                                        Raw Material Inventory
                                    </h4>
                                    <p class="text-muted small mb-3">
                                        Manage raw materials, stock receipts, material issues,
                                        stock transfers, suppliers and inventory balances.
                                    </p>
                                    <div class="mt-auto d-flex align-items-center module-link font-weight-bold small">
                                        <span>Access Module</span>
                                        <i class="fas fa-right-long ml-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Production -->
                        <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
                            <div class="card dept-card h-100 shadow-sm border-0"
                                onclick="location.href='production/dashboard_production.html';">
                                <div class="card-body p-4 d-flex flex-column">
                                    <div class="dept-icon-wrapper bg-production">
                                        <i class="fas fa-cogs"></i>
                                    </div>
                                    <h4 class="font-weight-bold text-dark mb-1">
                                        Production
                                    </h4>
                                    <p class="text-muted small mb-3">
                                        Manage production planning, manufacturing processes,
                                        production entries, material consumption and finished goods.
                                    </p>
                                    <div class="mt-auto d-flex align-items-center module-link font-weight-bold small">
                                        <span>Access Module</span>
                                        <i class="fas fa-right-long ml-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payroll -->
                        <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
                            <div class="card dept-card h-100 shadow-sm border-0"
                                onclick="location.href='payroll/dashboard_payroll.html';">
                                <div class="card-body p-4 d-flex flex-column">
                                    <div class="dept-icon-wrapper bg-payroll">
                                        <i class="fas fa-id-card"></i>
                                    </div>
                                    <h4 class="font-weight-bold text-dark mb-1">
                                        Payroll System
                                    </h4>
                                    <p class="text-muted small mb-3">
                                        Manage employees, attendance, salary processing,
                                        payroll records, deductions and employee payments.
                                    </p>
                                    <div class="mt-auto d-flex align-items-center module-link font-weight-bold small">
                                        <span>Access Module</span>
                                        <i class="fas fa-right-long ml-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CRM -->
                        <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
                            <div class="card dept-card h-100 shadow-sm border-0"
                                onclick="location.href='crm/dashboard_crm.html';">
                                <div class="card-body p-4 d-flex flex-column">
                                    <div class="dept-icon-wrapper bg-crm">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <h4 class="font-weight-bold text-dark mb-1">
                                        CRM
                                    </h4>
                                    <p class="text-muted small mb-3">
                                        Manage customers, enquiries, leads, quotations,
                                        follow-ups, communications and customer relationships.
                                    </p>
                                    <div class="mt-auto d-flex align-items-center module-link font-weight-bold small">
                                        <span>Access Module</span>
                                        <i class="fas fa-right-long ml-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Dispatch & Logistics -->
                        <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
                            <div class="card dept-card h-100 shadow-sm border-0"
                                onclick="location.href='dispatch/dashboard_dispatch.html';">
                                <div class="card-body p-4 d-flex flex-column">
                                    <div class="dept-icon-wrapper bg-dispatch">
                                        <i class="fas fa-truck-fast"></i>
                                    </div>
                                    <h4 class="font-weight-bold text-dark mb-1">
                                        Dispatch &amp; Logistics
                                    </h4>
                                    <p class="text-muted small mb-3">
                                        Manage dispatch planning, delivery orders, vehicles,
                                        transport details, loading and shipment tracking.
                                    </p>
                                    <div class="mt-auto d-flex align-items-center module-link font-weight-bold small">
                                        <span>Access Module</span>
                                        <i class="fas fa-right-long ml-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- User & Security -->
                        <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
                            <div class="card dept-card h-100 shadow-sm border-0"
                                onclick="location.href='user/user.html';">
                                <div class="card-body p-4 d-flex flex-column">
                                    <div class="dept-icon-wrapper bg-security">
                                        <i class="fas fa-user-shield"></i>
                                    </div>
                                    <h4 class="font-weight-bold text-dark mb-1">
                                        User &amp; Security
                                    </h4>
                                    <p class="text-muted small mb-3">
                                        Manage users, roles, permissions, access controls,
                                        security settings and system authorization.
                                    </p>
                                    <div class="mt-auto d-flex align-items-center module-link font-weight-bold small">
                                        <span>Access Module</span>
                                        <i class="fas fa-right-long ml-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Footer -->
        <div id="footer-container"></div>

    </div>


    <!-- =====================================================
         JAVASCRIPT
    ====================================================== -->

    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>

    <!-- Loader -->
    <script src="{{ asset('assets/dist/js/loader.js') }}"></script>

    <!-- Footer -->
    <script src="{{ asset('assets/dist/js/footer.js') }}"></script>

    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

</body>

</html>