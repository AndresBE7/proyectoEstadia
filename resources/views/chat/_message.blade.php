<div class="chat-header clearfix">
    @include('chat._header')
</div>

<div class="chat-history" id="chat-messages">
    @include('chat._chat')
</div>

<div class="chat-message clearfix">
    <form id="submit_message" method="POST" class="mb-0">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $getReceiver->id }}">
        <div class="input-group mb-0">
            <textarea name="message" class="form-control" placeholder="Escribe tu mensaje..." rows="3" required></textarea>
            <div class="row mt-2">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const messageForm = document.getElementById('submit_message');
        const chatMessages = document.getElementById('chat-messages');
    
        if (messageForm) {
            messageForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const submitButton = this.querySelector('button[type="submit"]');
                const textarea = this.querySelector('textarea');
                
                // Deshabilitar el botón mientras se envía
                submitButton.disabled = true;
                
                // Enviar el mensaje
                fetch('{{ route("submit_message") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Limpiar el textarea
                        textarea.value = '';
                        
                        // Agregar el mensaje al chat
                        const newMessage = `
                            <li class="clearfix">
                                <div class="message-data text-right">
                                    <span class="message-data-time">${new Date().toLocaleTimeString()}</span>
                                </div>
                                <div class="message other-message float-right">
                                    ${data.message.message}
                                </div>
                            </li>
                        `;
                        
                        // Encontrar el ul en chat-messages y agregar el mensaje
                        const messagesList = chatMessages.querySelector('ul');
                        if (messagesList) {
                            messagesList.insertAdjacentHTML('beforeend', newMessage);
                            
                            // Scroll al final del chat
                            chatMessages.scrollTop = chatMessages.scrollHeight;
                        }
                    } else {
                        alert('Error al enviar el mensaje');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al enviar el mensaje');
                })
                .finally(() => {
                    // Rehabilitar el botón
                    submitButton.disabled = false;
                });
            });
        }
    });
    </script>