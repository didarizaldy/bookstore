<!DOCTYPE html>
<html lang="no">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name') }} - Register</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">


  <!-- Logo -->
  <link href="{{ asset('assets/img/icon/logo-16.png') }}" rel="shortcut icon" type="image/x-icon">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition login-page light-mode"
  style="background-image: url({{ asset('assets/img/main/register.png') }});background-size: 100%; background-repeat: no-repeat; object-fit: cover;">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary" style="background-color: #706EA0">
      <div class="card-header text-center">
        <img src="{{ asset('assets/img/icon/logo-64.png') }}" alt="Oscar Bookstore | Logo"
          class="brand-image img-circle elevation-3" style="opacity: .8">
      </div>
      <div class="card-body">
        <p class="login-box-msg" style="color: white">Silakan Daftar Terlebih Dahulu</p>

        <div id="register-error" class="alert alert-danger d-none" role="alert"></div>
        <form id="register-form" method="post">
          @csrf
          <div class="input-group mb-3">
            <input type="fullname" class="form-control" placeholder="Masukkan Nama Lengkap" required id="fullname">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="far fa-id-card"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="username" class="form-control" placeholder="Masukkan Username" required id="username">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-id-badge"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Email" id="email" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <div class="captcha">
              <span>{!! captcha_img() !!}</span>
              <button type="button" class="btn btn-danger btn-refresh" id="refresh-captcha"><i
                  class="fas fa-sync-alt"></i></button>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" id="captcha" name="captcha" class="form-control" placeholder="Masukkan Captcha"
              required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-key"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" id="password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
              placeholder="Konfirmasi Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-login btn-block">Daftar</button>
        </form>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>

  <script>
    $(document).ready(function() {
      $('#refresh-captcha').click(function() {
        $.ajax({
          type: 'GET',
          url: '{{ route('captcha.refresh') }}',
          success: function(data) {
            $('.captcha span').html(data.captcha);
          }
        });
      });
    });

    document.addEventListener('DOMContentLoaded', function() {
      const registerForm = document.getElementById('register-form');
      const registerError = document.getElementById('register-error');

      registerForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        registerError.classList.add('d-none');
        registerError.textContent = '';

        const response = await fetch('{{ route('public.register.post') }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({
            username: document.getElementById('username').value,
            fullname: document.getElementById('fullname').value,
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
            password_confirmation: document.getElementById('password_confirmation').value,
            captcha: document.getElementById('captcha').value
          })
        });

        const result = await response.json();

        if (response.ok) {
          if (result.success) {
            window.location.href = '{{ route('public.home') }}';
          } else {
            registerError.classList.remove('d-none');
            registerError.textContent = result.message;
          }
        } else {
          registerError.classList.remove('d-none');
          registerError.textContent = result.message || 'An error occurred during registration.';
        }
      });
    });
  </script>

</body>

</html>
