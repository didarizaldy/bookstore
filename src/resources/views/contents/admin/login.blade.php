<!DOCTYPE html>
<html lang="no">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ config('app.name') }} - Masuk</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Logo -->
  <link href="{{ asset('assets/img/icon/logo-16.png') }}" rel="shortcut icon" type="image/x-icon">
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />

  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}" />

  <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" />

  <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css?v=3.2.0') }}" />
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <img src="{{ asset('assets/img/icon/logo-64.png') }}" alt="Oscar Bookstore | Logo"
        class="brand-image img-circle elevation-3" style="opacity: .8">
    </div>

    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Masuk sebagai pengelola</p>


        <!-- Error message container -->
        <div id="login-error" class="alert alert-danger d-none" role="alert"></div>


        <form id="login-form" method="POST">
          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Email" id="email" />
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" id="password" />
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-login btn-block">
            Masuk
          </button>
        </form>
      </div>
    </div>
  </div>

  <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }} "></script>
  <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }} "></script>
  <script src="{{ asset('assets/dist/js/adminlte.min.js?v=3.2.0') }} "></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const loginForm = document.getElementById('login-form');
      const loginError = document.getElementById('login-error');

      loginForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        loginError.classList.add('d-none');
        loginError.textContent = '';

        try {
          const response = await fetch('{{ route('admin.login') }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
              email: document.getElementById('email').value,
              password: document.getElementById('password').value
            })
          });

          const result = await response.json();

          if (response.ok) {
            if (result.success) {
              window.location.href = '{{ route('admin.home') }}';
            } else {
              loginError.classList.remove('d-none');
              loginError.textContent = result.message;
            }
          } else {
            console.error('Login error:', response.status, response.statusText);
            loginError.classList.remove('d-none');
            loginError.textContent = result.message || 'An error occurred during login.';
          }
        } catch (error) {
          console.error('Login error:', error.message);
          loginError.classList.remove('d-none');
          loginError.textContent = 'An unexpected error occurred.';
        }
      });
    });
  </script>

</body>

</html>
