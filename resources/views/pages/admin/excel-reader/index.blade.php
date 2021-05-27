@extends('layouts.admin')

@section('title')
    Point
@endsection

@section('content')
 <!-- Section Content -->
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
                <h2 class="dashboard-title">Point Member</h2>
                <p class="dashboard-subtitle">List Of Point Member</p>
              </div>
              <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-12">
                        @if (Session::has('success'))
                            <div class="alert alert-success">
                                <p>{{ Session::get('success') }}</p>
                            </div>
                        @endif
                        <div class="card">
                            <form action="{{ route('point-upload-excel-save') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                   <div class="alert alert-primary alert-dismissible" role="alert">
                                        Silahkan periksa kembali data poin dibawah ini, jika dirasa sudah sesuai maka klik
                                        <button type="submit" class="btn btn-sm btn-success">
                                            Simpan
                                        </button>
                                        <a href="{{ route('point.index') }}" type="submit" class="btn btn-sm btn-danger">
                                            Batal
                                        </a>
                                   </div>
                                   <div class="alert alert-warning alert-dismissible" role="alert">
                                        Total Data {{ $countData }}
                                        <input type="hidden" name="countinsert" value="{{ $countData }}">
                                   </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>ID</th>
                                                        <th>Nama</th>
                                                        <th>Nominal Transaksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @for ($i=2; $i<=$jumlahBaris; $i++)
                                                    @if($datapoint->val($i, 1) != null)
                                                        <tr role="row" class="odd">
                                                            <td>{{ $no++ }}</td>
                                                            <td tabindex="0" class="sorting_1"> {{$datapoint->val($i, 1)}}
                                                                <input type="hidden" name="users_id[]" value="{{$datapoint->val($i, 1)}}">
                                                            </td>
                                                            <td tabindex="0" class="sorting_1">{{$datapoint->val($i, 2)}}
                                                                <input type="hidden" name="name[]" value="{{$datapoint->val($i, 2)}}">
                                                            </td>
                                                            <td tabindex="0" class="sorting_1">{{$datapoint->val($i, 3)}}
                                                                <input type="hidden" name="amount[]" value="{{$datapoint->val($i, 3)}}">
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
              </div>
    </div>
</div>
@endsection
