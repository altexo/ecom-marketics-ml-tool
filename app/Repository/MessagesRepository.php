<?php

namespace App\Repository;
use App\Messages;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Log;

class MessagesRepository{
    private $messages;
    public function __construct()
    {
        //$this->messages = $messages;
    }

    public function saveMessages($message, $ml_order_id): void{
        //  return json_decode($message['conversation_status']);
        $this->messages = new Messages;
        try {
            $this->messages->order_ml_order_id = $ml_order_id;
            $this->messages->conversation = json_encode($message['messages']);
            $this->messages->conversation_status = json_encode([$message['conversation_status']]);
            $this->messages->save();
            Log::debug('Message with id: ? Saved. ');
        }catch(\Exception $e){
            Log::error('Error while saving message of '.$ml_order_id.' : '.$e->getMessage().': ', [$message]);
        }
        
      
    }

    public function updateMessage(string $order_ml_order_id, $newMessage, string $status = 'unread'): bool{
        
        $message = Messages::where('order_ml_order_id', $order_ml_order_id)->first();
        try{
            $message->status = $status;
            $message->conversation = $newMessage['messages'];
            $message->conversation_status = json_encode([$newMessage['conversation_status']]);
            $message->save();

        }catch(\Exception $e){
            Log::error('Error while updating message of '.$order_ml_order_id.' : '.$e->getMessage().': ', [$message]);
            return false;
        }
        return true;
    }
    public function updateMessageState(string $order_ml_order_id, string $status = 'read'): void{

    }

    public function getLocalMessageById(string $ml_order_id): Messages{

        $this->messages = Messages::where('order_ml_order_id', $ml_order_id)->first();

        return $this->messages;
        // return $this->messages::where('order');
    }
}