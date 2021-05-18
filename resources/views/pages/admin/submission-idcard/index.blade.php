@extends('layouts.admin')

@section('title')
    Submission Idcard
@endsection

@section('content')
 <!-- Section Content -->
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
                <h2 class="dashboard-title">Pengajuan</h2>
                <p class="dashboard-subtitle">Daftar Pengajuan KTP</p>
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
                                <div class="table-responsive">
                                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nama</th>
                                                <th>KTP</th>
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
            {data: 'file', name:'file'},
            {
                data: 'action', 
                name:'action',
                orderable: false,
                searchable: false,
                width: '15%'
            },
        ]
    });
</script>    
@endpush