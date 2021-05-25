@extends('layouts.admin')

@section('title')
    Point
@endsection

@section('content')
 <!-- Section Content -->
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
                <h2 class="dashboard-title">Point</h2>
                <p class="dashboard-subtitle">Create New Point</p>
              </div>
              <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-12">
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
                                <form action="{{ route('point.store') }}" method="POST" enctype="multipart/form-data" id="point">
                                    @csrf
    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Member</label>
                                                <select name="users_id" id="users_id"  class="form-control" v-model="users_id" v-if="users">
                                                    <option v-for="user in users" :value="user.id">@{{ user.name }}</option>    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Nominal Transaksi</label>
                                                <input type="number" name="nominal" class="form-control" required>
                                            </div>
                                        </div>
                                        
                                    </div>
    
                                    <div class="row">
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
<script src="/vendor/vue/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    var point = new Vue({
        el : "#point",
        mounted(){
            AOS.init();
            this.getDataUsers();
        },
        data:{
            users: null,
            users_id: null,
        },
        methods:{
            getDataUsers(){
                var self = this;
                axios.get('{{ route('api-users') }}')
                .then(function(response){
                    self.users = response.data
                })
            }
        }
    });
</script>
@endpush
