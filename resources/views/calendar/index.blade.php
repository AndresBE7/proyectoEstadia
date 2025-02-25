@extends('layouts.app')

@section('style')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif;
        }
        .content-wrapper {
            background: white;
            padding: 20px;
        }
        #calendar {
            max-width: 1100px;
            margin: 0 auto;
            padding: 20px;
        }
        .fc-toolbar {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border-radius: 3px;
        }
        .fc-button {
            background: white !important;
            color: #007bff !important;
            border: none !important;
            box-shadow: none !important;
            padding: 5px 10px !important;
        }
        .fc-button:hover {
            background: #0056b3 !important;
            color: white !important;
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
            border-radius: 3px;
            color: white;
            padding: 2px;
            cursor: pointer;
        }
        .fc-event:hover {
            background-color: #0056b3;
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
            <div class="card">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>

            @if($isAdmin)
                <div class="card mt-3">
                    <div class="card-body">
                        <button id="addEventBtn" class="btn btn-primary">Agregar Evento</button>
                        <div id="addEventForm" style="display: none;" class="mt-3">
                            <form action="{{ route('calendar.store_event') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="title">Título del Evento</label>
                                    <input type="text" id="title" name="title" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="start">Fecha de inicio</label>
                                    <input type="datetime-local" id="start" name="start" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="end">Fecha de fin</label>
                                    <input type="datetime-local" id="end" name="end" class="form-control">
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="all_day" name="all_day" value="1">
                                        <label class="custom-control-label" for="all_day">Todo el día</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Guardar Evento</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
</div>

<!-- Modal para detalles del evento -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Detalles del Evento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4 id="eventTitle"></h4>
                <p><strong>Inicio:</strong> <span id="eventStart"></span></p>
                <p><strong>Fin:</strong> <span id="eventEnd"></span></p>
                <p><strong>Todo el día:</strong> <span id="eventAllDay"></span></p>

                @if($isAdmin)
                    <form id="deleteEventForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" id="eventId" name="eventId" value=""/>
                        <button type="button" id="deleteEventBtn" class="btn btn-danger">Eliminar Evento</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const eventModal = document.getElementById('eventModal');
            const eventTitle = document.getElementById('eventTitle');
            const eventStart = document.getElementById('eventStart');
            const eventEnd = document.getElementById('eventEnd');
            const eventAllDay = document.getElementById('eventAllDay');
            const eventIdInput = document.getElementById('eventId');
            const deleteEventBtn = document.getElementById('deleteEventBtn');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: @json($events),
                eventClick: function(info) {
                    // Llenar el modal con los detalles del evento
                    eventTitle.textContent = info.event.title;
                    eventStart.textContent = info.event.start.toLocaleString('es-ES');
                    eventEnd.textContent = info.event.end ? info.event.end.toLocaleString('es-ES') : 'No definido';
                    eventAllDay.textContent = info.event.allDay ? 'Sí' : 'No';
                    eventIdInput.value = info.event.id;

                    // Mostrar el modal
                    $('#eventModal').modal('show');
                }
            });

            calendar.render();

            // Mostrar formulario de agregar evento
            document.getElementById('addEventBtn').addEventListener('click', function() {
                document.getElementById('addEventForm').style.display = 'block';
            });

            // Eliminar evento desde el botón del modal
            deleteEventBtn.addEventListener('click', function() {
                const eventId = eventIdInput.value;

                if (confirm('¿Estás seguro de que deseas eliminar este evento?')) {
                    axios.delete('/calendar/delete/' + eventId)
                        .then(function(response) {
                            if (response.status === 200) {
                                const event = calendar.getEventById(eventId);
                                if (event) {
                                    event.remove();
                                }
                                $('#eventModal').modal('hide');
                                alert('Evento eliminado correctamente.');
                            } else {
                                alert('Error al eliminar el evento.');
                            }
                        })
                        .catch(function(error) {
                            console.error("Error en la solicitud de eliminación:", error);
                            alert('Hubo un problema al eliminar el evento.');
                        });
                }
            });
        });
    </script>
@endsection