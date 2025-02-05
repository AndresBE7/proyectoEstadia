<div class="chat-header clearfix">
    @include('chat._header')
</div>

<div class="chat-history">
    @include('chat._chat')
</div>

<div class="chat-message clearfix">
    <div class="input-group mb-0">
    <form action="{{ route('submit_message') }}" id="submit_message" method="POST" class="mb-0">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $getReceiver->id }}">
        
        <textarea name="message" class="form-control" placeholder="Escribe tu mensaje..." rows="3"></textarea>
        <div class="row">
            <div class="col-md-6"> </div>
            <div class="col-md-6" style="text-align: right;"><button class="btn btn-primary">Enviar</button></div>
            </div>
        </div>
    </form>  
</div>