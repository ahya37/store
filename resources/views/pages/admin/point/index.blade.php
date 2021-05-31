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
                                <a href="{{ route('point-excel-format-download') }}" class="btn btn-sm btn-secondary mb-3">
                                    Download Format Excel
                                </a>
                                <button class="btn btn-sm btn-success mb-3" data-toggle="modal" data-target="#exampleModal">
                                    Upload Excel
                                </button>
                                 <button class="btn btn-sm btn-danger mb-3" onclick="deteleConfirmAll();">
                                    Hapus Semua
                                </button>
                                <form id="delete-all" action="{{ route('point-delete-all') }}" method="POST" class="d-none">
                                @csrf
                                </form>
                                <div class="table-responsive">
                                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nama</th>
                                                <th>Telpon</th>
                                                <th>Jumlah Poin</th>
                                                <th>Nominal Poin (Rp)</th>
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
                data: 'action', 
                name:'action',
                orderable: false,
                searchable: false,
                width: '15%',
            }
        ]
    });

function deteleConfirm(id){
		var user = $('#'+id+'').attr("user");
	  swal({
		title: "Hapus Poin " +user+ "?",
		// text: "Setelah dihapus Anda tidak dapat mengembalikan data ini!",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	  }).then((willDetele)=> {
		if (willDetele) {
		  $.ajax({
			url: "{{ url('admin/point/destroy') }}" + '/' +id,
			type: "GET",
			data: {'_method' : 'DELETE'},
			success: function(data){
			  swal("Poin berhasil dihapus!", {
				icon: "success",
			  }).then(function(){
				window.location.reload();
			  });
			},
			error : function(){
			  swal({
				title: 'Gagal Menghapus',
				icon:'error',
				timer: '1500'
			  });
			}
		  });
		}
	  });
	}

  function deteleConfirmAll(){
	  swal({
		title: "Hapus Semua Poin ?",
		// text: "Setelah dihapus Anda tidak dapat mengembalikan data ini!",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	  }).then((willDetele)=> {
		if (willDetele) {
		  $.ajax({
			url: "{{ route('point-delete-all') }}",
			type: "GET",
			data: {'_method' : 'DELETE'},
			success: function(data){
			  swal("Poin berhasil dihapus!", {
				icon: "success",
			  }).then(function(){
				window.location.reload();
			  });
			},
			error : function(){
			  swal({
				title: 'Gagal Menghapus',
				icon:'error',
				timer: '1500'
			  });
			}
		  });
		}
	  });
	}
</script>    
@endpush