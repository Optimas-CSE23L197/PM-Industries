<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="PM Industries ERP - Enterprise Resource Planning System for managing sales, purchases, inventory, production, accounts, customers, suppliers and business operations.">
    <meta name="keywords"
        content="PM Industries ERP, RCC Pipe ERP, Hume Pipe ERP, Manufacturing ERP, Production Management, Inventory Management, Sales Management, Purchase Management, Accounting ERP, Nagpur">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,600,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/main.css') }}">
    
    @stack('css')
</head>

<body class="text-sm layout-fixed sidebar-mini sidebar-collapse">
    <div class="wrapper">
        <div id="loader"></div>
        <div id="header-container">
            @include('includes.header')
        </div>
        
        <div id="sidebar-container">
            @if ( $dept === 'Raw Material Inventory' )
                @include('includes.sidebar_inventory')
                <script src="{{ asset('assets/dist/js/sidebar_inventory.js') }}"></script>
            @endif
        </div>

        <div class="content-wrapper">

             <!-- Page Header -->
            <div class="content-header p-0">
                <div class="container-fluid py-1 px-3 bg-dark">

                    @hasSection('page_titleH')

                        @hasSection('page_title_link')
                            <a href="@yield('page_title_link')"
                            class="border-bottom text-white"
                            style="cursor: pointer; font-weight: normal;">
                                @yield('page_titleH')
                            </a>
                        @else
                            <span class="text-white" style="font-weight: normal;">
                                @yield('page_titleH')
                            </span>
                        @endif

                    @endif

                    @hasSection('page_title')

                        @hasSection('page_titleH')
                            <i class="fa-solid fa-arrow-right-long mx-1 text-white"></i>
                        @endif

                        <span class="text-white" style="font-weight: normal; font-weight:bold;">
                            @yield('page_title')
                        </span>

                    @endif

                </div>
            </div>
            
            @yield('content')

        </div>

        <div id="footer-container"></div>
    </div>

    <script src="{{ asset('assets/dist/js/loader.js') }}"></script>
    <script src="{{ asset('assets/dist/js/footer.js') }}"></script>
    <script src="{{ asset('assets/dist/js/form_submit.js') }}"></script>
    <script src="{{ asset('assets/dist/js/current_date.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/dist/js/demo.js') }}"></script> --}}

    <!-- Select2 -->
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function () {
            $('.select2').select2()
        })
    </script>

    <!-- DataTables -->
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/function.js') }}"></script>

    <!-- Datatables -->
    <script>
        $(function () {
            $('#depttable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>

    @stack('js')

</body>

</html>