<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistema Integral Colegio Vida</title>

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!-- Custom Styles -->
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Source Sans Pro', sans-serif;
    }
    .login-box {
      width: 400px;
      margin: 50px auto;
    }
    .card-header {
      background-color: #007bff;
      color: #fff;
    }
    .card-body {
      border-radius: 10px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
      padding: 30px;
    }
    .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
      width: 100%;
      padding: 10px;
      font-size: 18px;
      border-radius: 5px;
    }
    .btn-primary:hover {
      background-color: #0056b3;
      border-color: #0056b3;
    }
    .input-group-text {
      background-color: #007bff;
      color: white;
    }
    .alert-danger {
      border-radius: 5px;
      margin-bottom: 20px;
    }
    .icheck-primary input[type="checkbox"]:checked ~ .icheck-label {
      color: #007bff;
    }
    .login-box-msg {
      font-size: 22px;
      color: #007bff;
      margin-bottom: 30px;
    }
  </style>
</head>

<body class="hold-transition login-page">

  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="../../index2.html" class="h1"><b>Colegio</b> Vida</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Inicia Sesión</p>

        <!-- Mostrar error de credenciales -->
        @if ($errors->has('error'))
          <div class="alert alert-danger">
            {{ $errors->first('error') }}
          </div>
        @endif

        <form action="{{ asset('login') }}" method="post">
          {{ csrf_field() }}

          <!-- Campo de Email -->
          <div class="input-group mb-3">
            <input type="email" class="form-control" required name="email" placeholder="Email" value="{{ old('email') }}">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>

          <!-- Campo de Contraseña -->
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>

          <!-- Recuerda el Usuario -->
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">
                  Recuerdame
                </label>
              </div>
            </div>
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
            </div>
          </div>
        </form>

        <p class="mb-1">
          <a href="{{ asset('forgot-password') }}">Olvidé mi contraseña</a>
        </p>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="../../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../../dist/js/adminlte.min.js"></script>
</body>

</html>
