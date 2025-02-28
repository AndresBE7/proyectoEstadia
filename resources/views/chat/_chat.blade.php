<ul class="m-b-0">
    @forelse ($messages as $message)
        @if ($message->sender_id == Auth::id())
            <!-- Mensaje enviado por el usuario actual -->
            <li class="clearfix">
                <div class="message-data text-right">
                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">
                </div>
                <div class="message other-message float-right">{{ $message->message }}</div>
            </li>
        @else
            <!-- Mensaje recibido -->
            <li class="clearfix">
                <div class="message-data">
                    <span class="message-data-time">{{ $message->created_date->format('h:i A, d M') }}</span>
                </div>
                <div class="message my-message">{{ $message->message }}</div>
            </li>
        @endif
    @empty
        <li>No hay mensajes aún.</li>
    @endforelse
</ul>

<script type="text/javascript">
    function loadMessages() {
        const receiverId = document.querySelector('input[name="receiver_id"]').value;
        const chatMessages = document.getElementById('chat-messages');
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

    // Cargar mensajes inicialmente y luego cada 5 segundos
    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('chat-messages')) {
            loadMessages();
            setInterval(loadMessages, 5000); // Actualizar cada 5 segundos
        }
    });
</script>