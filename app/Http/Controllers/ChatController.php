<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ChatModel;
use App\Models\User;
use Illuminate\Support\Facades\Log;


class ChatController extends Controller
{
    public function chat(Request $request)
    {
        $data['header_title'] = "Mi Chat";
        $sender_id = Auth::user()->id;
    
        if (!empty($request->receiver_id)) {
            $receiver_id = base64_decode($request->receiver_id);
            if ($receiver_id == $sender_id) {
                return redirect()->back()->with('error', 'Error al enviar mensaje');
            }
            $data['getReceiver'] = User::getSingle($receiver_id);
            
            $data['messages'] = ChatModel::where(function($query) use ($sender_id, $receiver_id) {
                $query->where('sender_id', $sender_id)
                      ->where('receiver_id', $receiver_id);
            })->orWhere(function($query) use ($sender_id, $receiver_id) {
                $query->where('sender_id', $receiver_id)
                      ->where('receiver_id', $sender_id);
            })->orderBy('created_at', 'asc')->get(); // Cambié a created_at
        }
        
        return view('chat.list', $data);
    }

    public function submit_message(Request $request)
    {
        try {
            Log::info('Datos recibidos en submit_message:', $request->all());
    
            $validated = $request->validate([
                'message' => 'required|string|max:1000',
                'receiver_id' => 'required|integer|exists:users,id'
            ]);
    
            $receiver = User::find($validated['receiver_id']);
            if (!$receiver || $receiver->id === Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Receptor inválido'
                ], 400);
            }
    
            $chat = new ChatModel();
            $chat->sender_id = Auth::id();
            $chat->receiver_id = $validated['receiver_id'];
            $chat->message = $validated['message'];
            $chat->status = 0; // Valor por defecto para status
            $chat->created_date = now();
            $chat->save();
    
            $formattedMessage = [
                'id' => $chat->id,
                'message' => $chat->message,
                'created_date' => $chat->created_date->format('Y-m-d H:i:s'),
                'sender' => [
                    'id' => Auth::id(),
                    'name' => Auth::user()->name
                ]
            ];
    
            return response()->json([
                'success' => true,
                'message' => $formattedMessage
            ]);
        } catch (\Exception $e) {
            Log::error('Error en submit_message: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el mensaje: ' . $e->getMessage()
            ], 500);
        }
    }

    public function seeMessage(Request $request)
    {
        try {
            $userId = Auth::id();
            $unreadMessages = ChatModel::where('receiver_id', $userId)
                ->where('status', 0) // Suponiendo que status=0 significa "no leído"
                ->with('sender') // Cargar relación con el remitente
                ->orderBy('created_at', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'unread_messages' => $unreadMessages
            ]);
        } catch (\Exception $e) {
            Log::error('Error en seeMessage: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener mensajes no leídos: ' . $e->getMessage()
            ], 500);
        }
    }

// ChatController.php
    public function getMessages(Request $request)
    {
        $sender_id = Auth::id();
        $receiver_id = $request->query('receiver_id');

        $messages = ChatModel::where(function($query) use ($sender_id, $receiver_id) {
            $query->where('sender_id', $sender_id)
                ->where('receiver_id', $receiver_id);
        })->orWhere(function($query) use ($sender_id, $receiver_id) {
            $query->where('sender_id', $receiver_id)
                ->where('receiver_id', $sender_id);
        })->orderBy('created_at', 'asc')->get();

        return response()->json([
            'success' => true,
            'messages' => $messages->map(function($msg) {
                return [
                    'id' => $msg->id,
                    'sender_id' => $msg->sender_id,
                    'receiver_id' => $msg->receiver_id,
                    'message' => $msg->message,
                    'created_date' => $msg->created_date->toDateTimeString(),
                ];
            })
        ]);
    }
}