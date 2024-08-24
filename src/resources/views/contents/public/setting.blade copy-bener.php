@extends('layouts.public.app')

@section('titlebar')
  Setting
@endsection

@section('content-header')
  <div class="content-header">
    <div class="container">
      <div class="row mb-2">
        <div class="col-sm-12">
          <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><strong>{{ Auth::user()->fullname }}</strong></li>
          </ol>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('content')
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
          <div class="card w-100">
            <div class="card-body box-profile">
              <h3 class="profile-username text-center">{{ Auth::user()->fullname }}</h3>
              <p class="text-muted text-center">{{ Auth::user()->email }}</p>
            </div>
          </div>


          <div class="card w-100">

            <div id="accordion">
              <div class="card card-light">
                <div class="card-header">
                  <h4 class="card-title w-100">
                    <a class="d-block w-100" data-toggle="collapse" href="#collapseOne" aria-expanded="true">
                      Pembelian
                    </a>
                  </h4>
                </div>
                <div id="collapseOne" class="collapse show" data-parent="#accordion">
                  <div class="card-body">
                    <ul class="list-group">
                      <a href="www.google.com">
                        <li class="list-group-item-light d-flex justify-content-between align-items-center">
                          Menunggu Pembayaran
                        </li>
                      </a>
                      <a href="www.yahoo.com">
                        <li class="list-group-item-light d-flex justify-content-between align-items-center">
                          Pembelian
                        </li>
                      </a>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="card card-light">
                <div class="card-header">
                  <h4 class="card-title w-100">
                    <a class="d-block w-100" data-toggle="collapse" href="#collapseTwo">
                      Transaksi
                    </a>
                  </h4>
                </div>
                <div id="collapseTwo" class="collapse show" data-parent="#accordion">
                  <div class="card-body">
                    <ul class="list-group">
                      <a href="www.google.com">
                        <li class="list-group-item-light d-flex justify-content-between align-items-center">
                          Menunggu Konfirmasi
                        </li>
                      </a>
                      <a href="www.yahoo.com">
                        <li class="list-group-item-light d-flex justify-content-between align-items-center">
                          Pesanan Diproses
                        </li>
                      </a>
                      <a href="www.yahoo.com">
                        <li class="list-group-item-light d-flex justify-content-between align-items-center">
                          Sedang Dikirim
                        </li>
                      </a>
                      <a href="www.yahoo.com">
                        <li class="list-group-item-light d-flex justify-content-between align-items-center">
                          Sampai Tujuan
                        </li>
                      </a>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

          </div>

        </div>

        <div class="col-12 col-sm-12 col-md-8 col-lg-8">
          <div class="card card-success card-outline card-outline-tabs w-100">
            <div class="card-header p-0 border-bottom-0">
              <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="custom-tabs-four-profile-tab" data-toggle="pill"
                    href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile"
                    aria-selected="false">Profile</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-four-settings-tab" data-toggle="pill"
                    href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings"
                    aria-selected="false">Pengiriman</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-four-password-tab" data-toggle="pill"
                    href="#custom-tabs-four-password" role="tab" aria-controls="custom-tabs-four-password"
                    aria-selected="false">Keamanan</a>
                </li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content" id="custom-tabs-four-tabContent">
                <div class="tab-pane active show" id="custom-tabs-four-profile" role="tabpanel"
                  aria-labelledby="custom-tabs-four-profile-tab">
                  <form action="{{ route('public.user.profile.update') }}" method="POST">
                    @csrf
                    <div class="card-body">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Nama Lengkap <span style="color: red">*</span></label>
                        <input type="text" name="fullname" class="form-control" placeholder="Masukkan Nama Lengkap"
                          value="{{ Auth::user()->fullname }}" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Email address <span style="color: red">*</span></label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email"
                          value="{{ Auth::user()->email }}" required>
                      </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                      <button type="submit" class="btn btn-login">Simpan</button>
                    </div>
                  </form>
                </div>

                <div class="tab-pane fade" id="custom-tabs-four-settings" role="tabpanel"
                  aria-labelledby="custom-tabs-four-settings-tab">
                  <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addressModal">
                    Kelola Alamat Pengiriman
                  </button>
                  @foreach ($shippings as $shipping)
                    <div class="card mb-3">
                      <div class="card-body">
                        <form action="{{ route('public.user.shipping.update', $shipping->id) }}" method="POST">
                          @csrf
                          @method('PUT')
                          <div class="form-group">
                            <label for="maps">Pin Location</label>
                            <input name="maps" class="form-control" placeholder="Titik Google Maps"
                              value="{{ $shipping->maps }}">
                          </div>
                          <div class="form-group">
                            <label for="receiver_name">Nama Penerima <span style="color: red">*</span></label>
                            <input name="receiver_name" class="form-control" placeholder="Masukkan Nama Lengkap"
                              value="{{ $shipping->receiver_name }}" required>
                          </div>
                          <div class="form-group">
                            <label for="phone">Nomor HP <span style="color: red">*</span></label>
                            <input name="phone" class="form-control" placeholder="Masukkan Nomor HP"
                              value="{{ $shipping->phone }}" required>
                          </div>
                          <div class="form-group">
                            <label for="tag">Label <span style="color: red">*</span></label>
                            <input name="tag" class="form-control" placeholder="Rumah / Kantor / Sekolah"
                              value="{{ $shipping->tag }}" required>
                          </div>
                          <div class="form-group">
                            <label for="address">Alamat Lengkap <span style="color: red">*</span></label>
                            <textarea class="form-control h-40" rows="3" style="resize: none" name="address" required>{{ $shipping->address }}</textarea>
                          </div>
                          <div class="form-group">
                            <label for="notes">Notes</label>
                            <input type="text" class="form-control" name="notes" value="{{ $shipping->notes }}"
                              placeholder="catatan untuk kurir (opsional)">
                          </div>
                          <div class="card-footer">
                            <button type="submit" class="btn btn-login">Simpan</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  @endforeach
                </div>

                <div class="tab-pane fade" id="custom-tabs-four-password" role="tabpanel"
                  aria-labelledby="custom-tabs-four-password-tab">
                  <form action="{{ route('public.user.password.update') }}" method="POST">
                    @csrf
                    <div class="card-body">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Password Lama <span style="color: red">*</span></label>
                        <input type="password" name="oldPassword" class="form-control" id="oldPassword"
                          placeholder="Password Lama" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Password Baru <span style="color: red">*</span></label>
                        <input type="password" name="newPassword" class="form-control" id="newPassword"
                          placeholder="Password Baru" required>
                      </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                      <button type="submit" class="btn btn-login">Simpan</button>
                    </div>
                  </form>
                </div>
              </div>

            </div>
          </div>
        </div>

      </div>

    </div>
    </div>
  </section>

  <!-- Shipping Addresses Modal -->
  <div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="addressModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addressModalLabel">Kelola Alamat Pengiriman</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <ul class="list-group">
            @foreach ($shippings as $address)
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                  <strong>{{ $address->receiver_name }}</strong> <br>
                  {{ $address->address }}, {{ $address->city }} <br>
                  {{ $address->phone }}
                </div>
                <div>
                  <button class="btn btn-sm btn-primary" data-toggle="modal"
                    data-target="#editAddressModal-{{ $address->id }}">Edit</button>
                  <form action="{{ route('public.user.shipping.destroy', $address->id) }}" method="POST"
                    class="d-inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                  </form>
                </div>
              </li>

              <!-- Edit Address Modal -->
              <div class="modal fade" id="editAddressModal-{{ $address->id }}" tabindex="-1" role="dialog"
                aria-labelledby="editAddressModalLabel-{{ $address->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="editAddressModalLabel-{{ $address->id }}">Edit Alamat</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form action="{{ route('public.user.shipping.update', $address->id) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="modal-body">
                        <div class="form-group">
                          <label for="maps-{{ $address->id }}">Pin Location</label>
                          <input name="maps" class="form-control" id="maps-{{ $address->id }}"
                            placeholder="Titik Google Maps" value="{{ $address->maps }}">
                        </div>
                        <div class="form-group">
                          <label for="receiver_name-{{ $address->id }}">Nama Penerima</label>
                          <input name="receiver_name" class="form-control" id="receiver_name-{{ $address->id }}"
                            placeholder="Masukkan Nama Lengkap" value="{{ $address->receiver_name }}" required>
                        </div>
                        <div class="form-group">
                          <label for="phone-{{ $address->id }}">Nomor Telepon</label>
                          <input name="phone" class="form-control" id="phone-{{ $address->id }}"
                            placeholder="Masukkan Nomor Telepon" value="{{ $address->phone }}" required>
                        </div>
                        <div class="form-group">
                          <label for="address-{{ $address->id }}">Alamat Lengkap</label>
                          <input name="address" class="form-control" id="address-{{ $address->id }}"
                            placeholder="Masukkan Alamat Lengkap" value="{{ $address->address }}" required>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            @endforeach
          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addAddressModal">Tambah
            Alamat Baru</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Address Modal -->
  <div class="modal fade" id="addAddressModal" tabindex="-1" role="dialog" aria-labelledby="addAddressModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addAddressModalLabel">Tambah Alamat Baru</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('public.user.shipping.store') }}" method="POST">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="maps">Pin Location</label>
              <input name="maps" class="form-control" id="maps" placeholder="Titik Google Maps">
            </div>
            <div class="form-group">
              <label for="receiver_name">Nama Penerima</label>
              <input name="receiver_name" class="form-control" id="receiver_name" placeholder="Masukkan Nama Lengkap"
                required>
            </div>
            <div class="form-group">
              <label for="phone">Nomor Telepon</label>
              <input name="phone" class="form-control" id="phone" placeholder="Masukkan Nomor Telepon" required>
            </div>
            <div class="form-group">
              <label for="address">Alamat Lengkap</label>
              <input name="address" class="form-control" id="address" placeholder="Masukkan Alamat Lengkap"
                required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-success">Tambah Alamat</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('javascript')
  <script></script>
@endsection
