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
            <div class="container-fluid mb-2">
              <div class="dashboard-heading">
                <h2 class="dashboard-title">{{'#'.$transaction->code }}</h2>
                <p class="dashboard-subtitle">Transaksi / Detail</p>
              </div>
              <div class="dashboard-content" id="transactionDetails">
                <div class="row">
                  <div class="col-12">
                    @if (Session::has('success'))
                            <div class="alert alert-success">
                                <p>{{ Session::get('success') }}</p>
                            </div>
                    @endif
                    <div class="card">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-12 col-md-12 text-right">
                            <div class="row">
                              <div class="col-12 col-md-6">
                                <div class="product-title"></div>
                                <div class="product-subtitle"></div>
                              </div>
                              <div class="col-12 col-md-6">
                                <div class="product-title">Pelanggan</div>
                                <div class="product-subtitle">{{ $transaction->user->name }}</div>
                                <div class="product-title">
                                  Status Pembayaran
                                </div>
                                <div class="product-subtitle text-danger">
                                  {{ $transaction->status_label ?? '' }} - {!! $transaction->payment->status_label ?? '' !!} 
                                </div>
                              </div>
                              <div class="col-12 col-md-6">
                                <div class="product-title"></div>
                                <div class="product-subtitle"></div>
                              </div>
                              <div class="col-12 col-md-6">
                                <div class="product-title">
                                  Total Pembayaran
                                </div>
                                <div class="product-subtitle">Rp. {{$globalFunction->formatRupiah($transaction->total_price) }}</div>
                                <div class="product-title">
                                    Bukti Pembayaran
                                    </div>
                                    <div class="product-subtitle">
                                    <a href="{{ Storage::url($transaction->payment->image) ?? '' }}" target="_blank">
                                        <img
                                        src="{{ Storage::url($transaction->payment->image) ?? ''}}"
                                        style="width: 60px"
                                        />
                                    </a>
                                    </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12 mt-4">
                            <h5>Detail Barang</h5>
                          </div>
                          <div class="col-12 mt-2">
                            @foreach ($items as $item)
                            <div class="card-body">
                              <div class="row">
                                <div class="col-md-1">
                                  <img
                                    src="{{ Storage::url($item->product->galleries->first()->photos ?? '') }}"
                                  class="w-50"
                                  />
                                </div>
                                <div class="col-md-4">
                                  {{ $item->product->name }}
                                  <small>
                                  (x {{ $item->qty }})
                                  </small>
                                  <p class="product-title">{{ $item->product->user->store_name }}</p>
                                </div>
                                <div class="col-md-3">
                                  Rp. {{$globalFunction->formatRupiah($item->price) }}
                                  <p class="product-title">Harga</p>
                                </div>
                                <div class="col-md-3">
                                  Rp. {{$globalFunction->formatRupiah($item->price * $item->qty) }}
                                  <p class="product-title">Total</p>
                                </div>
                              </div>
                            </div>
                            @endforeach
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-12 mt-4">
                            <h5>Informasi Pengiriman</h5>
                          </div>
                          <div class="col-12">
                            <div class="row">
                              <div class="col-12 col-md-6">
                                <div class="product-title">Provinsi</div>
                                <div class="product-subtitle">{{ $transaction->user->regencies->province->name }}</div>
                              </div>
                              <div class="col-12 col-md-6">
                                <div class="product-title">Kab / Kota</div>
                                <div class="product-subtitle">{{ $transaction->user->regencies->name }}</div>

                              </div>
                              <div class="col-12 col-md-6">
                                <div class="product-title">Kode Pos</div>
                                <div class="product-subtitle">{{ $transaction->user->zip_code }}</div>
                              </div>
                              <div class="col-12 col-md-6">
                                <div class="product-title">Telpon</div>
                                <div class="product-subtitle">{{ $transaction->user->phone_number }}</div>
                              </div>
                              <div class="col-12 col-md-6">
                                <div class="product-title">Alamat Lengkap</div>
                                <div class="product-subtitle">
                                  {{ $transaction->user->address_one }}
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row mt-4">
                          <div class="col-12 text-right">
                              <form action="{{ route('aproov-payment', $transaction->payment->id) }}" method="POST">
                                  @csrf
                                  <button
                                    type="submit"
                                    class="btn btn-sm btn-success btn-lg mt-4"
                                  >
                                    Terima Pembayaran
                                  </button>
                              </form>
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
