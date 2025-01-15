@extends('layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Cambiar Contraseña</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- Left column -->
          <div class="col-md-12">
            <div class="card card-primary">
              <!-- Form start -->
              <form method="post" action="{{ url('admin/change_password') }}">
                @csrf
                <div class="card-body">
                  <!-- Campo para la contraseña anterior -->
                  <div class="form-group">
                    <label for="old_password">Contraseña anterior</label>
                    <input type="password" class="form-control" name="old_password" required placeholder="Contraseña anterior">
                  </div>

                  <!-- Campo para la nueva contraseña -->
                  <div class="form-group">
                    <label for="new_password">Nueva contraseña</label>
                    <input type="password" class="form-control" name="new_password" required placeholder="Nueva contraseña">
                  </div>

                  <!-- Campo para confirmar la nueva contraseña -->
                  <div class="form-group">
                    <label for="new_password_confirmation">Confirmar nueva contraseña</label>
                    <input type="password" class="form-control" name="new_password_confirmation" required placeholder="Confirmar nueva contraseña">
                  </div>
                </div>

                <!-- Card footer -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Actualizar</button>
                  <a href="{{ url()->previous() }}" class="btn btn-secondary">Regresar</a>
                </div>
              </form>
            </div>
          </div>
          <!-- /.col (left) -->
        </div>
      </div>
    </section>
  </div>
@endsection
