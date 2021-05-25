@extends('layouts.admin')

@section('title')
    Exchange Point
@endsection

@section('content')
 <!-- Section Content -->
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
                <h2 class="dashboard-title">Tukar Point - {{ $point->user->name }}</h2>
              </div>
              <div class="dashboard-content">
                <div class="row mt-2">
                    <div class="col-md-12 mt-4">
                        @if (Session::has('error'))
                            <div class="alert alert-danger">
                                <p>{{ Session::get('error') }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <div class="card mt-4">
                            <div class="card-body">
                                <form action="{{ route('point-exchange-store', $point->id) }}" method="POST" enctype="multipart/form-data" id="point">
                                    @csrf
                                    <input type="hidden" name="users_id" value="{{ $point->users_id }}"> 
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-hover scroll-horizontal-vertical w-100" id="example">
                                            <thead>
                                                <tr>
                                                    <th>Pilih</th>
                                                    <th>Barang</th>
                                                    <th>Poin</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($products as $item)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="products_id[]" value="{{ $item->id }}">
                                                        </td>
                                                        <td>
                                                            {{ $item->name }}
                                                        </td>
                                                        <td>
                                                            {{ $globalFunction->formatRupiah($item->point) }}
                                                            <input type="hidden" name="price[]" value="{{ $item->price }}">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                    </table>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                       <div class="col text-right">
                                           <button type="submit" class="btn btn-success px-5">Save Now</button>
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
@push('addon-script')
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    } );
</script>
@endpush