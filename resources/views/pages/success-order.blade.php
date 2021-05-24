@extends('layouts.success')

@section('title')
    Store Success Page
@endsection

@section('content')
 <div class="page-content page-success">
      <div class="section-success" data-aos="zoom-in">
        <div class="container">
          <div class="row align-items-center row-align justify-content-center">
            <div class="col-lg-6 text-center">
              <img src="/images/success.svg" class="mb-4" />
              <h2>Pemesanan Berhasil !</h2>
              @if($nominal_point != 0)
              <h4>Selemat anda Mendapatkan Point {{ $nominal_point }} senilai Rp. {{ $amount_point }}</h4>
              @endif
              <div>
                <a href="{{ route('dashboard') }}" class="btn btn-success w-50 mt-4"
                  >Lanjut Pembayaran</a
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection