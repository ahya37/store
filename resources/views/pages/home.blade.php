@extends('layouts.app')

@section('title')
    Store Homepage
@endsection

@section('content')
 <div class="page-content page-home">
      <section class="store-carousel">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 mt-4" data-aos="zoom-in">
              <div
                id="storeCarousel"
                class="carousel slide mt-4"
                data-ride="carousel"
              >
                <ol class="carousel-indicators">
                  <li
                    class="active"
                    data-target="#storeCarousel"
                    data-slide-to="0"
                  ></li>
                  <li data-target="#storeCarousel" data-slide-to="1"></li>
                  <li data-target="#storeCarousel" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img
                      src="/images/banner1.jpg"
                      alt="Carousel Image"
                      class="d-block w-100"
                    />
                  </div>
                  <div class="carousel-item">
                    <img
                      src="/images/banner2.jpg"
                      alt="Carousel Image"
                      class="d-block w-100"
                    />
                  </div>
                  <div class="carousel-item">
                    <img
                      src="/images/banner3.jpg"
                      alt="Carousel Image"
                      class="d-block w-100"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="store-trend-categories">
        <div class="container">
          <div class="row">
            <div class="col-12" data-aos="fade-up">
              <h5>Kategori</h5>
            </div>
          </div>
          <div class="row">
            @php $incrementCategory = 0 @endphp
            @forelse ($categories as $category)
              <div
                class="col-6 col-md-3 col-lg-2"
                data-aos="fade-up"
                data-aos-delay="{{ $incrementCategory += 100 }}"
              >
                <a href="{{ route('categories-detail', $category->slug) }}" class="component-categories d-block">
                  <div class="categories-image">
                    <img src="{{ Storage::url($category->photo) }}" class="w-100" />
                  </div>
                  <p class="categories-text">{{ $category->name }}</p>
                </a>
              </div>
            @empty
                <div class="col-12 text-center py-5" data-aos="fade-up" data-aos-delay="100">
                  Tidak ada kategori
                </div>
            @endforelse
          </div>
        </div>
      </section>

      <section class="store-new-products">
        <div class="container">
          <div class="row">
            <div class="col-12" data-aos="fade-up">
              <h5>Produk</h5>
            </div>
          </div>
          <div class="row">
            @php $incrementProduct = 0 @endphp
            @forelse ($products as $product)
              <div
                class="col-6 col-md-4 col-lg-3 aos-init"
                data-aos="fade-up"
                data-aos-delay="{{ $incrementProduct += 100 }}"
              >
                <a href="{{ route('detail', $product->product->slug) }}" class="component-products d-block">
                  <div class="products-thumbnail">
                    <div
                      class="products-image"
                      style="
                        @if($product->product->galleries->count())
                            background-image:url('{{ Storage::url($product->product->galleries->first()->photos) }}')
                        @else
                          background-color: #eee
                        @endif
                      "
                    ></div>
                  </div>
                  <div class="products-text">{{ $product->product->name }}</div>
                  <small class="products-stock">Stok: {{ $product->product->stock }}</small>
                  <div class="products-price">{{'Rp. '.$globalFunction->formatRupiah($product->product->price)}}</div>
                </a>
                 <div class="products-text">
                  <form action="{{ route('detail-add', $product->product->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                      <button
                        onclick="var result = document.getElementById('sst{{ $product->product->id}}'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
                        class="btn btn-sm btn-secondary input-group-text"
                        type="button"
                      >
                        -
                      </button>
                    </div>
                    <input
                      type="number"
                      min="1"
                      value="1"
                      name="qty"
                      id="sst{{ $product->product->id}}"
                      class="form-control form-control-sm text-center"
                    />
                    <div class="input-group-append">
                      <button
                        onclick="var result = document.getElementById('sst{{ $product->product->id}}'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                        class="btn btn-sm btn-secondary input-group-text"
                        type="button"
                      >
                        +
                      </button>
                    </div>
                  </div>
                  <div class="mt-2">
                      <button
                        type="submit"
                        class="btn btn-success px-4 text-white btn-block mb-3"
                      >
                        Tambah Keranjang
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            @empty
              <div class="col-12 text-center py-5" data-aos="fade-up" data-aos-delay="100">
                Tidak ada produk
              </div>
            @endforelse
          </div>
        </div>
      </section>
    </div>    
@endsection