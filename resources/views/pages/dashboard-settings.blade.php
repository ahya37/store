@extends('layouts.dashboard')

@section('title')
    Store Setting
@endsection

@section('content')
 <!-- Section Content -->
          <div
            class="section-content section-dashboard-home"
            data-aos="fade-up"
          >
            <div class="container-fluid">
              <div class="dashboard-heading">
                <h2 class="dashboard-title">Pengaturan Toko</h2>
                <p class="dashboard-subtitle">
                  {{-- Make store that profitable --}}
                </p>
              </div>
              <div class="dashboard-content mt-4">
                <div class="row">
                  <div class="col-12">
                    <form action="{{ route('dashboard-settings-redirect','dashboard-settings-store') }}" method="POST" enctype="multipart/form-data">
                      @csrf 
                      <div class="card">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-7">
                              <div class="form-group">
                                <label>Nama Toko</label>
                                <input
                                  type="text"
                                  class="form-control"
                                  autofocus
                                  name="store_name"
                                  value="{{ $user->store_name }}"
                                />
                              </div>
                            </div>
                            <div class="col-md-5">
                              <div class="card">
                                @if (isset($idcard->id))
                                <div class="card-body">
                                  <label>KTP</label>
                                  <div class="gallery-container">
                                              <img
                                                src="{{ Storage::url($idcard->file ?? '') }}"
                                                class="w-100"
                                              />
                                              <a href="{{ route('dashboard-settings-idcard-delete', $idcard->id ?? '') }}" class="delete-gallery">
                                              <img src="/images/icon-delete.svg" />
                                            </a>
                                    </div>
                                </div>
                                @endif
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Toko</label>
                                <p class="text-muted">
                                  Apakah saat ini toko Anda buka?
                                </p>
                                <div
                                  class="custom-control custom-radio custom-control-inline"
                                >
                                  <input
                                    type="radio"
                                    class="custom-control-input"
                                    name="store_status"
                                    id="openStoreTrue"
                                    value="1"
                                    {{ $user->store_status == 1 ? 'checked' : '' }}
                                  />
                                  <label
                                    for="openStoreTrue"
                                    class="custom-control-label"
                                  >
                                    Buka
                                  </label>
                                </div>
                                <div
                                  class="custom-control custom-radio custom-control-inline"
                                >
                                  <input
                                    type="radio"
                                    class="custom-control-input"
                                    name="store_status"
                                    id="openStoreFalse"
                                    value="0"
                                    {{ $user->store_status == 0 || $user->store_status == NULL ? 'checked' : '' }}
                                  />
                                  <label
                                    for="openStoreFalse"
                                    class="custom-control-label"
                                  >
                                    Sementara Tutup
                                  </label>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col text-right">
                              <button
                                type="submit"
                                class="btn btn-success px-5"
                              >
                                Save Now
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                    <div class="row">
                      <div class="col-12">
                              <div class="card">
                                <div class="card-body">
                                        <div class="col-12">
                                          <form action="{{ route('dashboard-settings-idcard-store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="users_id" value="{{ Auth::user()->id }}">
                                            <input
                                              type="file"
                                              name="file"
                                              id="file"
                                              style="display: none"
                                              onchange="form.submit()"
                                            />

                                            @if (!$idcard)
                                              <button
                                                type="button"
                                                class="btn btn-secondary btn-block mt-3"
                                                onclick="thisFileUpload()"
                                              >
                                                Upload KTP
                                                </button>
                                            @endif
                                          </form>
                                        </div>
                                  </div>
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
      function thisFileUpload() {
        document.getElementById("file").click();
      }
</script>
@endpush