<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistema Integral Colegio Vida</title>

  <!-- Google Font: Inter -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=fallback" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!-- Custom Styles -->
  <style>
    :root {
      --primary-color: #4F46E5;
      --primary-hover: #4338CA;
      --bg-color: #F9FAFB;
      --card-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    }

    body {
      background-color: var(--bg-color);
      font-family: 'Inter', sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-box {
      width: 100%;
      max-width: 440px;
      margin: 20px;
    }

    .card {
      background: white;
      border-radius: 16px;
      border: none;
      box-shadow: var(--card-shadow);
    }

    .card-header {
      background-color: white;
      border-bottom: none;
      padding: 2rem 2rem 1rem;
    }

    .card-header .h1 {
      color: var(--primary-color);
      font-weight: 700;
      text-decoration: none;
      font-size: 1.875rem;
    }

    .card-body {
      padding: 2rem;
    }

    .login-box-msg {
      font-size: 1.25rem;
      color: #111827;
      font-weight: 600;
      margin-bottom: 1.5rem;
    }

    .input-group {
      position: relative;
      margin-bottom: 1.5rem;
    }

    .form-control {
      padding: 0.75rem 1rem;
      border-radius: 0.5rem;
      border: 1px solid #D1D5DB;
      font-size: 1rem;
      width: 100%;
      transition: all 0.2s;
    }

    .form-control:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .input-group-append {
      position: absolute;
      right: 1rem;
      top: 50%;
      transform: translateY(-50%);
      z-index: 10;
    }

    .input-group-text {
      background: none;
      border: none;
      color: #6B7280;
      cursor: pointer;
      padding: 0;
    }

    .input-group-text:hover {
      color: var(--primary-color);
    }

    .btn-primary {
      background-color: var(--primary-color);
      border-color: var(--primary-color);
      padding: 0.75rem 1.5rem;
      font-size: 1rem;
      font-weight: 500;
      border-radius: 0.5rem;
      transition: all 0.2s;
    }

    .btn-primary:hover {
      background-color: var(--primary-hover);
      border-color: var(--primary-hover);
      transform: translateY(-1px);
    }

    .alert-danger {
      border-radius: 0.5rem;
      margin-bottom: 1.5rem;
      background-color: #FEE2E2;
      border-color: #FEE2E2;
      color: #991B1B;
    }

    .remember-me {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .remember-me input[type="checkbox"] {
      width: 1rem;
      height: 1rem;
      border-radius: 0.25rem;
      border: 1px solid #D1D5DB;
    }

    .forgot-password {
      color: var(--primary-color);
      text-decoration: none;
      font-weight: 500;
      transition: all 0.2s;
    }

    .forgot-password:hover {
      color: var(--primary-hover);
      text-decoration: underline;
    }

    @media (max-width: 480px) {
      .card-body {
        padding: 1.5rem;
      }
    }
  </style>
</head>

<body>
  <div class="login-box">
    <div class="card">
      <div class="card-header text-center">
         <h1>Colegio <b>Vida</b</h1>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Inicia Sesión</p>

        @if ($errors->has('error'))
          <div class="alert alert-danger">
            {{ $errors->first('error') }}
          </div>
        @endif

        <form action="{{ asset('login') }}" method="post">
          {{ csrf_field() }}

          <div class="input-group">
            <input type="email" class="form-control" required name="email" placeholder="Correo electrónico" value="{{ old('email') }}">
            <div class="input-group-append">
              <div class="input-group-text">
                <i class="fas fa-envelope"></i>
              </div>
            </div>
          </div>

          <div class="input-group">
            <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
            <div class="input-group-append">
              <div class="input-group-text" onclick="togglePassword()">
                <i class="fas fa-eye" id="togglePassword"></i>
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="remember-me">
              <input type="checkbox" id="remember" name="remember">
              <label for="remember">Recuérdame</label>
            </div>
            <a href="{{ asset('forgot-password') }}" class="forgot-password">¿Olvidaste tu contraseña?</a>
          </div>

          <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script>
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const toggleIcon = document.getElementById('togglePassword');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
      }
    }
  </script>
</body>
</html>