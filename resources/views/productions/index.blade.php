@extends('productions.layout.app')
@section('page_title', 'Dashboard - Production')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>18</h3>
                            <p>Today's Planned Qty</p>
                        </div>
                        <div class="icon"><i class="fa-solid fa-calendar-check"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>14</h3>
                            <p>Today's Production</p>
                        </div>
                        <div class="icon"><i class="fa-solid fa-industry"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>02</h3>
                            <p>Today's Rejection</p>
                        </div>
                        <div class="icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>03</h3>
                            <p>Pending Production Plans</p>
                        </div>
                        <div class="icon"><i class="fa-solid fa-clock"></i></div>
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
                            <a href="production_planning.html" class="btn btn-primary btn-block quick-btn"><i
                                    class="fa-solid fa-calendar-days"></i> Production Planning</a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-2">
                            <a href="daily_production.html" class="btn btn-success btn-block quick-btn"><i
                                    class="fa-solid fa-industry"></i> Daily Production</a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-2">
                            <a href="rejection.html" class="btn btn-danger btn-block quick-btn"><i
                                    class="fa-solid fa-ban"></i> Rejection Entry</a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-2">
                            <a href="finished_item.html" class="btn btn-info btn-block quick-btn"><i
                                    class="fa-solid fa-box"></i> Finished Item</a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-2">
                            <a href="bom.html" class="btn btn-warning btn-block quick-btn"><i
                                    class="fa-solid fa-list-check"></i> BOM</a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-2">
                            <a href="machine.html" class="btn btn-dark btn-block quick-btn"><i
                                    class="fa-solid fa-gears"></i> Machines</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card dashboard-card">
                        <div class="card-header bg-primary">
                            <span class="font-weight-bold">Today's Production</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Finished Item</th>
                                            <th>Size</th>
                                            <th>Machine</th>
                                            <th>Shift</th>
                                            <th>Contractor</th>
                                            <th class="text-right">Planned</th>
                                            <th class="text-right">Produced</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>RCC Pipe</td>
                                            <td>600mm</td>
                                            <td>Machine 01</td>
                                            <td>Morning</td>
                                            <td>Contractor A</td>
                                            <td class="text-right">30</td>
                                            <td class="text-right">28</td>
                                            <td><span class="badge badge-success">Completed</span></td>
                                        </tr>
                                        <tr>
                                            <td>RCC Pipe</td>
                                            <td>900mm</td>
                                            <td>Machine 02</td>
                                            <td>Morning</td>
                                            <td>Contractor B</td>
                                            <td class="text-right">20</td>
                                            <td class="text-right">18</td>
                                            <td><span class="badge badge-success">Completed</span></td>
                                        </tr>
                                        <tr>
                                            <td>RCC Pipe</td>
                                            <td>1200mm</td>
                                            <td>Machine 03</td>
                                            <td>Evening</td>
                                            <td>Contractor A</td>
                                            <td class="text-right">15</td>
                                            <td class="text-right">10</td>
                                            <td><span class="badge badge-warning">In Progress</span></td>
                                        </tr>
                                        <tr>
                                            <td>RCC Pipe</td>
                                            <td>1500mm</td>
                                            <td>Machine 04</td>
                                            <td>Evening</td>
                                            <td>Contractor C</td>
                                            <td class="text-right">10</td>
                                            <td class="text-right">0</td>
                                            <td><span class="badge badge-secondary">Pending</span></td>
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
                            <span class="font-weight-bold">Production Alerts</span>
                        </div>
                        <div class="card-body p-2">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center px-2">
                                    Pending Production Plans <span class="badge badge-danger">03</span></li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-2">
                                    Rejection Entries <span class="badge badge-warning">02</span></li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-2">
                                    Maintenance Due <span class="badge badge-danger">01</span></li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-2">
                                    BOM Not Available <span class="badge badge-warning">02</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card dashboard-card">
                        <div class="card-header bg-info">
                            <span class="font-weight-bold">Production Planning</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Plan Date</th>
                                            <th>Finished Item</th>
                                            <th>Size</th>
                                            <th class="text-right">Qty</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>09-09-2026</td>
                                            <td>RCC Pipe</td>
                                            <td>600mm</td>
                                            <td class="text-right">30</td>
                                            <td><span class="badge badge-success">Completed</span></td>
                                        </tr>
                                        <tr>
                                            <td>09-09-2026</td>
                                            <td>RCC Pipe</td>
                                            <td>900mm</td>
                                            <td class="text-right">20</td>
                                            <td><span class="badge badge-success">Completed</span></td>
                                        </tr>
                                        <tr>
                                            <td>09-09-2026</td>
                                            <td>RCC Pipe</td>
                                            <td>1200mm</td>
                                            <td class="text-right">15</td>
                                            <td><span class="badge badge-warning">In Progress</span></td>
                                        </tr>
                                        <tr>
                                            <td>10-09-2026</td>
                                            <td>RCC Pipe</td>
                                            <td>1500mm</td>
                                            <td class="text-right">10</td>
                                            <td><span class="badge badge-secondary">Planned</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card dashboard-card">
                        <div class="card-header bg-danger">
                            <span class="font-weight-bold">Recent Rejections</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Finished Item</th>
                                            <th>Size</th>
                                            <th class="text-right">Qty</th>
                                            <th>Reason</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>09-09-2026</td>
                                            <td>RCC Pipe</td>
                                            <td>600mm</td>
                                            <td class="text-right">1</td>
                                            <td>Crack</td>
                                        </tr>
                                        <tr>
                                            <td>09-09-2026</td>
                                            <td>RCC Pipe</td>
                                            <td>900mm</td>
                                            <td class="text-right">1</td>
                                            <td>Dimension</td>
                                        </tr>
                                        <tr>
                                            <td>08-09-2026</td>
                                            <td>RCC Pipe</td>
                                            <td>1200mm</td>
                                            <td class="text-right">2</td>
                                            <td>Damage</td>
                                        </tr>
                                        <tr>
                                            <td>08-09-2026</td>
                                            <td>RCC Pipe</td>
                                            <td>600mm</td>
                                            <td class="text-right">1</td>
                                            <td>Crack</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card dashboard-card">
                        <div class="card-header bg-dark">
                            <span class="font-weight-bold">Machine Status & Maintenance</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Machine</th>
                                            <th>Status</th>
                                            <th>Next Maintenance</th>
                                            <th>Period</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Machine 01</td>
                                            <td><span class="badge badge-success">Running</span></td>
                                            <td>20-09-2026</td>
                                            <td>30 Days</td>
                                        </tr>
                                        <tr>
                                            <td>Machine 02</td>
                                            <td><span class="badge badge-success">Running</span></td>
                                            <td>25-09-2026</td>
                                            <td>30 Days</td>
                                        </tr>
                                        <tr>
                                            <td>Machine 03</td>
                                            <td><span class="badge badge-warning">Maintenance Due</span></td>
                                            <td>10-09-2026</td>
                                            <td>30 Days</td>
                                        </tr>
                                        <tr>
                                            <td>Machine 04</td>
                                            <td><span class="badge badge-secondary">Idle</span></td>
                                            <td>30-09-2026</td>
                                            <td>45 Days</td>
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
                            <span class="font-weight-bold">Finished Product Stock</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Finished Item</th>
                                            <th>Size</th>
                                            <th class="text-right">Stock</th>
                                            <th class="text-right">Required</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>RCC Pipe</td>
                                            <td>600mm</td>
                                            <td class="text-right">85</td>
                                            <td class="text-right">30</td>
                                            <td><span class="badge badge-success">Available</span></td>
                                        </tr>
                                        <tr>
                                            <td>RCC Pipe</td>
                                            <td>900mm</td>
                                            <td class="text-right">42</td>
                                            <td class="text-right">20</td>
                                            <td><span class="badge badge-success">Available</span></td>
                                        </tr>
                                        <tr>
                                            <td>RCC Pipe</td>
                                            <td>1200mm</td>
                                            <td class="text-right">12</td>
                                            <td class="text-right">15</td>
                                            <td><span class="badge badge-warning">Low Stock</span></td>
                                        </tr>
                                        <tr>
                                            <td>RCC Pipe</td>
                                            <td>1500mm</td>
                                            <td class="text-right">4</td>
                                            <td class="text-right">10</td>
                                            <td><span class="badge badge-danger">Shortage</span></td>
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
                    <span class="font-weight-bold">MIS Reports</span>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-lg-3 col-md-6 col-6 mb-2">
                            <a href="raw_material_consumption.html" class="btn btn-outline-primary btn-block quick-btn"><i
                                    class="fa-solid fa-chart-column"></i> Raw Material Consumption</a>
                        </div>
                        <div class="col-lg-3 col-md-6 col-6 mb-2">
                            <a href="production_rejection_report.html" class="btn btn-outline-danger btn-block quick-btn"><i
                                    class="fa-solid fa-chart-pie"></i> Production / Rejection %</a>
                        </div>
                        <div class="col-lg-3 col-md-6 col-6 mb-2">
                            <a href="production_cost.html" class="btn btn-outline-success btn-block quick-btn"><i
                                    class="fa-solid fa-indian-rupee-sign"></i> Production Cost</a>
                        </div>
                        <div class="col-lg-3 col-md-6 col-6 mb-2">
                            <a href="production_register.html" class="btn btn-outline-dark btn-block quick-btn"><i
                                    class="fa-solid fa-file-lines"></i> Production Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection