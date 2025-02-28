<!-- views/chat/_message.blade.php -->
<div class="chat-header clearfix">
    <div class="row">
        <div class="col-lg-6">
            <div class="chat-about">
                <h6 class="m-b-0">{{ $getReceiver->name }}</h6>
                <small>Última vez activo: {{ $getReceiver->updated_at->diffForHumans() }}</small>
            </div>
        </div>
    </div>
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

@section('script')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
    const messageForm = document.getElementById('submit_message');
    const chatMessages = document.getElementById('chat-messages');

    if (messageForm && chatMessages) {
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

                    const newMessage = `
                        <li class="clearfix">
                            <div class="message-data text-right">
                                <span class="message-data-time">${new Date().toLocaleTimeString()}</span>
                            </div>
                            <div class="message other-message float-right">
                                ${response.data.message.message}
                            </div>
                        </li>
                    `;

                    const messagesList = chatMessages.querySelector('ul');
                    if (messagesList) {
                        messagesList.insertAdjacentHTML('beforeend', newMessage);
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    }
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