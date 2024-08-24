@extends('layouts.public.app')

@section('titlebar')
  Hasil Pencarian : "{{ $query }}"
@endsection

@section('stylesheet')
  <style>
    .page-item .page-link {
      box-shadow: none;
      color: black;
    }

    .page-item.active .page-link {
      color: #fff;
      background-color: #1d2dc0;
      border-color: #1a3377;
      box-shadow: none;
    }
  </style>
@endsection

@section('content')
  <!-- Section Header -->
  <section class="content-header" id="breadcrum-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-12 d-flex justify-content-between align-items-center">
          <!-- Breadcrumb -->
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item active">Hasil Pencarian : "{{ $query }}"</li>
          </ol>

          <!-- Sorting Form (Desktop) -->
          <form action="{{ route('public.products.search') }}" method="GET" class="form-inline d-none d-md-inline-flex">
            <input type="hidden" name="q" value="{{ $query }}">
            <input type="hidden" name="min_price" value="{{ $minPrice }}">
            <input type="hidden" name="max_price" value="{{ $maxPrice }}">
            <span for="sort" class="mr-2 mb-0">Urutkan :</span>
            <select name="sort" id="sort" class="form-control" onchange="this.form.submit()">
              <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>Terbaru</option>
              <option value="high-price" {{ $sort == 'high-price' ? 'selected' : '' }}>Harga Tertinggi</option>
              <option value="low-price" {{ $sort == 'low-price' ? 'selected' : '' }}>Harga Terendah</option>
            </select>
          </form>
        </div>
      </div>
    </div>
  </section>

  <div class="row">
    <div class="col-12 col-md-3">
      <!-- Harga Card (Desktop) -->
      <div class="card d-none d-md-block">
        <div class="card-header">
          <h3 class="card-title">Harga</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <ul class="nav nav-pills flex-column">
            <div class="container">
              <li class="nav-item">
                <form action="{{ route('public.products.search') }}" method="GET">
                  <input type="hidden" name="q" value="{{ $query }}">
                  <input type="hidden" name="sort" value="{{ $sort }}">
                  <div class="input-group mb-3 mt-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Rp</span>
                    </div>
                    <input type="text" name="min_price" class="form-control" placeholder="Harga Minimum"
                      value="{{ $minPrice }}">
                  </div>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Rp</span>
                    </div>
                    <input type="text" name="max_price" class="form-control" placeholder="Harga Maksimum"
                      value="{{ $maxPrice }}">
                  </div>
                  <button type="submit" class="btn btn-secondary mb-3">Filter</button>
                </form>
              </li>
            </div>
          </ul>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

      <!-- Harga Button (Mobile) -->
      <button class="btn btn-light d-block d-md-none mb-2" data-toggle="modal" data-target="#priceModal">
        <i class="fas fa-sort-amount-up-alt"></i>
      </button>
    </div>

    <div class="col-12 col-md-9">
      <div class="row">
        @if ($products->isEmpty())
          <div class="container">
            <section class="content">
              <div class="error-page">
                <div class="error-content">
                  <h3><i class="fas fa-exclamation-triangle text-warning"></i> Wah! Produknya Belum Ada Nih.</h3>
                  <p>Kamu bisa banget rekomenin produk itu ke kami ya untuk kami rilis di toko.
                  </p>
                </div>
                <!-- /.error-content -->
              </div>
              <!-- /.error-page -->
            </section>
          </div>
        @else
          @foreach ($products as $product)
            <div class="col-6 mb-2 col-md-4 col-lg-3">
              <a href="{{ route('public.product.detail', ['sku' => $product->sku, 'slug' => $product->slug]) }}"
                class="text-decoration-none">
                <div class="card h-100">
                  <img src="{{ asset('assets/img/cover-book/' . $product->filename_img) }}" class="card-img-top"
                    alt="{{ $product->title }}">
                  <div class="card-body">
                    <h5 class="card-title product-title" style="font-size: 12px">{{ $product->title }}</h5>
                    @if ($product->formatted_display_price)
                      <p class="card-text">
                        <span class="text-danger">{{ $product->formatted_display_price }}</span><br>
                        <small><s class="text-muted">{{ $product->formatted_original_price }}</s></small><br>
                        <span class="badge badge-danger">{{ $product->formatted_discount }}</span>
                      </p>
                      <p style="font-size: 10px"><i class="fas fa-check-circle" style="color: purple"></i> Official Store
                      </p>
                    @else
                      <p class="card-text">{{ $product->formatted_original_price }}</p>
                      <p style="font-size: 10px"><i class="fas fa-check-circle" style="color: purple"></i> Official Store
                      </p>
                    @endif
                  </div>
                </div>
              </a>
            </div>
          @endforeach
        @endif
      </div>
    </div>
  </div>

  <!-- Pagination Links -->
  {{ $products->appends(['sort' => $sort, 'min_price' => $minPrice, 'max_price' => $maxPrice, 'q' => $query])->links() }}

  <!-- Harga Modal (Mobile) -->
  <div class="modal fade" id="priceModal" tabindex="-1" role="dialog" aria-labelledby="priceModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="priceModalLabel">Harga</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('public.products.search') }}" method="GET">
            <input type="hidden" name="q" value="{{ $query }}">
            <input type="hidden" name="sort" value="{{ $sort }}">
            <div class="form-group">
              <label for="sort">Urutkan :</label>
              <select name="sort" id="sort" class="form-control" onchange="this.form.submit()">
                <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>Terbaru</option>
                <option value="high-price" {{ $sort == 'high-price' ? 'selected' : '' }}>Harga Tertinggi</option>
                <option value="low-price" {{ $sort == 'low-price' ? 'selected' : '' }}>Harga Terendah</option>
              </select>
            </div>
            <div class="form-group">
              <label for="min_price">Harga Minimum :</label>
              <input type="text" name="min_price" id="min_price" class="form-control" placeholder="Harga Minimum"
                value="{{ $minPrice }}">
            </div>
            <div class="form-group">
              <label for="max_price">Harga Maksimum :</label>
              <input type="text" name="max_price" id="max_price" class="form-control" placeholder="Harga Maksimum"
                value="{{ $maxPrice }}">
            </div>
            <button type="submit" class="btn btn-secondary mb-3 mt-3">Filter</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('sroll-on-top')
  <a id="back-to-top" href="#" class="btn btn-login back-to-top" role="button" aria-label="Scroll to top"
    style="border-radius: 30%;">
    <i class="fas fa-chevron-up"></i>
  </a>
@endsection

@section('javascript')
  <script>
    $(document).ready(function() {
      function checkAndToggleBreadcrumb() {
        if (window.innerWidth <= 600) {
          $('#breadcrum-header').hide();
        } else {
          $('#breadcrum-header').show();
        }
      }

      // Initial check
      checkAndToggleBreadcrumb();

      // Check on resize
      $(window).resize(checkAndToggleBreadcrumb);
    });
  </script>
@endsection
