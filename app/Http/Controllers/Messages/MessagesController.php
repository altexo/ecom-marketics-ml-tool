<?php

namespace App\Http\Controllers\Messages;

use App\Http\Controllers\Controller;
use App\MercadolibreServices\Meli;
use Illuminate\Http\Request;
use App\Ml_account;
use Illuminate\Support\Facades\DB;
use App\Products;
use App\Messages;
use App\Orders;
use Illuminate\Mail\Message;
use App\MercadolibreServices\MLMessages;


class MessagesController extends Controller
{
    private $mlMessages;
    public function __construct(MLMessages $mlMessages)
    {
        $this->mlMessages = $mlMessages;
    }
    public function index(){
        $ml_user_id = '315787371';
        return Orders::with('messages')->join('products', 'orders.product_ml_product_id', 'products.ml_product_id')->take(10)->get();
        return $m = Messages::all();


        return Ml_account::with('products.orders.messages')->where('ml_user_id', $ml_user_id)->first();
    

    }

    //In order to get the messages you have to get the order with messages using ml_user_id
    public function getMessages($ml_user_id){
        //This ml_user_id must be validate if it's owned by the requesting user
        return  Orders::with('messages')->join('products', 'orders.product_ml_product_id', 'products.ml_product_id')->where('orders.ml_account_ml_user_id', $ml_user_id)->take(20)->get();
    }

    public function sendMessage(Request $request){
    //    return $request->user()->ml_accounts;// Shoul validate if the current account id is owned by the requesting user
        //return $request->message;
        
        $ml_account = Ml_account::where('ml_user_id', $request->current_ml_account)->first(); 
        //return $this->mlMessages->getUnreadMessages($ml_account->ml_token);
        return $this->mlMessages->createMessage($ml_account->ml_token, $request->path, $request->message);
    }

    public function getUnreadMessages($ml_user_id){
        //return $mesages = DB::select(DB::raw('SELECT * FROM orders o INNER JOIN products p on p.ml_product_id = o.product_ml_product_id INNER JOIN (SELECT  order_ml_order_id,  status, conversation_status, conversation FROM messages ) m on m.order_ml_order_id = o.ml_order_id WHERE m.status = "unread"'));

        $ml_account = Ml_account::where('ml_user_id', $ml_user_id)->first(); 
        return $this->mlMessages->getUnreadMessages($ml_account->ml_token, $ml_user_id);

    }

    public function searchMessages($ml_user_id, $search){
        //return $search;
        return Orders::search($search)
                    ->with('messages')
                    ->join('products', 'orders.product_ml_product_id', 'products.ml_product_id')
                    ->where('orders.ml_account_ml_user_id', $ml_user_id)
                    ->take(30)
                    ->get();


    }


}
