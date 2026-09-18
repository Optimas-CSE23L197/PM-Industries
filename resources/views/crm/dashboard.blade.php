@extends('layout.app', ['dept' => 'CRM'])
@section('page_title', 'Dashboard - CRM')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">

            <!-- CRM Summary -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>42</h3>
                            <p>Open Enquiries</p>
                        </div>
                        <div class="icon"><i class="fa-solid fa-user-plus"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>28</h3>
                            <p>Open Quotations</p>
                        </div>
                        <div class="icon"><i class="fa-solid fa-file-invoice"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>16</h3>
                            <p>Pending Sales Orders</p>
                        </div>
                        <div class="icon"><i class="fa-solid fa-cart-shopping"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>₹18.45L</h3>
                            <p>Customer Outstanding</p>
                        </div>
                        <div class="icon"><i class="fa-solid fa-file-invoice-dollar"></i></div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card dashboard-card">
                <div class="card-header bg-primary">
                    <span class="font-weight-bold">Quick Actions</span>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-lg-2 col-md-4 col-6 mb-2">
                            <a href="{{ route('customer') }}" class="btn btn-primary btn-block quick-btn">
                                <i class="fa-solid fa-users"></i> Customer
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-2">
                            <a href="#" class="btn btn-info btn-block quick-btn">
                                <i class="fa-solid fa-user-plus"></i> Enquiry
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-2">
                            <a href="#" class="btn btn-warning btn-block quick-btn">
                                <i class="fa-solid fa-file-invoice"></i> Quotation
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-2">
                            <a href="#" class="btn btn-success btn-block quick-btn">
                                <i class="fa-solid fa-cart-shopping"></i> Sales Order
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-2">
                            <a href="#" class="btn btn-danger btn-block quick-btn">
                                <i class="fa-solid fa-receipt"></i> Invoice
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-2">
                            <a href="#" class="btn btn-dark btn-block quick-btn">
                                <i class="fa-solid fa-money-bill-transfer"></i> Receipt
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enquiries + Follow-ups -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card dashboard-card">
                        <div class="card-header bg-primary">
                            <span class="font-weight-bold">Recent Enquiries</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Enquiry No.</th>
                                            <th>Customer</th>
                                            <th>Item</th>
                                            <th>Lead Source</th>
                                            <th>Status</th>
                                            <th>Follow-up</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>09-09-2026</td>
                                            <td>ENQ-1052</td>
                                            <td>ABC Infra Pvt. Ltd.</td>
                                            <td>RCC Pipe 600mm</td>
                                            <td>Website</td>
                                            <td><span class="badge badge-primary">Open</span></td>
                                            <td><span class="badge badge-warning">Today</span></td>
                                        </tr>
                                        <tr>
                                            <td>08-09-2026</td>
                                            <td>ENQ-1051</td>
                                            <td>Shree Construction</td>
                                            <td>RCC Pipe 900mm</td>
                                            <td>Reference</td>
                                            <td><span class="badge badge-info">Quotation</span></td>
                                            <td><span class="badge badge-success">Done</span></td>
                                        </tr>
                                        <tr>
                                            <td>08-09-2026</td>
                                            <td>ENQ-1050</td>
                                            <td>Metro Developers</td>
                                            <td>RCC Pipe 1200mm</td>
                                            <td>Sales Team</td>
                                            <td><span class="badge badge-primary">Open</span></td>
                                            <td><span class="badge badge-danger">Overdue</span></td>
                                        </tr>
                                        <tr>
                                            <td>07-09-2026</td>
                                            <td>ENQ-1049</td>
                                            <td>Om Sai Infra</td>
                                            <td>RCC Manhole</td>
                                            <td>Phone</td>
                                            <td><span class="badge badge-secondary">Lost</span></td>
                                            <td><span class="badge badge-secondary">Closed</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card dashboard-card">
                        <div class="card-header bg-warning">
                            <span class="font-weight-bold">Follow-ups Due</span>
                        </div>
                        <div class="card-body p-2">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-2">
                                    <div class="d-flex justify-content-between">
                                        <strong>ABC Infra Pvt. Ltd.</strong>
                                        <span class="badge badge-danger">Today</span>
                                    </div>
                                    <small class="text-muted">Enquiry ENQ-1052</small>
                                </li>
                                <li class="list-group-item px-2">
                                    <div class="d-flex justify-content-between">
                                        <strong>Metro Developers</strong>
                                        <span class="badge badge-danger">Overdue</span>
                                    </div>
                                    <small class="text-muted">Enquiry ENQ-1050</small>
                                </li>
                                <li class="list-group-item px-2">
                                    <div class="d-flex justify-content-between">
                                        <strong>Shree Construction</strong>
                                        <span class="badge badge-warning">Today</span>
                                    </div>
                                    <small class="text-muted">Quotation QT-2084</small>
                                </li>
                                <li class="list-group-item px-2">
                                    <div class="d-flex justify-content-between">
                                        <strong>National Infra</strong>
                                        <span class="badge badge-info">Tomorrow</span>
                                    </div>
                                    <small class="text-muted">Quotation QT-2081</small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quotations + Sales Orders -->
            <div class="row">
                <div class="col-lg-7">
                    <div class="card dashboard-card">
                        <div class="card-header bg-info">
                            <span class="font-weight-bold">Recent Quotations</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Quotation No.</th>
                                            <th>Customer</th>
                                            <th class="text-right">Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>09-09-2026</td>
                                            <td>QT-2085</td>
                                            <td>ABC Infra Pvt. Ltd.</td>
                                            <td class="text-right">₹4,85,000</td>
                                            <td><span class="badge badge-warning">Pending</span></td>
                                        </tr>
                                        <tr>
                                            <td>08-09-2026</td>
                                            <td>QT-2084</td>
                                            <td>Shree Construction</td>
                                            <td class="text-right">₹3,42,500</td>
                                            <td><span class="badge badge-info">Follow-up</span></td>
                                        </tr>
                                        <tr>
                                            <td>07-09-2026</td>
                                            <td>QT-2083</td>
                                            <td>National Infra</td>
                                            <td class="text-right">₹6,18,000</td>
                                            <td><span class="badge badge-success">Accepted</span></td>
                                        </tr>
                                        <tr>
                                            <td>06-09-2026</td>
                                            <td>QT-2082</td>
                                            <td>Metro Developers</td>
                                            <td class="text-right">₹2,76,500</td>
                                            <td><span class="badge badge-danger">Lost</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card dashboard-card">
                        <div class="card-header bg-success">
                            <span class="font-weight-bold">Pending Sales Orders</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Order No.</th>
                                            <th>Customer</th>
                                            <th class="text-right">Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>SO-3018</td>
                                            <td>ABC Infra</td>
                                            <td class="text-right">₹4.85L</td>
                                            <td><span class="badge badge-warning">Pending</span></td>
                                        </tr>
                                        <tr>
                                            <td>SO-3017</td>
                                            <td>National Infra</td>
                                            <td class="text-right">₹6.18L</td>
                                            <td><span class="badge badge-info">Production</span></td>
                                        </tr>
                                        <tr>
                                            <td>SO-3016</td>
                                            <td>Shree Construction</td>
                                            <td class="text-right">₹3.42L</td>
                                            <td><span class="badge badge-primary">Confirmed</span></td>
                                        </tr>
                                        <tr>
                                            <td>SO-3015</td>
                                            <td>Om Sai Infra</td>
                                            <td class="text-right">₹2.15L</td>
                                            <td><span class="badge badge-success">Ready</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sales + Receipts -->
            <div class="row">
                <div class="col-lg-7">
                    <div class="card dashboard-card">
                        <div class="card-header bg-danger">
                            <span class="font-weight-bold">Recent Sales</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Invoice No.</th>
                                            <th>Customer</th>
                                            <th>Item</th>
                                            <th class="text-right">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>09-09-2026</td>
                                            <td>INV-4521</td>
                                            <td>National Infra</td>
                                            <td>RCC Pipe 900mm</td>
                                            <td class="text-right">₹3,25,000</td>
                                        </tr>
                                        <tr>
                                            <td>08-09-2026</td>
                                            <td>INV-4520</td>
                                            <td>ABC Infra</td>
                                            <td>RCC Pipe 600mm</td>
                                            <td class="text-right">₹2,45,500</td>
                                        </tr>
                                        <tr>
                                            <td>08-09-2026</td>
                                            <td>INV-4519</td>
                                            <td>Shree Construction</td>
                                            <td>RCC Pipe 1200mm</td>
                                            <td class="text-right">₹4,18,000</td>
                                        </tr>
                                        <tr>
                                            <td>07-09-2026</td>
                                            <td>INV-4518</td>
                                            <td>Om Sai Infra</td>
                                            <td>RCC Manhole</td>
                                            <td class="text-right">₹1,86,000</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card dashboard-card">
                        <div class="card-header bg-success">
                            <span class="font-weight-bold">Recent Receipts</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Receipt No.</th>
                                            <th>Customer</th>
                                            <th>Mode</th>
                                            <th class="text-right">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>09-09-2026</td>
                                            <td>RC-3025</td>
                                            <td>National Infra</td>
                                            <td>NEFT</td>
                                            <td class="text-right">₹2,50,000</td>
                                        </tr>
                                        <tr>
                                            <td>08-09-2026</td>
                                            <td>RC-3024</td>
                                            <td>ABC Infra</td>
                                            <td>NEFT</td>
                                            <td class="text-right">₹1,80,000</td>
                                        </tr>
                                        <tr>
                                            <td>07-09-2026</td>
                                            <td>RC-3023</td>
                                            <td>Shree Construction</td>
                                            <td>Cheque</td>
                                            <td class="text-right">₹1,25,000</td>
                                        </tr>
                                        <tr>
                                            <td>06-09-2026</td>
                                            <td>RC-3022</td>
                                            <td>Om Sai Infra</td>
                                            <td>Cash</td>
                                            <td class="text-right">₹75,000</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Outstanding -->
            <div class="card dashboard-card">
                <div class="card-header bg-danger">
                    <span class="font-weight-bold">Customer Outstanding</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th class="text-right">0-30 Days</th>
                                    <th class="text-right">31-60 Days</th>
                                    <th class="text-right">61-90 Days</th>
                                    <th class="text-right">90+ Days</th>
                                    <th class="text-right">Total O/S</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>ABC Infra Pvt. Ltd.</td>
                                    <td class="text-right">₹2.10L</td>
                                    <td class="text-right">₹1.25L</td>
                                    <td class="text-right">₹0.45L</td>
                                    <td class="text-right">₹0.20L</td>
                                    <td class="text-right font-weight-bold">₹4.00L</td>
                                </tr>
                                <tr>
                                    <td>National Infra</td>
                                    <td class="text-right">₹1.85L</td>
                                    <td class="text-right">₹0.90L</td>
                                    <td class="text-right">₹0.35L</td>
                                    <td class="text-right">₹0.15L</td>
                                    <td class="text-right font-weight-bold">₹3.25L</td>
                                </tr>
                                <tr>
                                    <td>Shree Construction</td>
                                    <td class="text-right">₹1.50L</td>
                                    <td class="text-right">₹0.75L</td>
                                    <td class="text-right">₹0.25L</td>
                                    <td class="text-right">₹0.10L</td>
                                    <td class="text-right font-weight-bold">₹2.60L</td>
                                </tr>
                                <tr>
                                    <td>Metro Developers</td>
                                    <td class="text-right">₹1.20L</td>
                                    <td class="text-right">₹0.55L</td>
                                    <td class="text-right">₹0.30L</td>
                                    <td class="text-right">₹0.25L</td>
                                    <td class="text-right font-weight-bold">₹2.30L</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- CRM Reports -->
            <div class="card dashboard-card">
                <div class="card-header bg-secondary">
                    <span class="font-weight-bold">CRM Reports & MIS</span>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-lg-3 col-md-6 col-6 mb-2">
                            <a href="#" class="btn btn-outline-primary btn-block quick-btn">
                                <i class="fa-solid fa-list"></i> Enquiry Register
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 col-6 mb-2">
                            <a href="#" class="btn btn-outline-info btn-block quick-btn">
                                <i class="fa-solid fa-file-invoice"></i> Quotation Register
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 col-6 mb-2">
                            <a href="#" class="btn btn-outline-success btn-block quick-btn">
                                <i class="fa-solid fa-chart-line"></i> Sales Register
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 col-6 mb-2">
                            <a href="#" class="btn btn-outline-warning btn-block quick-btn">
                                <i class="fa-solid fa-money-bill"></i> Receipt Register
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 col-6 mb-2">
                            <a href="#" class="btn btn-outline-danger btn-block quick-btn">
                                <i class="fa-solid fa-file-invoice-dollar"></i> Customer O/S
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 col-6 mb-2">
                            <a href="#" class="btn btn-outline-primary btn-block quick-btn">
                                <i class="fa-solid fa-filter-circle-dollar"></i> Enquiry Conversion
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 col-6 mb-2">
                            <a href="#" class="btn btn-outline-success btn-block quick-btn">
                                <i class="fa-solid fa-arrow-trend-up"></i> Quotation Conversion
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 col-6 mb-2">
                            <a href="#" class="btn btn-outline-danger btn-block quick-btn">
                                <i class="fa-solid fa-chart-column"></i> Lost Quotation
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection