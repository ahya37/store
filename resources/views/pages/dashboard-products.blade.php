@extends('layouts.dashboard')

@section('title')
    Store Dashboard Product
@endsection

@section('content')
 <!-- Section Content -->
          <div
            class="section-content section-dashboard-home"
            data-aos="fade-up"
          >
            <div class="container-fluid">
              <div class="dashboard-heading">
                <h2 class="dashboard-title">Produk Saya</h2>
                <p class="dashboard-subtitle">Kelola dengan baik dan dapatkan uang</p>
              </div>

              @if($id_card == NULL)
              <div class="dashboard-content">
                <div class="row">
                  <div class="col-12">
                    <p>Anda belum upload KTP untuk upload produk dan mulai berjualan</p>
                    <p>Silahkan Upload KTP di menu Pengaturan Toko</p>
                     <form action="" method="post" enctype="multipart/form-data" class="dropzone">
                        @csrf
                    </form>
                  </div>
                </div>
              </div>
              @elseif($id_card->status == 0)
              <div class="dashboard-content">
                <div class="row">
                  <div class="col-12">
                    <p>KTP telah di upload, silahkan menunggu persetujuan Admin Percikanshop</p>
                     <form action="" method="post" enctype="multipart/form-data" class="dropzone">
                        @csrf
                    </form>
                  </div>
                </div>
              </div>
              @else
              <div class="dashboard-content">
                <div class="row">
                  <div class="col-12">
                    <a
                      href="{{ route('dashboard-product-create') }}"
                      class="btn btn-success"
                      >Tambah Produk Baru</a
                    >
                  </div>
                </div>
                <div class="row mt-4">
                  @foreach ($products as $product)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                      <a
                        href="{{ route('dashboard-product-details', $product->id) }}"
                        class="card card-dashboard-product d-block"
                      >
                        <div class="card-body">
                          <img
                            src="{{ Storage::url($product->galleries->first()->photos ?? '') }}"
                            class="w-100 mb-2"
                          />
                          <div class="product-title">{{ $product->name }}</div>
                          <div class="product-category">{{ $product->category->name }}</div>
                        </div>
                      </a>
                    </div>
                  @endforeach
                </div>
              </div>
              @endif
            </div>
          </div>
@endsection
