@extends('layouts.admin')

@section('title')
    Antrian Orderan
@endsection

@section('content')
 <!-- Section Content -->
 <div class="section-content section-dashboard-home" data-aos="fade-up">
     <div class="container-fluid">
         <div class="dashboard-heading">
             <h2 class="dashboard-title">Antrian Orderan Hari Ini</h2>
             <p class="dashboard-subtitle"></p>
            </div>
            <div class="dashboard-content mt-4">
                  @include('layouts.message')
                <div class="row">
                    <div class="col-md-8">
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-12">
                                <form action="{{ route('order.index') }}" method="GET">
                                <div class="row">
                                        @csrf
                                        <div class="col-3">
                                            <input name="start" required type="date" class="form-control">
                                        </div>
                                         <div class="col-3">
                                            <input name="end" required type="date" class="form-control">
                                        </div>
                                        <div class="col-3">
                                            <button
                                            type="submit"
                                            name="submit"
                                            value="filter"
                                            class="btn btn-info"
                                            >Tampilkan</
                                            >
                                        </div>
                                        <div class="col-3">
                                            <button
                                            type="submit"
                                            name="submit"
                                            value="export"
                                            class="btn btn-success"
                                            >Excel</
                                            >
                                        </div>
                                    </div>
                                </form>
                            </div>
                            </div>
                         <div class="row mt-4" data-aos="fade-up">
                            @foreach ($order as $item)
                                <div class="col-12 col-sm-4 col-md-4 col-lg-3">
                                <a
                                    href="#"
                                    class="card card-dashboard-product d-block"
                                    data-target="#staticBackdrop{{ $item->id }}"
                                    data-toggle="modal"
                                >
                                    <div class="card-body">
                                    <img
                                        src="{{ asset('images/new-order.svg') }}"
                                        class="w-100 mb-2"
                                    />
                                    <div class="product-title text-center">{{ $item->name }}</div>
                                    <div class="product-category"></div>
                                    </div>
                                </a>
                                </div>
                            @endforeach
                            </div>
                    </div>
                </div>
              </div>
    </div>
</div>
@endsection

@push('prepend-script')
  <!-- Button trigger modal -->

<!-- Modal -->
@foreach ($order as $item)
<div class="modal fade" id="staticBackdrop{{ $item->id }}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">
         <strong>
             Detail Pesanan : {{ $item->name }}
         </strong>   
         <br>
         <small>
             Referensi Dari : {{ $item->users->name }}
         </small>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="alert alert-success">
              <div>
                  <div class="product-title">
                      <h6>
                          Tanggal
                      </h6>
                    </div>
                 <div class="product-subtitle">{{ date('d-m-Y', strtotime($item->date)) }}</div>
              </div>
              <div class="mt-4">
                  <div class="product-title">
                      <h6>
                          No.Hp
                      </h6>
                    </div>
                 <div class="product-subtitle">{{ $item->phone_number }}</div>
              </div>
              <div class="mt-4">
                  <div class="product-title">
                      <h6>
                          Metode Pembayaran
                      </h6>
                    </div>
                 <div class="product-subtitle">{{ $item->payment_metode }}</div>
              </div>
              <div class="mt-4">
                  <div class="product-title">
                      <h6>
                          Alamat Pengiriman
                      </h6>
                    </div>
                 <div class="product-subtitle">{{ $item->address }}</div>
              </div>
              
              <div class="mt-4">
                  <div class="product-title">
                      <h6>
                          Deskripsi Orderan
                      </h6>
                    </div>
                 <div class="product-subtitle">{{ $item->description_order }}</div>
              </div>
               <div class="mt-4 d-none">
                 <div class="product-subtitle">
                     <textarea id="myInput{{ $item->id }}">
                        Orderan:

                        Tanggal 
                        {{ date('d-m-Y', strtotime($item->date)) }}

                        Telpon
                        {{ $item->phone_number }}

                        Metode Pembayaran
                        {{ $item->payment_metode }}

                        Alamat
                        {{ $item->address }}

                        Deskripsi Orderan
                        {{ $item->description_order }}
                     </textarea>
                 </div>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="{{ $item->id }}" onclick="myFunction({{ $item->id }})" cust="{{ $item->name }}">Copy</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> 
@endforeach
@endpush

@push('addon-script')
<script>
    function myFunction(id) {
    /* Get the text field */
    var name     =  $('#'+id+'').attr("cust");
    var copyText = document.getElementById("myInput"+id);
    /* Select the text field */
    copyText.select();
    copyText.setSelectionRange(0, 99999); /* For mobile devices */
    /* Copy the text inside the text field */
    navigator.clipboard.writeText(copyText.value);
    /* Alert the copied text */
    alert("Copy :" + name);
    }
</script>
@endpush
