@extends('layouts.app')

@section('title')
    Store Detail Page
@endsection

@section('content')
<div class="page-content page-details">
      <section
        class="store-breadcrumbs"
        data-aos="fade-down"
        data-aos-delay="100"
      >
        <div class="container">
          <div class="row">
            <div class="col-12">
              <nav>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a href="/index.html">Home</a>
                  </li>
                  <li class="breadcrumb-item active">Product Details</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </section>

      <section class="store-gallery mb-5" id="gallery">
        <div class="container">
          <div class="row">
            <div class="col-lg-8" data-aos="zoom-in">
              <transition name="slide-fade" mode="out-in">
                <img
                  :src="photos[activePhoto].url"
                  :key="photos[activePhoto].id"
                  class="w-100 main-image"
                />
              </transition>
            </div>
              <div class="col-lg-2">
                <div class="row">
                  <div
                    class="col-3 col-lg-12 mt-2 mt-lg-0"
                    v-for="(photo, index) in photos"
                    :key="photo.id"
                    data-aos="zoom-in"
                    data-aos-delay="100"
                  >
                    <a href="#" @click="changeActive(index)">
                      <img
                        :src="photo.url"
                        class="w-100 thumbnail-image"
                        :class="{ active: index == activePhoto }"
                      />
                    </a>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </section>

      <div class="store-details-container" data-aos="fade-up">
        <section class="store-heading">
          <div class="container">
            <div class="row">
              <div class="col-lg-8">
                <h1>{{ $product->name }}</h1>
                <div class="owner">{{ $product->user->store_name }}</div>
                <div class="price">{{'Rp. '.$globalFunction->formatRupiah($product->price)}}</div>
              </div>
              
              <div class="col-lg-2" data-aos="zoom-in">
                @auth
                  <form action="{{ route('detail-add', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="1" name="qty">
                    <button
                      type="submit" 
                      class="btn btn-success px-4 text-white btn-block mb-3">
                        Tamabah Keranjang
                    </button>
                  </form>
                @else
                <a 
                    href="{{ route('login') }}" 
                    class="btn btn-success px-4 text-white btn-block mb-3">
                      Login untuk menambahkan
                  </a>
                @endauth
              </div>
            </div>
          </div>
        </section>
        <section class="store-description">
          <div class="container">
            <div class="row">
              <div class="col-12 col-lg-8">
               {!! $product->description !!}
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
@endsection

@push('addon-script')
 <script src="/vendor/vue/vue.js"></script>
    <script>
      var galery = new Vue({
        el: "#gallery",
        mounted() {
          AOS.init();
        },
        data: {
          activePhoto: 0,
          photos: [
            @foreach($product->galleries as $gallery)
              {
                id: {{ $gallery->id }},
                url: "{{ Storage::url($gallery->photos) }}",
              },
            @endforeach
          ],
        },
        methods: {
          changeActive(id) {
            this.activePhoto = id;
          },
        },
      });
    </script>
@endpush