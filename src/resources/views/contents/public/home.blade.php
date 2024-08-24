@extends('layouts.public.app')

@section('titlebar')
  Home
@endsection

@section('stylesheet')
  <style>
    /* Make the image fully responsive */
    .carousel-inner img {
      width: 100%;
      height: 100%;
    }

    /* styles.css */
    .carousel-indicators li {
      background-color: #F45830;
    }

    .carousel-indicators .active {
      background-color: #333;
    }

    .carousel-control-prev,
    .carousel-control-next {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      background-color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      top: 50%;
      transform: translateY(-50%);
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
      width: 20px;
      height: 20px;
      background-color: black;
    }

    /* card */
    .card {
      margin-bottom: 20px;
      /* Adds space between rows */
    }

    /* card */
  </style>
@endsection

@section('content')
  <div id="cover" class="carousel slide py-3" data-ride="carousel">

    <!-- Indicators -->
    <ul class="carousel-indicators">
      <li data-target="#cover" data-slide-to="0" class="active"></li>
      <li data-target="#cover" data-slide-to="1"></li>
      <li data-target="#cover" data-slide-to="2"></li>
    </ul>

    <!-- The slideshow -->
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="{{ asset('assets/img/main/cover-1.png') }}" alt="cover-1-homepage" width="1100" height="500">
      </div>
      <div class="carousel-item">
        <img src="{{ asset('assets/img/main/cover-2.png') }}" alt="cover-2-homepage" width="1100" height="500">
      </div>
      <div class="carousel-item">
        <img src="{{ asset('assets/img/main/cover-3.png') }}" alt="cover-3-homepage" width="1100" height="500">
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="carousel-control-prev" href="#cover" data-slide="prev">
      <i class="fas fa-chevron-left" style="color: black"></i>
    </a>
    <a class="carousel-control-next" href="#cover" data-slide="next">
      <i class="fas fa-chevron-right" style="color: black"></i>
    </a>
  </div>

  <div class="text-center py-3 px-3">
    <div class="row">
      <div class="col-4 col-md-2 mb-4">
        <h5 class="text-center"><i class="fas fa-star-and-crescent"
            style="color: #0EB3FF; display: inline-block; border-radius: 15px; box-shadow: 0 0 5px #0EB3FF; padding: 0.5em 0.6em;"></i>
        </h5>
        <p class="card-text">Agama</p>
      </div>
      <div class="col-4 col-md-2 mb-4">
        <h5 class="text-center"><i class="fas fa-handshake"
            style="color: #0EB3FF; display: inline-block; border-radius: 15px; box-shadow: 0 0 5px #0EB3FF; padding: 0.5em 0.6em;"></i>
        </h5>
        <p class="card-text">Bisnis</p>
      </div>
      <div class="col-4 col-md-2 mb-4">
        <h5 class="text-center"><i class="fab fa-fort-awesome"
            style="color: #0EB3FF; display: inline-block; border-radius: 15px; box-shadow: 0 0 5px #0EB3FF; padding: 0.5em 0.6em;"></i>
        </h5>
        <p class="card-text">Komik</p>
      </div>
      <div class="col-4 col-md-2 mb-4">
        <h5 class="text-center"><i class="fas fa-user-graduate"
            style="color: #0EB3FF; display: inline-block; border-radius: 15px; box-shadow: 0 0 5px #0EB3FF; padding: 0.5em 0.6em;"></i>
        </h5>
        <p class="card-text">Pendidikan</p>
      </div>
      <div class="col-4 col-md-2 mb-4">
        <h5 class="text-center"><i class="fas fa-utensils"
            style="color: #0EB3FF; display: inline-block; border-radius: 15px; box-shadow: 0 0 5px #0EB3FF; padding: 0.5em 0.6em;"></i>
        </h5>
        <p class="card-text">Masakan</p>
      </div>
      <div class="col-4 col-md-2 mb-4">
        <h5 class="text-center"><i class="fas fa-suitcase-rolling"
            style="color: #0EB3FF; display: inline-block; border-radius: 15px; box-shadow: 0 0 5px #0EB3FF; padding: 0.5em 0.6em;"></i>
        </h5>
        <p class="card-text">Travel</p>
      </div>
    </div>
  </div>

  <!-- Content Header (Rilis Terbaru) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <span>Rilisan Terbaru</span>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <div class="row">
    @foreach ($productsNew as $productNew)
      <div class="col-6 mb-2 col-md-2 col-lg-2">
        <a href="{{ route('public.product.detail', ['sku' => $productNew->sku, 'slug' => $productNew->slug]) }}"
          class="text-decoration-none">
          <div class="card h-100">
            <img src="{{ asset('assets/img/cover-book/' . $productNew->filename_img) }}" class="card-img-top"
              alt="{{ $productNew->title }}">
            <div class="card-body">
              <h5 class="card-title product-title" style="font-size: 12px">{{ $productNew->title }}</h5>
              @if ($productNew->formatted_display_price)
                <p class="card-text">
                  <span class="text-danger">{{ $productNew->formatted_display_price }}</span><br>
                  <small><s class="text-muted">{{ $productNew->formatted_original_price }}</s></small><br>
                  <span class="badge badge-danger">{{ $productNew->formatted_discount }}</span>
                </p>
                <p style="font-size: 10px"><i class="fas fa-check-circle" style="color: purple"></i> Official Store</p>
              @else
                <p class="card-text">{{ $productNew->formatted_original_price }}</p>
                <p style="font-size: 10px"><i class="fas fa-check-circle" style="color: purple"></i> Official Store</p>
              @endif
            </div>
          </div>
        </a>
      </div>
    @endforeach
  </div>


  <hr>

  <!-- Content Header (Agama) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <span>Rilis Terbaru Agama <strong><a href="{{ url('c/agama') }}" class="text-sm" style="color: navy">
              Lihat
              Semua</a></strong></span>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <div class="row">
    @foreach ($productsReligion as $productReligion)
      <div class="col-6 mb-2 col-md-2 col-lg-2"> <!-- Ensures 3 cards per row -->
        <a href="{{ route('public.product.detail', ['sku' => $productReligion->sku, 'slug' => $productReligion->slug]) }}"
          class="text-decoration-none">
          <div class="card h-100">
            <img src="{{ asset('assets/img/cover-book/' . $productReligion->filename_img) }}" class="card-img-top"
              alt="{{ $productReligion->title }}">
            <div class="card-body">
              <h5 class="card-title product-title" style="font-size: 12px">{{ $productReligion->title }}</h5>
              @if ($productReligion->formatted_display_price)
                <p class="card-text">
                  <span class="text-danger">{{ $productReligion->formatted_display_price }}</span><br>
                  <small><s class="text-muted">{{ $productReligion->formatted_original_price }}</s></small><br>
                  <span class="badge badge-danger">{{ $productReligion->formatted_discount }}</span>
                </p>
                <p style="font-size: 10px"><i class="fas fa-check-circle" style="color: purple"></i> Official Store</p>
              @else
                <p class="card-text">{{ $productReligion->formatted_original_price }}</p>
                <p style="font-size: 10px"><i class="fas fa-check-circle" style="color: purple"></i> Official Store</p>
              @endif
            </div>
          </div>
        </a>
      </div>
    @endforeach
  </div>

  <!-- Content Header (Masakan) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <span>Rilis Terbaru Masakan <strong><a href="{{ url('c/masak') }}" class="text-sm" style="color: navy"> Lihat
              Semua</a></strong></span>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <div class="row">
    @foreach ($productsCook as $productCook)
      <div class="col-6 mb-2 col-md-2 col-lg-2"> <!-- Ensures 3 cards per row -->
        <a href="{{ route('public.product.detail', ['sku' => $productCook->sku, 'slug' => $productCook->slug]) }}"
          class="text-decoration-none">
          <div class="card h-100">
            <img src="{{ asset('assets/img/cover-book/' . $productCook->filename_img) }}" class="card-img-top"
              alt="{{ $productCook->title }}">
            <div class="card-body">
              <h5 class="card-title product-title" style="font-size: 12px">{{ $productCook->title }}</h5>
              @if ($productCook->formatted_display_price)
                <p class="card-text">
                  <span class="text-danger">{{ $productCook->formatted_display_price }}</span><br>
                  <small><s class="text-muted">{{ $productCook->formatted_original_price }}</s></small><br>
                  <span class="badge badge-danger">{{ $productCook->formatted_discount }}</span>
                </p>
                <p style="font-size: 10px"><i class="fas fa-check-circle" style="color: purple"></i> Official Store</p>
              @else
                <p class="card-text">{{ $productCook->formatted_original_price }}</p>
                <p style="font-size: 10px"><i class="fas fa-check-circle" style="color: purple"></i> Official Store</p>
              @endif
            </div>
          </div>
        </a>
      </div>
    @endforeach
  </div>

  <!-- Content Header (Komik) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <span>Rilis Terbaru Komik <strong><a href="{{ url('c/komik') }}" class="text-sm" style="color: navy"> Lihat
              Semua</a></strong></span>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <div class="row">
    @foreach ($productsComic as $productComic)
      <div class="col-6 mb-2 col-md-2 col-lg-2"> <!-- Ensures 3 cards per row -->
        <a href="{{ route('public.product.detail', ['sku' => $productComic->sku, 'slug' => $productComic->slug]) }}"
          class="text-decoration-none">
          <div class="card h-100">
            <img src="{{ asset('assets/img/cover-book/' . $productComic->filename_img) }}" class="card-img-top"
              alt="{{ $productComic->title }}">
            <div class="card-body">
              <h5 class="card-title product-title" style="font-size: 12px">{{ $productComic->title }}</h5>
              @if ($productComic->formatted_display_price)
                <p class="card-text">
                  <span class="text-danger">{{ $productComic->formatted_display_price }}</span><br>
                  <small><s class="text-muted">{{ $productComic->formatted_original_price }}</s></small><br>
                  <span class="badge badge-danger">{{ $productComic->formatted_discount }}</span>
                </p>
                <p style="font-size: 10px"><i class="fas fa-check-circle" style="color: purple"></i> Official Store</p>
              @else
                <p class="card-text">{{ $productComic->formatted_original_price }}</p>
                <p style="font-size: 10px"><i class="fas fa-check-circle" style="color: purple"></i> Official Store</p>
              @endif
            </div>
          </div>
        </a>
      </div>
    @endforeach
  </div>

  <!-- Content Header (Pendidikan) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <span>Rilis Terbaru Pendidikan <strong><a href="{{ url('c/pendidikan') }}" class="text-sm"
              style="color: navy"> Lihat
              Semua</a></strong></span>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <div class="row">
    @foreach ($productsEducation as $productEducation)
      <div class="col-6 mb-2 col-md-2 col-lg-2"> <!-- Ensures 3 cards per row -->
        <a href="{{ route('public.product.detail', ['sku' => $productNew->sku, 'slug' => $productNew->slug]) }}"
          class="text-decoration-none">
          <div class="card h-100">
            <img src="{{ asset('assets/img/cover-book/' . $productEducation->filename_img) }}" class="card-img-top"
              alt="{{ $productEducation->title }}">
            <div class="card-body">
              <h5 class="card-title product-title" style="font-size: 12px">{{ $productEducation->title }}</h5>
              @if ($productEducation->formatted_display_price)
                <p class="card-text">
                  <span class="text-danger">{{ $productEducation->formatted_display_price }}</span><br>
                  <small><s class="text-muted">{{ $productEducation->formatted_original_price }}</s></small><br>
                  <span class="badge badge-danger">{{ $productEducation->formatted_discount }}</span>
                </p>
                <p style="font-size: 10px"><i class="fas fa-check-circle" style="color: purple"></i> Official Store</p>
              @else
                <p class="card-text">{{ $productEducation->formatted_original_price }}</p>
                <p style="font-size: 10px"><i class="fas fa-check-circle" style="color: purple"></i> Official Store</p>
              @endif
            </div>
          </div>
        </a>
      </div>
    @endforeach
  </div>
@endsection

@section('javascript')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Select all elements with the class 'product-title'
      var titles = document.querySelectorAll('.product-title');

      titles.forEach(function(title) {
        var maxLength = 38;
        var text = title.textContent;

        if (text.length > maxLength) {
          // Truncate text and add ellipsis
          title.textContent = text.substring(0, maxLength) + '...';
        }
      });
    });
  </script>
@endsection
