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
                            <div class="card-body">
                                <a href="{{ route('point.create') }}" class="btn btn-sm btn-primary mb-3">
                                    + Tambah Poin Baru
                                </a>
                                <button class="btn btn-sm btn-success mb-3" data-toggle="modal" data-target="#exampleModal">
                                    Upload Excel
                                </button>
                                <div class="table-responsive">
                                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nama</th>
                                                <th>Telpon</th>
                                                <th>Jumlah Poin</th>
                                                <th>Nominal Poin (Rp)</th>
                                                <th></th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
    </div>
</div>
@endsection
@push('prepend-script')
{{-- modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Poin</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('point-upload-excel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file">
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-success">Upload</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
{{-- end modal --}}
@endpush

@push('addon-script')
<script>
    var datatable = $('#crudTable').DataTable({
        processing: true,
        serverSide: true,
        ordering: true,
        ajax: {
            url: '{!! url()->current() !!}',
        },
        columns:[
            {data: 'id', name:'id'},
            {data: 'user.name', name:'user.name'},
            {data: 'user.phone_number', name:'user.phone_number'},
            {data: 'nominal_point', name:'nominal_point'},
            {data: 'amount_point', name:'amount_point'},
            {
                data: 'exchange',
                name: 'exchange'
            },
            {
                data: 'action', 
                name:'action',
                orderable: false,
                searchable: false,
                width: '15%',
            }
        ]
    });
</script>    
@endpush