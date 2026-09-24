@extends('layout.app', ['dept' => 'Payroll'])
@section('page_title', 'Dashboard - Payroll')

@section('content')

<section class="content mt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>18</h3>
                        <p>Contractors</p>
                    </div>
                    <div class="icon"><i class="fa-solid fa-helmet-safety"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>126</h3>
                        <p>Workers</p>
                    </div>
                    <div class="icon"><i class="fa-solid fa-users"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>₹2.45L</h3>
                        <p>Pending Advances</p>
                    </div>
                    <div class="icon"><i class="fa-solid fa-hand-holding-dollar"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>₹8.72L</h3>
                        <p>Contractor Outstanding</p>
                    </div>
                    <div class="icon"><i class="fa-solid fa-file-invoice-dollar"></i></div>
                </div>
            </div>
        </div>

        <div class="card dashboard-card">
            <div class="card-header bg-primary">
                <span class="font-weight-bold">Quick Actions</span>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-lg-2 col-md-4 col-6 mb-2">
                        <a href="{{ route('payroll.contractor') }}" class="btn btn-primary btn-block quick-btn">
                            <i class="fa-solid fa-helmet-safety"></i> Contractor
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6 mb-2">
                        <a href="{{ route('payroll.worker') }}" class="btn btn-success btn-block quick-btn">
                            <i class="fa-solid fa-user"></i> Worker
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6 mb-2">
                        <a href="{{ route('payroll.workerAdvance') }}" class="btn btn-warning btn-block quick-btn">
                            <i class="fa-solid fa-hand-holding-dollar"></i> Worker Advance
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6 mb-2">
                        <a href="{{ route('payroll.contractorBill') }}" class="btn btn-info btn-block quick-btn">
                            <i class="fa-solid fa-file-invoice"></i> Contractor Bill
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6 mb-2">
                        <a href="#" class="btn btn-success btn-block quick-btn">
                            <i class="fa-solid fa-money-bill-transfer"></i> Payment
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6 mb-2">
                        <a href="#" class="btn btn-dark btn-block quick-btn">
                            <i class="fa-solid fa-list"></i> Bill Register
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card dashboard-card">
                    <div class="card-header bg-primary">
                        <span class="font-weight-bold">Recent Contractor Bills</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Bill No.</th>
                                        <th>Contractor</th>
                                        <th class="text-right">Bill Amount</th>
                                        <th class="text-right">Advance</th>
                                        <th class="text-right">Net Payable</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>09-09-2026</td>
                                        <td>CB-1025</td>
                                        <td>Contractor A</td>
                                        <td class="text-right">₹1,85,000</td>
                                        <td class="text-right">₹25,000</td>
                                        <td class="text-right">₹1,60,000</td>
                                        <td><span class="badge badge-warning">Pending</span></td>
                                    </tr>
                                    <tr>
                                        <td>08-09-2026</td>
                                        <td>CB-1024</td>
                                        <td>Contractor B</td>
                                        <td class="text-right">₹1,42,500</td>
                                        <td class="text-right">₹20,000</td>
                                        <td class="text-right">₹1,22,500</td>
                                        <td><span class="badge badge-success">Approved</span></td>
                                    </tr>
                                    <tr>
                                        <td>07-09-2026</td>
                                        <td>CB-1023</td>
                                        <td>Contractor C</td>
                                        <td class="text-right">₹2,10,000</td>
                                        <td class="text-right">₹30,000</td>
                                        <td class="text-right">₹1,80,000</td>
                                        <td><span class="badge badge-success">Paid</span></td>
                                    </tr>
                                    <tr>
                                        <td>06-09-2026</td>
                                        <td>CB-1022</td>
                                        <td>Contractor D</td>
                                        <td class="text-right">₹98,000</td>
                                        <td class="text-right">₹15,000</td>
                                        <td class="text-right">₹83,000</td>
                                        <td><span class="badge badge-warning">Pending</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card dashboard-card">
                    <div class="card-header bg-danger">
                        <span class="font-weight-bold">Contractor Outstanding</span>
                    </div>
                    <div class="card-body p-2">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center px-2">
                                Contractor A
                                <span class="badge badge-danger">₹2.15L</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-2">
                                Contractor B
                                <span class="badge badge-warning">₹1.82L</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-2">
                                Contractor C
                                <span class="badge badge-warning">₹1.65L</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-2">
                                Contractor D
                                <span class="badge badge-danger">₹1.45L</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card dashboard-card">
                    <div class="card-header bg-warning">
                        <span class="font-weight-bold">Recent Worker Advances</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Worker</th>
                                        <th>Contractor</th>
                                        <th class="text-right">Advance</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>09-09-2026</td>
                                        <td>Ramesh</td>
                                        <td>Contractor A</td>
                                        <td class="text-right">₹5,000</td>
                                        <td><span class="badge badge-warning">Outstanding</span></td>
                                    </tr>
                                    <tr>
                                        <td>08-09-2026</td>
                                        <td>Suresh</td>
                                        <td>Contractor B</td>
                                        <td class="text-right">₹3,500</td>
                                        <td><span class="badge badge-warning">Outstanding</span></td>
                                    </tr>
                                    <tr>
                                        <td>08-09-2026</td>
                                        <td>Mahesh</td>
                                        <td>Contractor A</td>
                                        <td class="text-right">₹4,000</td>
                                        <td><span class="badge badge-success">Adjusted</span></td>
                                    </tr>
                                    <tr>
                                        <td>07-09-2026</td>
                                        <td>Ganesh</td>
                                        <td>Contractor C</td>
                                        <td class="text-right">₹6,000</td>
                                        <td><span class="badge badge-warning">Outstanding</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card dashboard-card">
                    <div class="card-header bg-success">
                        <span class="font-weight-bold">Recent Contractor Payments</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Payment No.</th>
                                        <th>Contractor</th>
                                        <th>Mode</th>
                                        <th class="text-right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>09-09-2026</td>
                                        <td>CP-2026</td>
                                        <td>Contractor C</td>
                                        <td>NEFT</td>
                                        <td class="text-right">₹1,80,000</td>
                                    </tr>
                                    <tr>
                                        <td>08-09-2026</td>
                                        <td>CP-2025</td>
                                        <td>Contractor B</td>
                                        <td>NEFT</td>
                                        <td class="text-right">₹1,22,500</td>
                                    </tr>
                                    <tr>
                                        <td>06-09-2026</td>
                                        <td>CP-2024</td>
                                        <td>Contractor A</td>
                                        <td>Cheque</td>
                                        <td class="text-right">₹1,50,000</td>
                                    </tr>
                                    <tr>
                                        <td>05-09-2026</td>
                                        <td>CP-2023</td>
                                        <td>Contractor D</td>
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

        <div class="card dashboard-card">
            <div class="card-header bg-secondary">
                <span class="font-weight-bold">Payroll Reports</span>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-lg-3 col-md-6 col-6 mb-2">
                        <a href="#" class="btn btn-outline-warning btn-block quick-btn">
                            <i class="fa-solid fa-hand-holding-dollar"></i> Worker's Advance Register
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 col-6 mb-2">
                        <a href="#" class="btn btn-outline-primary btn-block quick-btn">
                            <i class="fa-solid fa-file-invoice"></i> Contractor Bill Register
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 col-6 mb-2">
                        <a href="#" class="btn btn-outline-success btn-block quick-btn">
                            <i class="fa-solid fa-money-check-dollar"></i> Contractor Payment Register
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 col-6 mb-2">
                        <a href="#" class="btn btn-outline-danger btn-block quick-btn">
                            <i class="fa-solid fa-file-invoice-dollar"></i> Contractor O/S
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection