@extends('layouts.app')

@section('title')
    Store Category Page
@endsection

@section('content')
<div class="page-content page-home">
      <section class="store-new-products">
        <div class="container">
          @if($count_product_best_seller != 0)
          <div class="row mt-4">
            <div class="col-12" data-aos="fade-up">
              <h5>Produk Terlaris - Kategori  
              <b>
                {{ $category->name }}
              </b>
            </h5>
            </div>
          </div>
          <div class="row mt-3">
            @php $incrementProduct = 0 @endphp
            @forelse ($product_best_seller as $product)
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
                       @if($product->photos != NULL)
                            background-image:url('{{ Storage::url($product->photos) }}')
                        @else
                          background-color: #eee
                        @endif
                      "
                    ></div>
                  </div>
                  <div class="products-text">{{ $product->name ?? '' }}</div>
                  <small class="products-stock">Stok: {{ $product->stock ?? ''}}</small>
                  <div class="products-price">{{'Rp. '.$globalFunction->formatRupiah($product->price ?? '')}}</div>
                </a>
                <div class="products-text">
                  <form action="{{ route('detail-add', $product->id) ?? ''}}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                      <button
                        onclick="var result = document.getElementById('sst{{ $produc->product->id ?? ''}}'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
                        class="btn btn-sm btn-secondary input-group-text"
                        type="button"
                      >
                        -
                      </button>
                    </div>
                    <input
                      type="text"
                      min="1"
                      value="1"
                      name="qty"
                      id="sst{{ $product->id}}"
                      class="form-control form-control-sm text-center"
                    />
                    <div class="input-group-append">
                      <button
                        onclick="var result = document.getElementById('sst{{ $product->id}}'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
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
                        Tamabah Keranjang
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
          @endif
          {{-- produk terkait --}}
          <div class="row mt-4">
            <div class="col-12" data-aos="fade-up">
              <h5>Produk Terkait - 
                Kategori  
              <b>
                {{ $category->name }}
              </b>
              </h5>
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
                        @if($product->photos != NULL)
                            background-image:url('{{ Storage::url($product->photos) }}')
                        @else
                          background-color: #eee
                        @endif
                      "
                    ></div>
                  </div>
                  <div class="products-text">{{ $product->name }}</div>
                  <small class="products-stock">Stok: {{ $product->stock }}</small>
                  <div class="products-price">{{'Rp. '.$globalFunction->formatRupiah($product->price)}}</div>
                </a>
                <div class="products-text">
                  <form action="{{ route('detail-add', $product->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                      <button
                        onclick="var result = document.getElementById('sst{{ $product->id}}'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
                        class="btn btn-sm btn-secondary input-group-text"
                        type="button"
                      >
                        -
                      </button>
                    </div>
                    <input
                      type="text"
                      min="1"
                      value="1"
                      name="qty"
                      id="sst{{ $product->id}}"
                      class="form-control form-control-sm text-center"
                    />
                    <div class="input-group-append">
                      <button
                        onclick="var result = document.getElementById('sst{{ $product->id}}'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
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
                        Tamabah Keranjang
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
          <div class="row">
            <div class="col-12 mt-4">
              {{ $products->links() }}
            </div>
          </div>
        </div>
      </section>
    </div>
@endsection