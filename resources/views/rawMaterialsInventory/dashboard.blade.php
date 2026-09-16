@extends('rawMaterialsInventory.layout.app')
@section('page_title', 'Dashboard - Raw Material Inventory')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>24</h3>
                            <p>Raw Materials</p>
                        </div>
                        <div class="icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>1,248</h3>
                            <p>Total Stock Qty</p>
                        </div>
                        <div class="icon"><i class="fa-solid fa-cubes"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>07</h3>
                            <p>Low Stock Items</p>
                        </div>
                        <div class="icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>03</h3>
                            <p>Out of Stock</p>
                        </div>
                        <div class="icon"><i class="fa-solid fa-circle-xmark"></i></div>
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
                            <a href="add_material.html" class="btn btn-primary btn-block quick-btn"><i
                                    class="fa-solid fa-plus"></i> Add Material</a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-2">
                            <a href="stock_receipt.html" class="btn btn-success btn-block quick-btn"><i
                                    class="fa-solid fa-arrow-down"></i> Stock Receipt</a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-2">
                            <a href="stock_issue.html" class="btn btn-warning btn-block quick-btn"><i
                                    class="fa-solid fa-arrow-up"></i> Stock Issue</a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-2">
                            <a href="stock_adjustment.html" class="btn btn-info btn-block quick-btn"><i
                                    class="fa-solid fa-sliders"></i> Adjustment</a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-2">
                            <a href="stock_register.html" class="btn btn-danger btn-block quick-btn"><i
                                    class="fa-solid fa-list"></i> Stock Register</a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-2">
                            <a href="material_master.html" class="btn btn-dark btn-block quick-btn"><i
                                    class="fa-solid fa-database"></i> Material Master</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card dashboard-card">
                        <div class="card-header bg-primary">
                            <span class="font-weight-bold">Current Stock Status</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Material</th>
                                            <th>Unit</th>
                                            <th class="text-right">Stock</th>
                                            <th class="text-right">Min. Level</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Cement</td>
                                            <td>Bag</td>
                                            <td class="text-right">420</td>
                                            <td class="text-right">200</td>
                                            <td><span class="badge badge-success">Available</span></td>
                                        </tr>
                                        <tr>
                                            <td>M-Sand</td>
                                            <td>MT</td>
                                            <td class="text-right">185</td>
                                            <td class="text-right">100</td>
                                            <td><span class="badge badge-success">Available</span></td>
                                        </tr>
                                        <tr>
                                            <td>20mm Aggregate</td>
                                            <td>MT</td>
                                            <td class="text-right">75</td>
                                            <td class="text-right">80</td>
                                            <td><span class="badge badge-warning">Low Stock</span></td>
                                        </tr>
                                        <tr>
                                            <td>Steel Reinforcement</td>
                                            <td>MT</td>
                                            <td class="text-right">0</td>
                                            <td class="text-right">10</td>
                                            <td><span class="badge badge-danger">Out of Stock</span></td>
                                        </tr>
                                        <tr>
                                            <td>Admixture</td>
                                            <td>Litre</td>
                                            <td class="text-right">568</td>
                                            <td class="text-right">250</td>
                                            <td><span class="badge badge-success">Available</span></td>
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
                            <span class="font-weight-bold">Low / Out of Stock</span>
                        </div>
                        <div class="card-body p-2">
                            <ul class="list-group list-group-flush">
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center px-2">
                                    20mm Aggregate <span class="badge badge-warning">75 MT</span></li>
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center px-2">
                                    Steel Reinforcement <span class="badge badge-danger">0 MT</span></li>
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center px-2">
                                    10mm Aggregate <span class="badge badge-warning">42 MT</span></li>
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center px-2">
                                    Binding Wire <span class="badge badge-warning">18 KG</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card dashboard-card">
                        <div class="card-header bg-success">
                            <span class="font-weight-bold">Recent Stock Receipts</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Material</th>
                                            <th class="text-right">Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>08-09-2026</td>
                                            <td>Cement</td>
                                            <td class="text-right">100 Bags</td>
                                        </tr>
                                        <tr>
                                            <td>07-09-2026</td>
                                            <td>M-Sand</td>
                                            <td class="text-right">25 MT</td>
                                        </tr>
                                        <tr>
                                            <td>06-09-2026</td>
                                            <td>20mm Aggregate</td>
                                            <td class="text-right">20 MT</td>
                                        </tr>
                                        <tr>
                                            <td>05-09-2026</td>
                                            <td>Admixture</td>
                                            <td class="text-right">200 L</td>
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
                            <span class="font-weight-bold">Recent Stock Issues</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Material</th>
                                            <th class="text-right">Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>08-09-2026</td>
                                            <td>Cement</td>
                                            <td class="text-right">60 Bags</td>
                                        </tr>
                                        <tr>
                                            <td>08-09-2026</td>
                                            <td>M-Sand</td>
                                            <td class="text-right">12 MT</td>
                                        </tr>
                                        <tr>
                                            <td>07-09-2026</td>
                                            <td>20mm Aggregate</td>
                                            <td class="text-right">15 MT</td>
                                        </tr>
                                        <tr>
                                            <td>06-09-2026</td>
                                            <td>Admixture</td>
                                            <td class="text-right">75 L</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection