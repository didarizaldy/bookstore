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
    <h5><strong>Edit Produk</strong></h5>
    <form action="{{ route('admin.product.update', ['id' => $product->id]) }}" method="POST">
      @csrf
      @method('PUT')
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
            <input type="text" class="form-control" id="title" name="title" value="{{ $product->title }}"
              required>
          </div>

          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="exampleInputFile">Pilih Gambar</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="exampleInputFile" />
                    <label class="custom-file-label" for="exampleInputFile">Gambar</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <img class="img-thumbnail rounded float-right" width="30%"
                src="{{ asset('assets/img/cover-book/' . $product->filename_img) }}" alt="{{ $product->title }}">
            </div>
          </div>

          <div class="form-group">
            <label for="category">Kategori</label>
            <select class="form-control" id="id_category" name="id_category" required>
              @foreach ($showCategories as $category)
                <option value="{{ $category->id }}" {{ $product->id_category == $category->id ? 'selected' : '' }}>
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
            <input type="number" class="form-control" id="original_price" name="original_price"
              value="{{ $product->original_price }}" required>
          </div>
          <div class="form-group">
            <label for="display_price">Harga Display</label>
            <input type="number" class="form-control" id="display_price" name="display_price"
              value="{{ $product->display_price }}" disabled>
          </div>
          <div class="form-group">
            <label for="display_price">Diskon</label>
            <input type="number" class="form-control" id="discount" name="discount" value="{{ $product->discount }}"
              required>
          </div>
          <div class="form-group">
            <label for="display_price">Stock Tersedia</label>
            <input type="number" class="form-control" id="stocks" name="stocks" value="{{ $product->stocks }}"
              required>
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
            <input type="text" class="form-control" id="author" name="author" value="{{ $product->author }}"
              required>
          </div>
          <div class="form-group">
            <label for="display_price">Penerbits</label>
            <input type="text" class="form-control" id="publisher" name="publisher" value="{{ $product->publisher }}"
              required>
          </div>
          <div class="form-group">
            <label>Date:</label>
            <div class="input-group date" id="reservationdate" data-target-input="nearest">
              <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate"
                value="{{ $product->release_at }}" />
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
            <input type="text" class="form-control" id="sku" name="sku" value="{{ $product->sku }}"
              required>
          </div>

          <div class="form-group">
            <label for="display_price">ISBN</label>
            <input type="text" class="form-control" id="isbn" name="isbn" value="{{ $product->isbn }}"
              required>
          </div>

          <div class="form-group">
            <label for="display_price">Bahasa</label>
            <select class="form-control" id="lang" name="lang" required>
              <option value="Billingual" {{ $product->lang == 'Billingual' ? 'selected' : '' }}>
                {{ $product->lang }}</option>
              <option value="English" {{ $product->lang == 'English' ? 'selected' : '' }}>
                {{ $product->lang }}</option>
              <option value="Indonesia" {{ $product->lang == 'Indonesia' ? 'selected' : '' }}>
                {{ $product->lang }}</option>
            </select>
          </div>

          <div class="form-group">
            <label for="display_price">Jumlah Halaman</label>
            <input type="text" class="form-control" id="pages" name="pages" value="{{ $product->pages }}"
              required>
          </div>

        </div>
      </div>
      <!-- Add other fields as necessary -->
      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
@endsection

@section('javascript')
  <script>
    $("#reservationdate").datetimepicker({
      format: "YYYY-MM-DD", // Match the format of $product->release_at
      defaultDate: '{{ $product->release_at }}'
    });

    console.log('{{ $product->release_at }}');
  </script>
@endsection

@section('init')
  <!-- InputMask -->
  <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>

  <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

@endsection
