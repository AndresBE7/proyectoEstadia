<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Recuperar contraseña</title>

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
      text-align: center;
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
      font-size: 16px;
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

    .login-box-msg {
      font-size: 18px;
      color: #333;
      text-align: center;
      margin-bottom: 20px;
    }

    .form-text {
      font-size: 14px;
      color: #6c757d;
      text-align: center;
    }
  </style>
</head>

<body class="hold-transition login-page">

  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <h2>Colegio Vida</h2>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Ingresa tu nueva contraseña</p>

        <!-- Mostrar error de credenciales -->
        @if ($errors->has('error'))
          <div class="alert alert-danger">
            {{ $errors->first('error') }}
          </div>
        @endif

        <form action="" method="post">
          {{ csrf_field() }}

        <!-- Campo de Contraseña -->
          <div class="input-group mb-3">
            <input type="password" class="form-control" required name="password" placeholder="Contraseña">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>


          <!-- Campo de Email -->
          <div class="input-group mb-3">
            <input type="password" class="form-control" required name="password" placeholder="Confirma contraseña">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>

          <!-- Botón para enviar -->
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Guardar</button>
            </div>
          </div>
        </form>

        <p class="mt-3 form-text">
          <a href="{{ asset('/') }}">Volver al inicio de sesión</a>
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
