@extends('layouts.admin')

@section('title')
    Tambah Orderan
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
                                        <div class="col-6">
                                            <input name="date" type="date" class="form-control">
                                        </div>
                                        <div class="col-6">
                                            <button
                                            type="submit"
                                            class="btn btn-success"
                                            >Tampilkan</
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
                                    <div class="product-title">{{ $item->name }}</div>
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
        <h5 class="modal-title" id="staticBackdropLabel">Detail Pesanan : {{ $item->name }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <table>
              <tr>
                  <td>Tanggal</td><td>:</td><td>{{ date('d-m-Y', strtotime($item->date)) }}</td>
              </tr>
              <tr>
                  <td>No.Hp</td><td>:</td><td>{{ $item->phone_number }}</td>
              </tr>
              <tr>
                  <td>Metode Pembayaran</td><td>:</td><td>{{ $item->payment_metode }}</td>
                </tr>
                <tr>
                    <td>Alamat</td><td>:</td><td>{{ $item->address }}</td>
                </tr>
                <tr>
                    <td>Deskripsi Orderan</td><td>:</td><td>{{ $item->description_order }}</td>
                </tr>
          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        {{-- <button type="button" class="btn btn-primary">Selesai</button> --}}
      </div>
    </div>
  </div>
</div> 
@endforeach
@endpush
