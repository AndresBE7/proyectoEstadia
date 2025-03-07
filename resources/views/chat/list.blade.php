@extends('layouts.app')
@section('style')
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
<style type="text/css"> 
.card {
    background: #fff;
    transition: .5s;
    border: 0;
    margin-bottom: 30px;
    border-radius: .55rem;
    position: relative;
    width: 100%;
    box-shadow: 0 1px 2px 0 rgb(0 0 0 / 10%);
}
.chat-app .people-list {
    width: 280px;
    position: absolute;
    left: 0;
    top: 0;
    padding: 20px;
    z-index: 7;
    background: #fff
}

.chat-app .chat {
    margin-left: 280px;
    border-left: 1px solid #eaeaea
}

.people-list {
    -moz-transition: .5s;
    -o-transition: .5s;
    -webkit-transition: .5s;
    transition: .5s
}

.people-list .chat-list li {
    padding: 10px 15px;
    list-style: none;
    border-radius: 3px
}

.people-list .chat-list li:hover {
    background: #efefef;
    cursor: pointer
}

.people-list .chat-list li.active {
    background: #efefef
}

.people-list .chat-list li .name {
    font-size: 15px
}

.people-list .chat-list img {
    width: 45px;
    border-radius: 50%
}

.people-list img {
    float: left;
    border-radius: 50%
}

.people-list .about {
    float: left;
    padding-left: 8px
}

.people-list .status {
    color: #999;
    font-size: 13px
}

.chat .chat-header {
    padding: 15px 20px;
    border-bottom: 2px solid #f4f7f6
}

.chat .chat-header img {
    float: left;
    border-radius: 40px;
    width: 40px
}

.chat .chat-header .chat-about {
    float: left;
    padding-left: 10px
}

.chat .chat-history {
    padding: 20px;
    border-bottom: 2px solid #fff
}

.chat .chat-history ul {
    padding: 0
}

.chat .chat-history ul li {
    list-style: none;
    margin-bottom: 30px
}

.chat .chat-history ul li:last-child {
    margin-bottom: 0px
}

.chat .chat-history .message-data {
    margin-bottom: 15px
}

.chat .chat-history .message-data img {
    border-radius: 40px;
    width: 40px
}

.chat .chat-history .message-data-time {
    color: #434651;
    padding-left: 6px
}

.chat .chat-history .message {
    color: #444;
    padding: 18px 20px;
    line-height: 26px;
    font-size: 16px;
    border-radius: 7px;
    display: inline-block;
    position: relative
}

.chat .chat-history .message:after {
    bottom: 100%;
    left: 7%;
    border: solid transparent;
    content: " ";
    height: 0;
    width: 0;
    position: absolute;
    pointer-events: none;
    border-bottom-color: #fff;
    border-width: 10px;
    margin-left: -10px
}

.chat .chat-history .my-message {
    background: #efefef
}

.chat .chat-history .my-message:after {
    bottom: 100%;
    left: 30px;
    border: solid transparent;
    content: " ";
    height: 0;
    width: 0;
    position: absolute;
    pointer-events: none;
    border-bottom-color: #efefef;
    border-width: 10px;
    margin-left: -10px
}

.chat .chat-history .other-message {
    background: #e8f1f3;
    text-align: right
}

.chat .chat-history .other-message:after {
    border-bottom-color: #e8f1f3;
    left: 93%
}

.chat .chat-message {
    padding: 20px
}

.online,
.offline,
.me {
    margin-right: 2px;
    font-size: 8px;
    vertical-align: middle
}

.online {
    color: #86c541
}

.offline {
    color: #e47297
}

.me {
    color: #1d8ecd
}

.float-right {
    float: right
}

.clearfix:after {
    visibility: hidden;
    display: block;
    font-size: 0;
    content: " ";
    clear: both;
    height: 0
}

@media only screen and (max-width: 767px) {
    .chat-app .people-list {
        height: 465px;
        width: 100%;
        overflow-x: auto;
        background: #fff;
        left: -400px;
        display: none
    }
    .chat-app .people-list.open {
        left: 0
    }
    .chat-app .chat {
        margin: 0
    }
    .chat-app .chat .chat-header {
        border-radius: 0.55rem 0.55rem 0 0
    }
    .chat-app .chat-history {
        height: 300px;
        overflow-x: auto
    }
}

@media only screen and (min-width: 768px) and (max-width: 992px) {
    .chat-app .chat-list {
        height: 650px;
        overflow-x: auto
    }
    .chat-app .chat-history {
        height: 600px;
        overflow-x: auto
    }
}

@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape) and (-webkit-min-device-pixel-ratio: 1) {
    .chat-app .chat-list {
        height: 480px;
        overflow-x: auto
    }
    .chat-app .chat-history {
        height: calc(100vh - 350px);
        overflow-x: auto
    }
}
</style>


@endsection
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chat</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <!-- Puedes agregar botones adicionales aquí si los necesitas -->
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Columna izquierda: Lista de Usuarios -->
                <div class="col-lg-4 col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Lista de Usuarios</h3>
                        </div>
                        <div class="card-body">
                            <!-- Barra de búsqueda -->
                            <div class="mb-3">
                                <form method="GET" action="{{ url('chat/search') }}" class="form-inline">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control" placeholder="Buscar usuario..." value="{{ request()->get('search') }}">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary">Buscar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Lista de usuarios -->
                            <ul class="list-unstyled chat-list mt-2 mb-0">
                                @include('chat._user')
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Columna derecha: Chat -->
                <div class="col-lg-8 col-md-7">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Mensajes</h3>
                        </div>
                        <div class="card-body chat">
                            @if(!empty($getReceiver))
                                @include('chat._message')
                            @else
                                <div class="text-center">
                                    <p class="text-muted">Selecciona un usuario para iniciar una conversación.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
    const messageForm = document.getElementById('submit_message');
    const chatMessages = document.getElementById('chat-messages');

    // Función para cargar mensajes dinámicamente
    function loadMessages() {
        if (!chatMessages) return; // Salir si no hay chat abierto
        const receiverId = document.querySelector('input[name="receiver_id"]').value;
        const messagesList = chatMessages.querySelector('ul');

        axios.get(`/chat/messages?receiver_id=${receiverId}`)
            .then(response => {
                if (response.data.success) {
                    messagesList.innerHTML = ''; // Limpiar mensajes actuales
                    response.data.messages.forEach(msg => {
                        const isSender = msg.sender_id === {{ Auth::id() }};
                        const messageHtml = `
                            <li class="clearfix">
                                <div class="message-data ${isSender ? 'text-right' : ''}">
                                    <span class="message-data-time">${new Date(msg.created_date).toLocaleTimeString()}</span>
                                    ${isSender ? '<img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">' : ''}
                                </div>
                                <div class="message ${isSender ? 'other-message float-right' : 'my-message'}">
                                    ${msg.message}
                                </div>
                            </li>
                        `;
                        messagesList.insertAdjacentHTML('beforeend', messageHtml);
                    });
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            })
            .catch(error => console.error('Error al cargar mensajes:', error));
    }

    // Cargar mensajes inicialmente y cada 5 segundos si hay un chat abierto
    if (chatMessages) {
        loadMessages();
        setInterval(loadMessages, 5000);
    }

    // Manejar el envío de mensajes
    if (messageForm) {
        messageForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            const textarea = this.querySelector('textarea');

            submitButton.disabled = true;

            try {
                const response = await axios.post("{{ route('submit_message') }}", formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (response.data.success) {
                    textarea.value = '';
                    loadMessages(); // Recargar mensajes inmediatamente después de enviar
                } else {
                    alert('Error al enviar el mensaje: ' + response.data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al enviar el mensaje');
            } finally {
                submitButton.disabled = false;
            }
        });
    }
});
</script>
@endsection
