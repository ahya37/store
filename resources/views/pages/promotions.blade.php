@extends('layouts.app')

@section('title')
    Store Detail Page
@endsection

@section('content')
 <div class="page-content page-details">
      <section
        class="store-breadcrumbs mb-4"
        data-aos="fade-down"
        data-aos-delay="100"
      >
        <div class="container">
          <div class="row">
            <div class="col-12 text-center">
              <div class="owner">
                <h4>Produk Promo</h4>
                <img src="/images/logo.png" width="80px" />
              </div>
              <div class="price mt-4">
                <h6>Silahkan pilih produk dibawah ini</h6>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="store-gallery mt-3" id="gallery">
        <div class="container">
          <div class="row">
            <div class="col-lg-1"></div>
            @foreach ($items as $item)
            <div class="col-lg-5" data-aos="zoom-in">
              <div class="card mb-3">
                <div class="car-body">
                  <transition name="slide-fade" mode="out-in">
                    <img
                      src="{{ Storage::url($item->product->galleries->first()->photos ?? '') }}"
                      class="w-100 main-image"
                    />
                  </transition>
                  <section class="store-description mt-2 text-center">
                    <div class="container">
                      <div class="row">
                        <div class="col-12 col-lg-8">
                          <p>
                            {!! $item->product->name !!}
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="product-subtitle mt-2 mb-2">
                      <a class="btn btn-warning owner"
                          href="https://api.whatsapp.com/send?phone=6287872413014&text=Halo%20CS%20Percikanshop,%20saya%20berminat%20dengan%20produk :%0A%0A{{ route('detail', $item->product->slug) }}%0A%0A*Form Pemesan*%0ANama:%0AAlamat:%0ATelp:%0AJumlah Pembelian:" >
                          Detail Pemesanan
                      </a>
                    </div>
                  </section>
                </div>
              </div>
            </div>
                
            @endforeach
            <div class="col-lg-1"></div>
          </div>
        </div>
      </section>
    </div>
@endsection
