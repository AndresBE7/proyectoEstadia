@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Editar Asignación</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row align-items-center w-100">
            <div class="col-md-8 col-lg-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Editar asignación</h3>
                    </div>

                    <form method="post" action="{{ url('admin/assign_teacher/update/' . $getRecord->id) }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $getRecord->id }}">

                        <div class="card-body">
                            <div class="form-group">
                                <label for="class_id">Selección de grupo</label>
                                <select class="form-control @error('class_id') is-invalid @enderror" name="class_id">
                                    <option value="">Selecciona el grupo</option>
                                    @foreach ($getClass as $class)
                                        <option {{ ($getRecord->class_id == $class->id) ? 'selected' : ''}} value="{{ $class->id }}">
                                            {{$class->nombre}}
                                        </option>
                                    @endforeach
                                </select>
                                @error('class_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Selecciona los maestros</label>
                                @foreach($getTeacher as $teacher)
                                    @php
                                        $checked = "";
                                    @endphp
                                    @foreach ($getAssignTeacherId as $teacherAssign)
                                        @if ($teacherAssign->teacher_id == $teacher->id)
                                            @php
                                                $checked = "checked";
                                            @endphp
                                        @endif
                                    @endforeach
                                    <div>
                                        <label style="font-weight: normal;">
                                            <input {{$checked}} type="checkbox" value="{{ $teacher->id }}" name="teacher_id[]"> {{ $teacher->name }} ({{ $teacher->email }})
                                        </label>
                                    </div>
                                @endforeach
                                @error('teacher_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control @error('status') is-invalid @enderror" name="status">
                                    <option {{($getRecord->status == 0) ? 'selected' : ''}} value="0">Active</option>
                                    <option {{($getRecord->status == 1) ? 'selected' : ''}} value="1">Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-primary">Actualizar asignación</button>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">Regresar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection