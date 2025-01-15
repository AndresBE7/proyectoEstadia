@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Calendario Escolar</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div id="calendar"></div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
</div>

<link href='public/fullcalendar/core/main.css' rel='stylesheet' />
    <link href='public/fullcalendar/daygrid/main.css' rel='stylesheet' />

    <script src='public/fullcalendar/core/main.js'></script>
    <script src='public/fullcalendar/daygrid/main.js'></script>

    <script>

        document.addEventListener('DOMContentLoaded', function() {
          var calendarEl = document.getElementById('calendar');
  
          var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: [ 'dayGrid' ]
          });
  
          calendar.render();
        });
  
      </script>

@endsection

