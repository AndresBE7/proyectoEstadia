@extends('layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Editar Asignación</h1>
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
              <h3 class="card-title">Editar asignación</h3>
            </div>

            <!-- Form start -->
            <form method="post" action="{{ url('admin/assign_subject/update/' . $getRecord->id) }}">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $getRecord->id }}">

              <div class="card-body">
                <!-- Campo Selección de grupo -->
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

                <!-- Campo Selección de materias -->
                <div class="form-group">
                  <label>Selecciona las materias</label>
                  @foreach($getSubject as $subject)
                    @php
                      $checked = "";
                    @endphp
                    @foreach ($getAssignSubjectId as $subjectAssign)
                      @if ($subjectAssign->subject_id == $subject->id)
                        @php
                          $checked = "checked";
                        @endphp
                      @endif
                    @endforeach
                    <div>
                      <label style="font-weight: normal;">
                        <input {{$checked}} type="checkbox" value="{{ $subject->id }}" name="subject_id[]"> {{ $subject->nombre }}
                      </label>
                    </div>
                  @endforeach
                  @error('subject_id')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>

                <!-- Campo Status -->
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

              <!-- Form footer -->
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
