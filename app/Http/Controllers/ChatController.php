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
            
            // Obtener mensajes entre los usuarios
            $data['messages'] = ChatModel::where(function($query) use ($sender_id, $receiver_id) {
                $query->where('sender_id', $sender_id)
                      ->where('receiver_id', $receiver_id);
            })->orWhere(function($query) use ($sender_id, $receiver_id) {
                $query->where('sender_id', $receiver_id)
                      ->where('receiver_id', $sender_id);
            })->orderBy('created_date', 'asc')->get();
        }
        
        return view('chat.list', $data);
    }

    public function submit_message(Request $request)
    {
        try {
            // Validación más robusta
            $validated = $request->validate([
                'message' => 'required|string|max:1000',
                'receiver_id' => 'required|integer|exists:users,id'
            ]);

            // Verificar que el receptor existe y no es el mismo usuario
            $receiver = User::find($validated['receiver_id']);
            if (!$receiver || $receiver->id === Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Receptor inválido'
                ], 400);
            }

            // Crear el mensaje con try/catch específico para la base de datos
            try {
                $chat = new ChatModel();
                $chat->sender_id = Auth::id();
                $chat->receiver_id = $validated['receiver_id'];
                $chat->message = $validated['message'];
                $chat->created_date = now();
                $chat->save();
            } catch (\Exception $e) {
                Log::error('Error al guardar mensaje en DB: ' . $e->getMessage());
                throw new \Exception('Error al guardar el mensaje en la base de datos');
            }

            // Obtener el mensaje formateado para la respuesta
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

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error en submit_message: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }
}