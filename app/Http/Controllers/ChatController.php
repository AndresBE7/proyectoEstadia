<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ChatModel; 
use App\Models\User; 

class ChatController extends Controller
{
    public function chat(Request $request)
    {
        $data['header_title'] = "Mi Chat";
        $sender_id = Auth::user()->id;  

        if (!empty($request->receiver_id)) {
            $receiver_id = base64_decode($request->receiver_id);
            if($receiver_id == $sender_id){
                return redirect()->back()->with('error', 'Error al enviar mensaje');
                //exit();
            }
            $data['getReceiver'] = User::getSingle($receiver_id);
    }
    return view ('chat.list', $data);
}
    
public function submit_message(Request $request){
        $receiverId = base64_decode($request->receiver_id);
        $request->merge(['receiver_id' => $receiverId]);
        
        $request->validate([
            'receiver_id' => 'required|integer|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);
        
        
        $chat = new ChatModel;
        $chat->sender_id = Auth::user()->id;
        $chat->receiver_id = $request->receiver_id;
        $chat->message = $request->message;
        $chat->created_date = now();
        $chat->save();

        $json['succes'] = true;
        echo json_encode($json);
        return response()->json(['success' => true]);    
    }
}
