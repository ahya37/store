@extends('layouts.admin')

@section('title')
    Transaction
@endsection

@section('content')
 <!-- Section Content -->
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
                <h2 class="dashboard-title">Transaction</h2>
                <p class="dashboard-subtitle">List Of Transaction</p>
              </div>
              <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Kode</th>
                                                <th>Nama</th>
                                                <th>Harga</th>
                                                <th>Status</th>
                                                <th>Dibuat</th>
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.19/dataRender/datetime.js"></script>
<script>
 
var editor;

    var datatable = $('#crudTable').DataTable({
        processing: true,
        serverSide: true,
        ordering: true,
        ajax: {
            url: '{!! url()->current() !!}',
        },
        columns:[
            {data: 'id', name:'id'},
            {data: 'code', name:'code'},
            {data: 'user.name', name:'user.name'},
            {data: 'total_price', name:'total_price'},
            {data: 'transaction_status', name:'transaction_status'},
            {
                data: 'created_at', 
                name:'created_at',
            },
            {
                data: 'action', 
                name:'action',
                orderable: false,
                searchable: false,
                width: '15%'
            },
        ],
        columnDefs:[
            {
            targets:5, render:function(data){
                    return moment(data).format('DD/MM/YYYY, hh:mm:ss');
                }
            }
            ]
    });
</script>    
@endpush