@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="font-weight-bold text-primary">Relación Tutores - Alumnos</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('_messages')

                    <!-- Tabla de Tutores -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white rounded-top">
                            <h3 class="card-title">Lista de Tutores</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-hover table-striped">
                                <thead class="bg-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Correo Electrónico</th>
                                        <th>Número de Contacto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($tutores as $tutor)
                                    <tr>
                                        <td>{{ $tutor->id }}</td>
                                        <td>{{ $tutor->name }}</td>
                                        <td>{{ $tutor->email }}</td>
                                        <td>{{ $tutor->contact_number }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No se encontraron tutores</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Paginación -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $tutores->appends(['search' => request('search')])->links() }}
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
@endsection
