@extends('layouts.dashboard')

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
                <p class="dashboard-subtitle">TLaporan Produk Dijual</p>
              </div>
              <div class="dashboard-content" id="transactionDetails">
                <div class="row">
                  <div class="col-12">
                    <div class="card">
                      <div class="card-body">
                        <div class="table-responsive">
                          <table
                            class="table table-hover scroll-horizontal-vertical w-100"
                            id="crudTable"
                          >
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Subtotal (Rp)</th>
                                <th>Bagi Hasil (Rp)</th>
                                <th>Pendapatan (Rp)</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach ($report as $item)
                                  <tr>
                                    <td>{{ $no++ }}</td>
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
                  </div>
                </div>
              </div>
            </div>
          </div>
@endsection