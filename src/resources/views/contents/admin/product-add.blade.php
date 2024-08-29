@extends('layouts.admin.app')

@section('titlebar', 'Edit Produk')

@section('stylesheet')
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}" />
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet"
    href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}" />
@endsection

@section('content')
  <div class="container">
    <h5><strong>Tambah Produk</strong></h5>
    <form action="{{ route('admin.product.store') }}" method="POST">
      @csrf
      <div class="card">
        <div class="card-header">
          <div class="card-title">
            <h5>Informasi Produk</h5>
          </div>
        </div>
        <div class="card-body">
          <!-- Form fields for the product -->


          <div class="form-group">
            <label for="title">Judul</label>
            <input type="text" class="form-control" id="title" name="title" required>
          </div>

          <div class="form-group">
            <label for="exampleInputFile">Pilih Gambar</label>
            <div class="input-group">
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="filename_img" name="filename_img" />
                <label class="custom-file-label" for="exampleInputFile">Gambar</label>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="category">Kategori</label>
            <select class="form-control" id="id_category" name="id_category" required>
              @foreach ($categories as $category)
                <option value="{{ $category->id }}">
                  {{ $category->name }}</option>
              @endforeach
            </select>
          </div>

        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <div class="card-title">
            <h5>Informasi Jual</h5>
          </div>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label for="display_price">Harga Asli (Tanpa Diskon)</label>
            <input type="number" class="form-control" id="original_price" name="original_price" required>
          </div>
          <div class="form-group">
            <label for="display_price">Harga Display</label>
            <input type="number" class="form-control" id="display_price" name="display_price" disabled>
          </div>
          <div class="form-group">
            <label for="display_price">Diskon</label>
            <input type="number" class="form-control" id="discount" name="discount" required>
          </div>
          <div class="form-group">
            <label for="display_price">Stock Tersedia</label>
            <input type="number" class="form-control" id="stocks" name="stocks" required>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <div class="card-title">
            <h5>Informasi Rilisan</h5>
          </div>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label for="display_price">Penulis</label>
            <input type="text" class="form-control" id="author" name="author" required>
          </div>
          <div class="form-group">
            <label for="display_price">Penerbit</label>
            <input type="text" class="form-control" id="publisher" name="publisher">
          </div>
          <div class="form-group">
            <label>Date:</label>
            <div class="input-group date" id="reservationdate" data-target-input="nearest">
              <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" />
              <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                <div class="input-group-text">
                  <i class="fa fa-calendar"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <div class="card-title">
            <h5>Detail Produk</h5>
          </div>
        </div>
        <div class="card-body">


          <div class="form-group">
            <label for="display_price">SKU</label>
            <input type="text" class="form-control" id="sku" name="sku" required>
          </div>

          <div class="form-group">
            <label for="display_price">ISBN</label>
            <input type="text" class="form-control" id="isbn" name="isbn" required>
          </div>

          <div class="form-group">
            <label for="display_price">Bahasa</label>
            <select class="form-control" id="lang" name="lang" required>
              <option value="Billingual">Billingual</option>
              <option value="English">English</option>
              <option value="Indonesia">Indonesia</option>
            </select>
          </div>

          <div class="form-group">
            <label for="display_price">Jumlah Halaman</label>
            <input type="text" class="form-control" id="pages" name="pages" required>
          </div>

        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
      <!-- Add other fields as necessary -->
    </form>
  </div>
@endsection

@section('javascript')
  <script>
    $("#reservationdate").datetimepicker({
      format: "YYYY-MM-DD", // Match the format of $product->release_at
    });
  </script>
@endsection

@section('init')
  <!-- InputMask -->
  <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>

  <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

@endsection
