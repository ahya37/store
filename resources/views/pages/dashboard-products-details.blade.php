@extends('layouts.dashboard')

@section('title')
    Store Dashboard Product Detail
@endsection

@section('content')
 <!-- Section Content -->
          <div
            class="section-content section-dashboard-home"
            data-aos="fade-up"
          >
            <div class="container-fluid">
              <div class="dashboard-heading">
                <h2 class="dashboard-title">Shirup Marzan</h2>
                <p class="dashboard-subtitle">Product Details</p>
              </div>
              <div class="dashboard-content">
                <div class="row">
                  <div class="col-12">
                     @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('dashboard-product-update', $product->id) }}" method="POST" enctype="multipart/form-data" id="el_categories">
                      @csrf
                          <input name="users_id" type="hidden" value="{{ Auth::user()->id }}">
                          <div class="card">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label>Nama Produk</label>
                                    <input
                                      type="text"
                                      class="form-control"
                                      autofocus
                                      name="name"
                                      value="{{ $product->name }}"
                                    />
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label>Harga</label>
                                    <input
                                      type="number"
                                      name="price"
                                      class="form-control"
                                      autofocus
                                      name="price"
                                      value="{{ $product->price }}"
                                    />
                                  </div>
                                </div>
                                <div class="col-md-12">
                                  <div class="form-group">
                                    <label>Kategori : </label>
                                    <small>{{ $product->topCategory->name }} -> {{ $product->category->name }}</small>
                                    <select name="top_categories_id" class="form-control" id="top_categories_id" v-model="top_categories_id" v-if="top_categories">
                                      <option v-for="top_category in top_categories" :value="top_category.id">@{{top_category.name}}</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-12">
                                  <div class="form-group">
                                    <label for="categories_id">Sub Kategori :</label>
                                      <select name="categories_id" class="form-control" id="categories_id" v-model="categories_id" v-if="categories">
                                        <option v-for="category in categories" :value="category.id">@{{ category.name }}</option>
                                      </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                  <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" id="editor">{!! $product->description !!}</textarea>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col text-right">
                                  <button
                                    type="submit"
                                    class="btn btn-success px-5 btn-block"
                                  >
                                    Save Now
                                  </button>
                            </form>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-12">
                              <div class="card">
                                <div class="card-body">
                                  <div class="row">
                                    @foreach ($product->galleries as $gallery)
                                    <div class="col-md-4">
                                      <div class="gallery-container">
                                        <img
                                          src="{{ Storage::url($gallery->photos ?? '') }}"
                                          class="w-100"
                                        />
                                        <a href="{{ route('dashboard-product-gallery-delete', $gallery->id) }}" class="delete-gallery">
                                          <img src="/images/icon-delete.svg" />
                                        </a>
                                      </div>
                                    </div>
                                    @endforeach
                                    <div class="col-12">
                                      <form action="{{ route('dashboard-product-gallery-upload') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="products_id" value="{{ $product->id }}">
                                          <input
                                          type="file"
                                          name="photos"
                                          id="file"
                                          style="display: none"
                                          onchange="form.submit()"
                                        />
                                        <button
                                          type="button"
                                          class="btn btn-secondary btn-block mt-3"
                                          onclick="thisFileUpload()"
                                        >
                                          Add Photo
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
                </div>
              </div>
            </div>
          </div>
@endsection
@push('addon-script')
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="/vendor/vue/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    var locations = new Vue({
        el: "#el_categories",
        mounted() {
            AOS.init();
            this.getTopCategoriesData();
        },
        data: {
            top_categories: null,
            categories: null,
            top_categories_id: null,
            categories_id: null,
        },
        methods:{
            getTopCategoriesData(){
                var self = this;
                axios.get('{{ route('api-topcategories') }}')
                .then(function(resoponse){
                    self.top_categories = resoponse.data
                })
            },
            getCategoriesData(){
                var self = this;
                axios.get('{{ url('api/categories') }}/' + self.top_categories_id)
                .then(function(response){
                    self.categories = response.data
                })
            },
        },
        watch:{
            top_categories_id: function(val, oldval){
                this.categories_id = null,
                this.getCategoriesData();
            },
        }
    });
</script>
<script>
    CKEDITOR.replace('editor');
</script>   
@endpush