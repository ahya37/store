@extends('layouts.admin')

@section('title')
    Tambah Orderan
@endsection

@section('content')
 <!-- Section Content -->
 <div class="section-content section-dashboard-home" data-aos="fade-up">
     <div class="container-fluid">
         <div class="dashboard-heading">
             <h2 class="dashboard-title">Tambah Orderan</h2>
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
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Tanggal</label>
                                                <input type="date" value="{{ date('Y-m-d') }}" name="date" class="form-control" required>
                                            </div>
                                        </div>
                                         <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Nama Pemesan</label>
                                                <input type="text" name="name" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>No. Hp</label>
                                                <input type="number" name="phone_number" class="form-control" required>
                                            </div>
                                        </div>
                                         <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Alamat Pengiriman</label>
                                                <textarea class="form-control" name="address" required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Metode Pembayaran</label>
                                                <select name="payment_metode" required class="form-control">
                                                    <option value="COD">COD</option>
                                                    <option value="TF">Transfer</option>
                                                </select>
                                            </div>
                                        </div>
                                         <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Deskripsi Pesanan</label>
                                                <textarea class="form-control" name="description_order" placeholder="Tuliskan pesanannya disini" required></textarea>
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="row">
                                       <div class="col text-right">
                                           <button type="submit" class="btn btn-success px-5">Simpan</button>
                                       </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
    </div>
</div>
@endsection
