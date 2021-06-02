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
            
            {{-- <form action="{{ route('checkout') }}" method="POST" enctype="multipart/form-data" id="locations"> --}}
                
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
                   
                </div>
                <div class="col-4 col-md-3">
                   
                </div>
                <div class="col-4 col-md-2">
                   
                </div>
                <div class="col-4 col-md-2">
                    <div class="product-title text-success">Rp {{ $globalFunction->formatRupiah($totalPrice) }}</div>
                    <div class="product-subtitle">Total</div>
                </div>
                <div class="col-8 col-md-3">
                    <a target="_blank"
                   href="https://api.whatsapp.com/send?phone=6287872413014&text=Halo%20CS%20Percikanshop,%20saya%20pesan%20produk :%0A @foreach ($carts as $item ){{'-'.$item->product->name }}[{{'Qty: ' .$item->qty }}],%0A @endforeach %0A*Form Pemesan*%0ANama:{{ Auth::user()->name }}%0AAlamat:{{ Auth::user()->address_one }}%0ATelp:{{ Auth::user()->phone_number }}%0ATotal:Rp.%20{{ $globalFunction->formatRupiah($totalPrice) }} "
                    class="btn btn-success mt-4 px-4 btn-block"
                    >
                    Pesan
                    </a>
                </div>
                </div>
            {{-- </form> --}}
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
    <script>
        
        function myFunction() {
                location.replace("https://api.whatsapp.com/send?phone=6287872413014&text=Halo%20CS%20Percikanshop,%20saya%20berminat%20dengan%20produk :%0A%0A%0A%0A*Form Pemesan*%0ANama:%0AAlamat:%0ATelp:%0AJumlah Pembelian")
            
        }
    </script>
    @endpush