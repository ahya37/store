@extends('layouts.admin')

@section('title')
    Store Dashboard Transaction Details
@endsection

@section('content')
<!-- Section Content -->
          <div
            class="section-content section-dashboard-home"
            data-aos="fade-up"
          >
            <div class="container-fluid">
              <div class="dashboard-heading">
                <h2 class="dashboard-title">Laporan</h2>
                <p class="dashboard-subtitle">Laporan Produk Dijual</p>
              </div>
              <div class="dashboard-content" id="transactionDetails">
                <div class="row">
                  <div class="col-12">
                  @foreach ($report as $store)
                    <div class="card mb-2">
                      <div class="card-body">
                        <div class="table-responsive">
                            <table border="0" class="mb-2">
                                <tr>
                                  <td>Pemilik Toko</td><td>:</td><td>{{ $store->store_name }}</td>
                                </tr>
                            </table>
                            @php
                                $users_id   = $store->users_id;
                                $reportItem = $model->getReportTransactions($users_id);
                            @endphp
                                <table
                                    class="table table-hover scroll-horizontal-vertical w-100"
                                    id="crudTable"
                                >
                                    <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Subtotal (Rp)</th>
                                        <th>Bagi Hasil (Rp)</th>
                                        <th>Pendapatan (Rp)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reportItem as $item)
                                        <tr>
                                            <td>{{ $item->product }}</td>
                                            <td>{{ $globalFunction->formatRupiah($item->subtotal) }}</td>
                                            <td>{{ $globalFunction->formatRupiah($item->total_profit_sharing) }}</td>
                                            <td>{{ $globalFunction->formatRupiah($item->subtotal - $item->total_profit_sharing) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          </div>
@endsection