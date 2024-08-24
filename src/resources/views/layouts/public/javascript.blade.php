<script>
  document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('login-form');
    const loginError = document.getElementById('login-error');

    loginForm.addEventListener('submit', async function(e) {
      e.preventDefault();

      loginError.classList.add('d-none');
      loginError.textContent = '';

      try {
        const response = await fetch('{{ route('public.login') }}', {
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
            window.location.href = '{{ route('public.home') }}';
          } else {
            loginError.classList.remove('d-none');
            loginError.textContent = result.message;
          }
        } else {
          loginError.classList.remove('d-none');
          loginError.textContent = result.message || 'An error occurred during login.';
        }
      } catch (error) {
        loginError.classList.remove('d-none');
        loginError.textContent = 'An unexpected error occurred.';
      }
    });
  });
</script>
