@extends('layouts.app')

@section('title')
    Store Category Page
@endsection

@section('content')
<div class="page-content page-home">
      <section class="store-trend-categories">
        <div class="container">
          <div class="row">
            <div class="col-12" data-aos="fade-up">
              <h5>Semua Kategori</h5>
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

      {{-- <section class="store-new-products">
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
                <a href="{{ route('detail', $product->slug) }}" class="component-products d-block">
                  <div class="products-thumbnail">
                    <div
                      class="products-image"
                      style="
                        @if($product->galleries->count())
                            background-image:url('{{ Storage::url($product->galleries->first()->photos) }}')
                        @else
                          background-color: #eee
                        @endif
                      "
                    ></div>
                  </div>
                  <div class="products-text">{{ $product->naem }}</div>
                  <div class="products-price">{{'Rp. '.$product->price}}</div>
                  <div class="products-text">
                    <a 
                    href="https://api.whatsapp.com/send?phone=6287881521500&text=Halo%20CS%20Percikanshop,%20saya%20berminat%20dengan%20produk :%0A%0A{{ route('detail', $product->slug) }}%0A%0A*Form Pemesan*%0ANama:%0AAlamat:%0ATelp:%0AJumlah Pembelian:" 
                    class="btn btn-success px-4 text-white btn-block mb-3">
                      Beli Via Wathsapp
                  </a>
                  </div>
                </a>
              </div>
            @empty
              <div class="col-12 text-center py-5" data-aos="fade-up" data-aos-delay="100">
                Tidak ada produk
              </div>
            @endforelse
          </div>
          <div class="row">
            <div class="col-12 mt-4">
              {{ $products->links() }}
            </div>
          </div>
        </div>
      </section> --}}
    </div>
@endsection