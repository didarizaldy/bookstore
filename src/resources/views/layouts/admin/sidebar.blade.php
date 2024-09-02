<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="{{ asset('assets/img/icon/logo-200.png') }}" alt="Oscar Bookstore | Logo"
      class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Oscar Bookstore</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column text-sm" data-widget="treeview" role="menu"
        data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="{{ route('admin.home') }}" class="nav-link" style="background-color: transparent">
            <i class="nav-icon fas fa-crow"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link" style="background-color: transparent">
            <i class="nav-icon fas fa-shopping-bag"></i>
            <p>
              Pesanan
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.order.view') }}" class="nav-link" style="background-color: transparent">
                <i class="far fa-angle-right nav-icon"></i>
                <p>Pengelolaan Pesanan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.order.delivery.view') }}" class="nav-link" style="background-color: transparent">
                <i class="far fa-angle-right nav-icon"></i>
                <p>Pengiriman Pesanan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.order.cancel.view') }}" class="nav-link" style="background-color: transparent">
                <i class="far fa-angle-right nav-icon"></i>
                <p>Pembatalan</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link" style="background-color: transparent">
            <i class="nav-icon fas fa-book"></i>
            <p>
              Produk
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.product.view') }}" class="nav-link" style="background-color: transparent">
                <i class="far fa-angle-right nav-icon"></i>
                <p>Pengelolaan Produk</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.category.view') }}" class="nav-link" style="background-color: transparent">
                <i class="far fa-angle-right nav-icon"></i>
                <p>Pengelolaan Kategori</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link" style="background-color: transparent">
            <i class="nav-icon fas fa-wallet"></i>
            <p>
              Keuangan
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link" style="background-color: transparent">
                <i class="far fa-angle-right nav-icon"></i>
                <p>Penghasilan Toko</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.bank.view') }}" class="nav-link" style="background-color: transparent">
                <i class="far fa-angle-right nav-icon"></i>
                <p>Rekening Bank</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link" style="background-color: transparent">
            <i class="nav-icon fas fa-chart-line"></i>
            <p>
              Data
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link" style="background-color: transparent">
                <i class="far fa-angle-right nav-icon"></i>
                <p>Highlight Produk</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link" style="background-color: transparent">
            <i class="nav-icon fas fa-store"></i>
            <p>
              Toko
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link" style="background-color: transparent">
                <i class="far fa-angle-right nav-icon"></i>
                <p>Pengaturan</p>
              </a>
            </li>
          </ul>
        </li>
        @if (Auth::user()->hasRole('opsweb'))
          <li class="nav-item menu-open">
            <a href="#" class="nav-link" style="background-color: transparent">
              <i class="nav-icon far fa-eye"></i>
              <p>
                User
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.user.view') }}" class="nav-link" style="background-color: transparent">
                  <i class="far fa-angle-right nav-icon"></i>
                  <p>Pengaturan</p>
                </a>
              </li>
            </ul>
          </li>
        @endif
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
