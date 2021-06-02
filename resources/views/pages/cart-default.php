    @extends('layouts.app')

    @section('title')
        Store Cart Page
    @endsection

    @section('content')
    <div class="page-content page-cart">
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
                    <li class="breadcrumb-item active">Keranjang</li>
                    </ol>
                </nav>
                </div>
            </div>
            </div>
        </section>

        <section class="store-cart">
            <div class="container">
                <div class="col-12">
                    @if (Session::has('success'))
                            <div class="alert alert-success">
                                <p>{{ Session::get('success') }}</p>
                            </div>
                    @endif
                </div>
            <div class="row" data-aos="fade-up" data-aos-delay="100">
                <div class="col-12 table-responsive">
                <table class="table table-borderless table-cart">
                    <thead>
                    <td>Gambar</td>
                    <td>Produk &amp; Penjual</td>
                    <td>Harga</td>
                    <td>Qty</td>
                    <td>Menu</td>
                    </thead>
                    <tbody>
                        @php $totalPrice = 0 @endphp
                        @foreach ($carts as $cart)
                        <tr>
                            <td style="width: 15%">
                                @if($cart->product->galleries)
                                <img
                                    src="{{ Storage::url($cart->product->galleries->first()->photos) }}"
                                    class="cart-image w-100"
                                />  
                                @endif
                            </td>
                            <td style="width: 35%">
                            <div class="product-title">{{ $cart->product->name }}
                            <div class="product-subtitle">{{ $cart->product->user->store_name }}</div>
                            </td>
                            <td style="width: 35%">
                            <div class="product-title">{{ 'Rp. '. $globalFunction->formatRupiah($cart->product->price) }}</div>
                            {{-- <div class="product-subtitle">USD</div> --}}
                            
                            </td>
                            <td style="width: 20%">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <form action="{{ route('cart-update-min', $cart->id) }}" method="POST">
                                                @csrf
                                                <button name="button" value="minus" onclick="var result = document.getElementById('sst{{ $cart->product->id }}').submit(); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
                                                    class="btn btn-sm btn-secondary">
                                                    -
                                                </button>
                                    </div>
                                            <input type="text" min="0" value="{{ $cart->qty }}" readonly name="qty" id="sst{{ $cart->product->id }}" class="form-control form-control-sm text-center">
                                    <div class="input-group-append">
                                            <button name="button" value="plus" onclick="var result = document.getElementById('sst{{ $cart->product->id }}').submit(); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                                                class="btn btn-sm btn-secondary">
                                                +
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                            <td style="width: 20%">
                                <form action="{{ route('cart-delete', $cart->id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-remove-cart">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @php $totalPrice += $cart->product->price * $cart->qty @endphp
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
            <div class="row" data-aos="fade-up" data-aos-delay="150">
                <div class="col-12">
                <hr />
                </div>
                <div class="col-12">
                <h2 class="mb-4">Shipping Details</h2>
                </div>
            </div>
            <form action="{{ route('checkout') }}" method="POST" enctype="multipart/form-data" id="locations">
                @csrf
                <input type="hidden" name="total_price" value="{{ $totalPrice }}">
                <div class="row mb-2" data-aos="fade-up" data-aos-delay="200" id="locations">
                <div class="col-md-6">
                    <div class="form-group">
                    <label for="provinces_id">Provinsi</label>
                    <select name="provinces_id" id="provinces_id" class="form-control" v-model="provinces_id" v-if="provinces">
                        <option v-for="province in provinces" :value="province.id">@{{ province.name }}</option>
                    </select>
                    <select v-else class="form-control"></select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    <label for="regencies_id">Kab / Kota</label>
                    <select name="regencies_id" id="regencies_id" class="form-control" v-model="regencies_id" v-if="regencies">
                        <option v-for="regency in regencies" :value="regency.id">@{{ regency.name }}</option>
                    </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    <label for="zip_code">Kode Pos</label>
                    <input
                        type="text"
                        class="form-control"
                        id="zip_code"
                        name="zip_code"
                        value="{{ $cart->user->zip_code ?? '' }}"
                    />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    <label for="country">Negara</label>
                    <input
                        type="text"
                        class="form-control"
                        id="country"
                        name="country"
                        value="Indonesia"
                    />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    <label for="address_one">Alamat Lengkap</label>
                    <textarea
                        class="form-control"
                        id="address_one"
                        name="address_one"
                    >
                    {{ $cart->user->address_one ?? '' }}
                    </textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    <label for="phone_number">No. Hp</label>
                    <input
                        type="text"
                        class="form-control"
                        id="phone_number"
                        name="phone_number"
                        value="{{ $cart->user->phone_number ?? ''}}"
                    />
                    </div>
                </div>
                </div>
                <div class="row" data-aos="fade-up" data-aos-delay="150">
                <div class="col-12">
                    <hr />
                </div>
                <div class="col-12">
                    <h2 class="mb-1">Informasi Pembayaran</h2>
                </div>
                </div>
                <div class="row" data-aos="fade-up" data-aos-delay="200">
                <div class="col-4 col-md-2">
                    {{-- <div class="product-title">$0</div>
                    <div class="product-subtitle">Country Tax</div> --}}
                </div>
                <div class="col-4 col-md-3">
                    {{-- <div class="product-title">Rp {{ $globalFunction->formatRupiah($totalPrice) }}</div>
                    <div class="product-subtitle">Total</div> --}}
                </div>
                <div class="col-4 col-md-2">
                    {{-- <div class="product-title">Rp 15.000</div>
                    <div class="product-subtitle">Ongkir</div> --}}
                </div>
                <div class="col-4 col-md-2">
                    <div class="product-title text-success">Rp {{ $globalFunction->formatRupiah($totalPrice) }}</div>
                    <div class="product-subtitle">Total Pembayaran</div>
                </div>
                <div class="col-8 col-md-3">
                    <button
                    type="submit"
                    class="btn btn-success mt-4 px-4 btn-block"
                    >
                    Pesan
                    </button>
                </div>
                </div>
            </form>
            </div>
        </section>
        </div>
    @endsection

    @push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        var locations = new Vue({
            el: "#locations",
            mounted() {
                AOS.init();
                this.getProvincesData();
            },
            data: {
                provinces: null,
                regencies: null,
                provinces_id: null,
                regencies_id: null,
            },
            methods: {
                getProvincesData(){
                    var self = this;
                    axios.get('{{ route('api-provinces') }}')
                    .then(function(response){
                        self.provinces = response.data
                    })
                },
                getRegenciesData(){
                    var self = this;
                    axios.get('{{ url('api/regencies') }}/' + self.provinces_id)
                    .then(function(response){
                        self.regencies = response.data
                    })

                },
            },
            watch:{
                provinces_id: function(val,oldval){
                    this.regencies_id = null;
                    this.getRegenciesData();
                },
            }
        });
    </script>
    @endpush