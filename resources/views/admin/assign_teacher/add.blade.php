@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Agregar Asignación</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row align-items-center w-100">
            <div class="col-md-8 col-lg-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Registrar</h3>
                    </div>

                    <form method="post" action="{{ url('admin/assign_teacher/insert') }}">
                        {{ csrf_field() }}

                        <div class="card-body">
                            <div class="form-group">
                                <label for="class_id">Selección de grupo</label>
                                <select class="form-control @error('class_id') is-invalid @enderror" name="class_id">
                                    <option value="">Selecciona el grupo</option>
                                    @foreach ($getClass as $class)
                                        <option value="{{$class->id}}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{$class->nombre}}</option>
                                    @endforeach
                                </select>
                                @error('class_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Selecciona los maestros</label>
                                @foreach($getTeacher as $teacher)
                                    <div>
                                        <label style="font-weight: normal;">
                                            <input type="checkbox" value="{{ $teacher->id }}" name="teacher_id[]" {{ in_array($teacher->id, old('teacher_id', [])) ? 'checked' : '' }}> {{ $teacher->name }} ({{ $teacher->email }})
                                        </label>
                                    </div>
                                @endforeach
                                @error('teacher_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                    <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Active</option>
                                    <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-primary">Registrar asignación</button>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">Regresar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection