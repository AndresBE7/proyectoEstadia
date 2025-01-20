@extends('layouts.app')

@section('style')
<!-- FullCalendar styles -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f6f9;
    }
    .content-wrapper {
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
        color: #343a40;
        font-weight: 700;
    }
    #calendar {
        max-width: 1100px;
        margin: 0 auto;
        padding: 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .fc-toolbar {
        background-color: #007bff;
        color: white;
        padding: 10px;
        border-radius: 8px 8px 0 0;
    }
    .fc-button {
        background: white;
        color: #007bff;
        border: none;
        border-radius: 5px;
        padding: 5px 10px;
    }
    .fc-button:hover {
        background: #0056b3;
        color: white;
    }
    .fc-daygrid-day {
        background-color: #f8f9fa;
    }
    .fc-day-today {
        background-color: #e9ecef !important;
    }
    .fc-event {
        background-color: #007bff;
        border: none;
        border-radius: 5px;
        color: white;
        padding: 5px;
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Calendario Escolar</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div id="calendar-wrap">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
<!-- FullCalendar scripts -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            editable: true,
            height: 'auto',
            expandRows: true,
            selectable: true,
            selectMirror: true,
            
            select: function(arg) {
                var title = prompt('Título del Evento:');
                if (title) {
                    calendar.addEvent({
                        title: title,
                        start: arg.start,
                        end: arg.end,
                        allDay: arg.allDay
                    });
                }
                calendar.unselect();
            },
            
            eventClick: function(arg) {
                if (confirm('¿Estás seguro de que quieres eliminar este evento?')) {
                    arg.event.remove();
                }
            },
            
            dayMaxEvents: true,
            
            events: [
                {
                    title: 'Evento de Todo el Día',
                    start: '2024-01-01'
                },
                {
                    title: 'Evento Largo',
                    start: '2024-01-07',
                    end: '2024-01-10'
                },
                {
                    title: 'Reunión',
                    start: '2024-01-12T10:30:00',
                    end: '2024-01-12T12:30:00'
                }
            ]
        });
        
        calendar.render();
    });
</script>
@endsection
