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
                <h2 class="dashboard-title">Pesanan Saya</h2>
              </div>
              <div class="dashboard-content">
                <div class="row">
                  <div class="col-12 mt-2">
                    <ul
                      class="nav nav-pills mb-3"
                      id="pills-tab"
                      role="tablist"
                    >
                      <li class="nav-item" role="presentation">
                        <a
                          class="nav-link active"
                          id="pills-home-tab"
                          data-toggle="pill"
                          href="#pills-home"
                          role="tab"
                          aria-controls="pills-home"
                          aria-selected="true"
                          >Belum Bayar</a
                        >
                      </li>
                      <li class="nav-item" role="presentation">
                        <a
                          class="nav-link"
                          id="pills-profile-tab"
                          data-toggle="pill"
                          href="#pills-profile"
                          role="tab"
                          aria-controls="pills-profile"
                          aria-selected="false"
                          >Dikirim</a
                        >
                      </li>
                      <li class="nav-item" role="presentation">
                        <a
                          class="nav-link"
                          id="pills-profile-tab"
                          data-toggle="pill"
                          href="#pills-finish"
                          role="tab"
                          aria-controls="pills-profile"
                          aria-selected="false"
                          >Selesai</a
                        >
                      </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                      <div
                        class="tab-pane fade show active"
                        id="pills-home"
                        role="tabpanel"
                        aria-labelledby="pills-home-tab"
                      >
                       @foreach ($unpaid as $item)
                        <a
                          href="{{ route('dashboard-transactions-myorder-detail', $item->code) }}"
                          class="card card-list d-block"
                        >
                          <div class="card-body">
                            <div class="row">
                              <div class="col-md-4">{{'#'.$item->code }}</div>
                              <div class="col-md-3"></div>
                              <div class="col-md-3">{{ date('d-m-Y H:i:s', strtotime($item->created_at)) }}</div>
                              <div class="col-md-1 d-none d-md-block">
                                <img src="/images/dashboard-arrow-right.svg" />
                              </div>
                            </div>
                          </div>
                        </a>
                      @endforeach
                      </div>
                      <div
                        class="tab-pane fade"
                        id="pills-profile"
                        role="tabpanel"
                        aria-labelledby="pills-profile-tab"
                      >
                        <a
                          href="/dashboard-transaction-details.html"
                          class="card card-list d-block"
                        >
                          <div class="card-body">
                            <div class="row">
                              <div class="col-md-4">STORE - 998998</div>
                              <div class="col-md-3"></div>
                              <div class="col-md-3">12 Januari, 2020</div>
                              <div class="col-md-1 d-none d-md-block">
                                <img src="/images/dashboard-arrow-right.svg" />
                              </div>
                            </div>
                          </div>
                        </a>
                      </div>
                      <div
                        class="tab-pane fade"
                        id="pills-finish"
                        role="tabpanel"
                        aria-labelledby="pills-profile-tab"
                      >
                      @foreach ($unpaid as $item)
                        <a
                          href="/dashboard-transaction-details.html"
                          class="card card-list d-block"
                        >
                          <div class="card-body">
                            <div class="row">
                              <div class="col-md-4">{{ $item->code }}</div>
                              <div class="col-md-3"></div>
                              <div class="col-md-3">12 Januari, 2020</div>
                              <div class="col-md-1 d-none d-md-block">
                                <img src="/images/dashboard-arrow-right.svg" />
                              </div>
                            </div>
                          </div>
                        </a>
                      @endforeach
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
@endsection
