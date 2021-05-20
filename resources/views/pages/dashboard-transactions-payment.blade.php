@extends('layouts.dashboard')

@section('title')
    Store Payment
@endsection

@section('content')
 <!-- Section Content -->
          <div
            class="section-content section-dashboard-home"
            data-aos="fade-up"
          >
            <div class="container-fluid">
              <div class="dashboard-heading">
                <h2 class="dashboard-title">Pembayaran {{'#'. $transaction->code }}</h2>
                <p class="dashboard-subtitle">
                  {{-- Make store that profitable --}}
                </p>
              </div>
              <div class="dashboard-content mt-4">
                <div class="row">
                  <div class="col-12">
                    <form action="{{ route('dashboard-payment-store') }}" method="POST" enctype="multipart/form-data" id="elpayments">
                      @csrf 
                      <div class="card">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <input type="hidden" name="users_id" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="transactions_id" value="{{ $transaction->id }}">
                                <input type="hidden" name="code" value="{{ $transaction->code }}">
                                <label>Bank</label>
                                <select name="banks_id" id="banks_id" class="form-control" v-model="banks_id" v-if="banks">
                                    <option v-for="bank in banks" :value="bank.id">@{{ bank.name }} : @{{ bank.bank_number }} a/n @{{ bank.owner }}</option>
                                </select>
                                <select v-else class="form-control"></select>
                              </div>
                            </div>
                            <div class="col-md-7">
                              <div class="form-group">
                                <label>Bukti Pembayaran</label>
                                <input type="file" name="image" class="form-control" required>
                              </div>
                            </div>
                            <div class="col-md-7">
                              <div class="form-group">
                                <label>Nominal</label>
                                <input type="number" name="amount" class="form-control" required>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col text-right">
                              <button
                                type="submit"
                                class="btn btn-success px-5"
                              >
                                Simpan
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
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
  var payments = new Vue({
    el: '#elpayments',
    mounted(){
      AOS.init();
      this.getBanksData();
    },
    data:{
      banks: null,
      banks_id: null
    },
    methods:{
      getBanksData(){
        var self = this;
        axios.get('{{ route('api-banks') }}')
        .then(function(response){
          self.banks = response.data
        })
      }
    }
  })
</script>
@endpush