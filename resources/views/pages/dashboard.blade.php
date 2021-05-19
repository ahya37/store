@extends('layouts.dashboard')

@section('title')
    Store Dashboard
@endsection

@section('content')
 <!-- Section Content -->
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
                <h2 class="dashboard-title">Dashboard</h2>
                <p class="dashboard-subtitle">Lihat ada yang kamu buat hari ini!</p>
              </div>
              <div class="dashboard-content">
                <div class="row">
                  <div class="col-md-4">
                    <div class="card mb-2">
                      <div class="card-body">
                        <div class="dashboard-card-title">Revenue</div>
                        <div class="dashboard-card-subtitle">{{ number_format($revenue) }}</div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="card mb-2">
                      <div class="card-body">
                        <div class="dashboard-card-title">Transaksi</div>
                        <div class="dashboard-card-subtitle">{{ number_format($transaction_count) }}</div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-4">
                    <h5>Pesanan Saya</h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="card mb-2">
                      <div class="card-body">
                        <div class="text-center">
                          <div class="dashboard-card-title">
                            <img src="/images/wallet.svg" alt="" />
                            <small class="badge badge-danger">3</small>
                          </div>
                          <div class="dashboard-card-subtitle">Belum Bayar</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="card mb-2">
                      <div class="card-body">
                        <div class="text-center">
                          <div class="dashboard-card-title">
                            <a href="">
                              <img src="/images/van.svg" alt="" />
                              <small class="badge badge-warning">3</small>
                            </a>
                          </div>
                          <div class="dashboard-card-subtitle">Dikirim</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="card mb-2">
                      <div class="card-body">
                        <div class="text-center">
                          <div class="dashboard-card-title">
                            <img src="/images/checklist.svg" alt="" />
                            <small class="badge badge-success">3</small>
                          </div>
                          <div class="dashboard-card-subtitle">Selesai</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
              </div>
    </div>
</div>
@endsection