@extends('layouts.public.app')

@section('titlebar')
  Detail
@endsection

@section('stylsheet')
  <style>
    @media (max-width: 767.98px) {

      .navbar .btn-login,
      .navbar .btn-outline-login {
        font-size: 14px;
        padding: 10px;
      }
    }
  </style>
@endsection

@section('content-header')
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container">
      <div class="row mb-2"><!-- /.col -->
        <div class="col-sm-12">
          <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item text-sm"><a href="{{ route('public.home') }}">Beranda</a></li>
            <li class="breadcrumb-item text-sm"><a
                href="{{ route('public.category.show', ['slug' => generateSlug($product['category']['name'])]) }}">{{ $product->category->name }}</a>
            </li>
            <li class="breadcrumb-item active text-sm">{{ \Illuminate\Support\Str::limit($product->title, 35, '...') }}
            </li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
@endsection

@section('content')
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">

          <!-- Book Image -->
          <div class="card card-light card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="img-fluid rounded" src="{{ asset('assets/img/cover-book/' . $product->filename_img) }}"
                  alt="{{ $product->title }}">
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->


        <div class="col-md-5">
          <h3><strong>{{ $product->title }}</strong></h3>
          @if ($product->formatted_display_price)
            <span><small class="badge badge-danger">{{ $product->formatted_discount }}</small> <s
                class="text-muted">{{ $product->formatted_original_price }}</s></span><br>
            <h4><strong>{{ $product->formatted_display_price }}</strong></h4>
          @else
            <h5 class="card-text">{{ $product->formatted_original_price }}</h5>
          @endif

          <div class="card card-light card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
              <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill"
                    href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home"
                    aria-selected="true">Detail Produk</a>
                </li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content" id="custom-tabs-four-tabContent">
                <div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel"
                  aria-labelledby="custom-tabs-four-home-tab">
                  <table class="table table-sm table-borderless">
                    <tbody>
                      <tr>
                        <td style="font-size:
                    14px" class="text-muted text-sm">Jumlah Halaman</td>
                        <td style="font-size: 14px">: {{ $product->pages }}</td>
                      </tr>
                      <tr>
                        <td style="font-size: 14px" class="text-muted text-sm">Tanggal Terbit</td>
                        <td style="font-size: 14px">: {{ date('d/m/Y', strtotime($product->release_at)) }}</td>
                      </tr>
                      <tr>
                        <td style="font-size: 14px" class="text-muted text-sm">ISBN</td>
                        <td style="font-size: 14px">: {{ $product->isbn }}</td>
                      </tr>
                      <tr>
                        <td style="font-size: 14px" class="text-muted text-sm">Bahasa</td>
                        <td style="font-size: 14px">: {{ $product->lang }}</td>
                      </tr>
                      <tr>
                        <td style="font-size: 14px" class="text-muted text-sm">Penulis</td>
                        <td style="font-size: 14px">: {{ $product->author }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->

        <div class="col-md-4">


          <!-- Checkout Large -->
          <div class="card card-light d-none d-md-block">
            <div class="card-header">
              <h3 class="card-title">Atur Jumlah</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="d-flex align-items-center mb-2">
                <div class="input-group input-group-sm w-50">
                  <span class="input-group-btn">
                    <button type="button" class="quantity-left-minus btn btn-light btn-number" data-type="minus"
                      data-field="">
                      <span><small><i class="fas fa-minus" style="color: #0EB3FF"></i></small></span>
                    </button>
                  </span>
                  <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1"
                    min="1" max="{{ $product->stocks }}" disabled>
                  <span class="input-group-btn">
                    <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus"
                      data-field="">
                      <span><small><i class="fas fa-plus" style="color: #0EB3FF"></i></small></span>
                    </button>
                  </span>
                </div>
                <span class="ml-2">Masih ada: <strong>{{ $product->stocks }}</strong></span>
              </div>
              <strong><small class="text-muted">Subtotal: </small><span
                  id="totalPay">{{ $product->formatted_display_price }}</span></strong>
              <br />
              <div class="pt-3">
                <button type="button" class="btn btn-login btn-block text-center" id="addToCart">+ Keranjang</button>
              </div>
            </div>
            <!-- /.card-body -->
          </div>

          <!-- Bottom Navbar for mobile view Checkout -->
          <nav class="navbar navbar-light bg-light navbar-expand fixed-bottom d-md-none">
            <div class="container-fluid justify-content-center">
              <div class="row w-100 mb-2 mt-2">
                <div class="col-12">
                  <button type="button" class="btn btn-login btn-block btn-lg text-center ">+ Keranjang</button>
                </div>
              </div>
            </div>
          </nav>


          <!-- /.card -->
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
@endsection

@section('sroll-on-top')
  <a id="back-to-top" href="#" class="btn btn-login back-to-top" role="button" aria-label="Scroll to top"
    style="border-radius: 30%;">
    <i class="fas fa-chevron-up"></i>
  </a>
@endsection

@section('javascript')
  <script>
    function updateNavbarCartCount(count) {
      const navbarBadge = document.querySelector('.navbar-badge');
      navbarBadge.innerText = count;
    }

    $(document).ready(function() {
      var quantity = 1;
      var maxQuantity = {{ $product->stocks }};
      var price = {{ $product->display_price }};

      function formatRupiah(amount) {
        // Function to format the amount as Rupiah
        return 'Rp' + amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
      }

      function updatePrice() {
        var totalPay = price * quantity;
        $('#totalPay').text(formatRupiah(totalPay));
      }

      $('.quantity-right-plus').click(function(e) {
        e.preventDefault();
        if (quantity < maxQuantity) {
          quantity++;
          $('#quantity').val(quantity);
          updatePrice();
        }
      });

      $('.quantity-left-minus').click(function(e) {
        e.preventDefault();
        if (quantity > 1) {
          quantity--;
          $('#quantity').val(quantity);
          updatePrice();
        }
      });
    });

    document.getElementById('addToCart').addEventListener('click', function() {
      fetch('{{ route('public.cart.add') }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({
            product_id: {{ $product->id }},
            quantity: document.getElementById('quantity').value
          })
        }).then(response => response.json())
        .then(response => {
          updateNavbarCartCount(response.newCartCount);
        })
        .then(data => {
          console.log(data);
          console.log(data.newCartCount);
          if (data.message) {
            alert(data.message);
            // Optionally, update the cart dropdown or badge here
          }
        });
    });
  </script>
@endsection
