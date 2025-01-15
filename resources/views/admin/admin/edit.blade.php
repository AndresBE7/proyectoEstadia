@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Editar administrador</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row align-items-center w-100">
        <!-- Formulario centrado -->
        <div class="col-md-8 col-lg-12">
          <!-- General form elements -->
          <div class="card card-primary">
            <!-- Form header -->
            <div class="card-header">
              <h3 class="card-title">Editar</h3>
            </div>

            <!-- Form start -->
            <form method="post" action="">
                {{ csrf_field() }}
              
                <div class="card-body">
                  <!-- Campo Nombre -->
                  <div class="form-group">
                    <label for="exampleInputName">Nombre</label>
                    <input type="text" name="name" class="form-control" value="{{$getRecord->name}}" placeholder="Ingresa tu nombre">
                  </div>
              
                  <!-- Campo Correo Electrónico -->
                  <div class="form-group">
                    <label for="exampleInputEmail1">Correo electrónico</label>
                    <input type="email" name="email" class="form-control" value="{{$getRecord->email}}" placeholder="Ingresa tu correo">
                  </div>
              
                  <!-- Campo Contraseña -->
                  <div class="form-group">
                    <label for="exampleInputPassword1">Contraseña</label>
                    <input type="text" name="password" class="form-control" placeholder="Contraseña">
                  </div>
                </div>
              
                <!-- Form footer -->
                <div class="card-footer text-center">
                  <button type="submit" class="btn btn-primary">Enviar</button>
                  <a href="{{ url('admin/admin/list') }}" class="btn btn-secondary">Volver</a>
                </div>
              </form>
              
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
