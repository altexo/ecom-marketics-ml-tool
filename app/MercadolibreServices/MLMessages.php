<?php

namespace App\MercadolibreServices;
use App\MercadolibreServices\Meli;
use App\Repository\MessagesRepository;
use App\Messages;
use App\MercadolibreServices\MeliToken;
use App\Ml_account;
use App\Orders;
use Illuminate\Support\Facades\DB;
class MLMessages{

    private $meli; 
    private $messagesRepository;
    public function __construct(){
        $this->meli = new Meli(ENV('APP_ID'), ENV('APP_SECRET_KEY'));
        $this->messagesRepository = new MessagesRepository(new Messages);
    }

    public function getMessagesByOrder(string $token, string $pack_id, string $ml_user_id, int $offset = 0){
        $params = ['access_token'=> $token, 'offset'=> $offset];
        return $this->meli->get('messages/packs/'.$pack_id.'/sellers/'.$ml_user_id, $params, true);
    }
    public function getMessagesByPack(string $token, string $pack_id){
        $params = ['access_token'=> $token];
        return $this->meli->get('messages/'.$pack_id, $params, true);
    }

    public function syncMessagesFromOrder($token, $pack_id, $ml_user_id){
        $message = $this->getMessagesByOrder($token, $pack_id, $ml_user_id);
        if($message['httpCode']==200){
            return $this->messagesRepository->saveMessages($message['body'], $pack_id);
        }
    }

    public function getUnreadMessages(string $ml_token, string $ml_user_id){
        $params = array('access_token' => $ml_token, 'role'=>'seller');
        $messages = $this->validateResponseStatus($this->meli->get('/messages/unread', $params, true),$ml_token);
    
        if($messages['error'] != false){
            if ($messages['token'] != null){
                $this->getUnreadMessages($messages['token'], $ml_user_id);
            }
            
        }else{
            if(count($messages['response']['results']) > 0){
                //return $messages[];
                foreach($messages['response']['results'] as $m){
                    $params = ['access_token' => $ml_token];
                    $messagePack = $this->getMessagesByPack($ml_token, $m['resource']);
                    $messagePack['body'];
                    $order_ml_order_id = explode("/",$m['resource']);
                    $this->messagesRepository->updateMessage($order_ml_order_id[2], $messagePack['body'], 'unread');
                }

                $orders = Orders::with(['messages' => function($query){
                    $query->where('status', '=', 'unread')->whereNotNull('id');
                }])->join('products', 'orders.product_ml_product_id', 'products.ml_product_id')->where('orders.ml_account_ml_user_id', $ml_user_id)->take(20)->get();
                $ord = $orders->filter(function ($value, $key){
                    return $value->messages != null;
                });
                $collection = collect($ord);
                $val = $collection->values();
                return $val->all();
               // return $orders->flatten();
            }else{
                return [];
            }

        }

    }

    
    public function createMessage(string $token, string $pack_id, array $from){
        $params = ['access_token'=> $token];
        return $this->meli->post('messages/'.$pack_id, $from, $params);
       $response = $this->validateResponseStatus($this->meli->post('messages/'.$pack_id, $from, $params), $token);
        if($response['error'] != false){
            if ($response['token'] != null){
                $this->createMessage($response['token'], $pack_id, $from);
            }
            return $response['response'];
        }else{
            return $response['response'];
        }
    }


    private function validateResponseStatus($response, string $token){
        if($response['httpCode']==200){
            return ['response'=> $response['body'], 'token'=> null, 'error'=> false];
        }else if($response['httpCode'] == 401){
            $meliToken = new MeliToken();
            $new_token = $meliToken->refreshToken(Ml_account::where('ml_token', $token)->first());
            if($new_token['success'] != true){
                return ['response'=> $response['body'], 'token'=> null, 'error'=> true];
            }else{
                return ['response'=> $response['body'],  'token'=> $new_token['new_token'], 'error'=> false];
            }
        }else{
            return ['response'=> $response['body'],  'token'=> null, 'error'=> true];
        }
    }

}