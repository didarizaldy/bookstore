<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Right navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto">
    {{-- Auth --}}
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <span class="text-sm">{{ \Illuminate\Support\Str::limit($user->fullname, 24, '...') }} <i
            class="fas fa-angle-down"></i></span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
        <a href="#" class="dropdown-item dropdown-footer"
          onclick="document.getElementById('logout-form').submit();">
          <i class="fas fa-sign-out-alt"></i> Keluar
        </a>

      </div>
    </li>
  </ul>
</nav>
<!-- /.navbar -->
