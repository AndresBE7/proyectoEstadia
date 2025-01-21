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
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>

    async function summitEvents(title, arg){
        const start = new Date(arg.startStr).toISOString().slice(0, 19).replace('T', ' ');
        const end = new Date(arg.endStr).toISOString().slice(0, 19).replace('T', ' ');

        try{
            const response = await axios.post('/add-date',
            {

                title: title,
                start: start,
                end: end,
                allDay: arg.allDay
            });
            console.log(response.data); 
            return resonse.data;
        }catch(error){
            console.log(error);
            return null;
        }
    }

    async function getEvents(){
        try{
            const response = await axios.get('/get-all-date');
            console.log(response.data);
            return response.data;
        }catch(error){
            console.log(error);
            return null;
        }
    }

</script>

<script>
    
    document.addEventListener('DOMContentLoaded', async function() {
        var calendarEl = document.getElementById('calendar');
        try{
            const newEvents = await getEvents();
            console.log(newEvents);

            
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
                timeZone: 'UTC',
                events: newEvents,
                select: async function(arg) {
                    var title = prompt('Título del Evento:');
                    if (title) {
                        calendar.addEvent({
                            title: title,
                            start: arg.start,
                            end: arg.end,
                            allDay: arg.allDay
                        });
                        try{
                           summitEvents(title, arg);
                           const newEvents = await getEvents();
                           calendar.addEvents(newEvents);
                            
                        }catch(error){
                            calendar.unselect();
                            console.error(error);
                        }
                    }
                    
                    calendar.unselect();
                },
                
                eventClick: function(arg) {
                    console.log(arg.event.id);
                    if (confirm('¿Estás seguro de que quieres eliminar este evento?')) {
                        try{

                            axios.delete('/delete-date/' + arg.event.id);
                            arg.event.remove();
                        }catch(error){
                            console.error(error);
                        }
                    }
                },
                
                dayMaxEvents: true
                
                
            });
    
            
            calendar.render();
        }catch(error){
            console.error(error);
        }
        
        
    });
</script>
@endsection
