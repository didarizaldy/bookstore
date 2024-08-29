<!-- Navbar -->
<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
  <div class="container">
    <a href="{{ route('public.home') }}" class="navbar-brand">
      <img src="{{ asset('assets/img/icon/logo-200.png') }}" alt="Oscar Bookstore | Logo"
        class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Oscar Bookstore</span>
    </a>

    <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
      aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse order-3" id="navbarCollapse">

      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item px-4 dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">Kategori</a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="categoryDropdown">
            <div class="d-md-flex align-items-start justify-content-start">
              @foreach (collect($categories)->chunk(ceil(count($categories) / 5)) as $categoryChunk)
                <div class="p-2">
                  @foreach ($categoryChunk as $category)
                    <a href="{{ route('public.category.show', ['slug' => generateSlug($category['name'])]) }}"
                      class="dropdown-item">{{ $category['name'] }}</a>
                  @endforeach
                </div>
              @endforeach
            </div>
          </div>
        </li>
      </ul>

      <!-- SEARCH FORM -->
      <form class="form-inline ml-0 ml-md-3 w-100 pr-2" style="max-width: 600px;"
        action="{{ route('public.products.search') }}" method="GET">
        <div class="input-group input-group-md w-100">
          <input class="form-control form-control-navbar" type="search" name="q" placeholder="Search"
            aria-label="Search" value="{{ request('q') }}">
          <div class="input-group-append">
            <button class="btn btn-navbar" type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form>


    </div>

    <!-- Right navbar links -->
    <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">

      @if (Auth::check())
        <!-- Cart Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fas fa-shopping-cart"></i>
            <span class="badge badge-danger navbar-badge">
              {{ Auth::user()->basket->count() ?? 0 }}
            </span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="max-height: 400px; overflow-y: auto;">
            @if (Auth::user()->basket->isEmpty())
              <span class="dropdown-item text-muted">Masih kosong nih</span>
            @else
              @foreach (Auth::user()->basket as $item)
                <a href="#" class="dropdown-item">
                  <div class="media">
                    <img src="{{ asset('assets/img/cover-book/' . $item->product->filename_img) }}"
                      alt="Cart {{ \Illuminate\Support\Str::limit($item->product->title, 18, '...') }}"
                      class="img-size-50 mr-3 rounded">
                    <div class="media-body">
                      <h3 class="dropdown-item-title">
                        {{ \Illuminate\Support\Str::limit($item->product->title, 18, '...') }}</h3>
                      <p class="text-sm">Quantity: {{ $item->quantity }}</p>
                      <p class="text-sm text-muted">
                        Rp{{ number_format($item->product->display_price * $item->quantity, 0, ',', '.') }}</p>
                    </div>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
              @endforeach
            @endif
            <a href="{{ route('public.cart.view') }}" class="dropdown-item dropdown-footer">Lihat Keranjang</a>
          </div>
        </li>



        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-header">Aktivitas</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="far fa-clock" style="color: #0EB3FF"></i> Menunggu Konfirmasi
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-spinner" style="color: #0EB3FF"></i> Pesanan Diproses
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-shipping-fast" style="color: #0EB3FF"></i> Sedang Dikirim
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-map-marker-alt" style="color: #0EB3FF"></i> Sampai Tujuan
            </a>
            <div class="dropdown-divider"></div>
            <span href="#" class="dropdown-item dropdown-footer">Daftar Aktivitas</span>
          </div>
        </li>
      @endif

      @if (Auth::check())
        <!-- Setting User Account -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fas fa-user-alt"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-header">{{ \Illuminate\Support\Str::limit($user->fullname, 24, '...') }}</span>
            <div class="dropdown-divider"></div>
            <a href="{{ route('public.purchase.view') }}" class="dropdown-item">Pembelian</a>
            <div class="dropdown-divider"></div>
            <a href="{{ route('public.user.setting') }}" class="dropdown-item">Pengaturan</a>
            <div class="dropdown-divider"></div>


            <form id="logout-form" action="{{ route('public.logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
            <a href="#" class="dropdown-item dropdown-footer"
              onclick="document.getElementById('logout-form').submit();">
              <i class="fas fa-sign-out-alt"></i> Keluar
            </a>

          </div>
        </li>
      @else
        <!-- Login Menu -->
        <div class="row">
          <div class="col-6 pr-1">
            <button class="btn btn-outline-login btn-sm" type="button" data-toggle="modal"
              data-target="#login">Masuk</button>
          </div>
          <div class="col-6 pl-1">
            <a href="{{ route('public.register') }}" class="btn btn-login btn-sm" role="button">Daftar</a>
          </div>
        </div>
        <!-- Login Menu End -->
      @endif


    </ul>
  </div>
</nav>
<!-- /.navbar -->

<div class="modal fade" id="login">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row mb-2 align-items-center">
          <div class="col-sm-6">
            <h4 class="text-center"><strong>Masuk</strong></h4>
          </div>
          <div class="col-sm-6">
            <h6 class="text-center"><a href="{{ route('public.register') }}"
                style="color: #0EB3FF; text-decoration: none;">Daftar</a></h6>
          </div>
        </div>

        <!-- Error message container -->
        <div id="login-error" class="alert alert-danger d-none" role="alert"></div>

        <form id="login-form" method="POST">
          @csrf
          <div class="form-group">
            <label class="text-muted text-sm" style="font-weight: normal">Email</label>
            <input type="email" class="form-control w-100" id="email" name="email"
              style="border-radius: 12px" maxlength="120" pattern="[a-zA-Z0-9@.,]+" required>
          </div>
          <div class="form-group">
            <label class="text-muted text-sm" style="font-weight: normal">Password</label>
            <input type="password" class="form-control w-100" id="password" name="password"
              style="border-radius: 12px" maxlength="12" required>
          </div>
          <button type="submit" class="btn btn-login btn-block btn-round">Login</button>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
