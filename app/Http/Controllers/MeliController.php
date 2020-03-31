<?php

namespace App\Http\Controllers;

use App\Events\SyncMeliAccountEvent;
use Illuminate\Http\Request;
use App\MercadolibreServices\Meli;
use App\Ml_account;
//use Async;
use Illuminate\Support\Facades\Log;
use VXM\Async\Async;
use App\MercadolibreServices\MLProducts;
use App\MercadolibreServices\MeliToken;
use App\MercadolibreServices\MLOrders;
use App\MercadolibreServices\MLMessages;
use App\Repository\ProductsRepository;
//use App\Repository\OrdersRepository;
use App\Messages;
//use Carbon\Carbon;


class MeliController extends Controller
{
    public $site_id;
    public $id;
    public $meli;
    public $n;
    private $productsRepository;
    private $mlProducts;
    private $mlOrders;

    public function __construct(
        ProductsRepository $productsRepository, 
        MLProducts $mlProducts, 
        MLOrders $mlOrders
    )
    {
        $this->mlProducts = $mlProducts;
        $this->mlOrders = $mlOrders;
        $this->productsRepository = $productsRepository;
        
    }

    public function index(
        $id = '535863184', 
        $token = 'APP_USR-741691194923802-031421-9609e8e10058cd7a1a275ef1b536ee8c-535863184', 
        $scroll_id = null
    )
        {
            // $meliToken = new MeliToken();
            // return $new_token = $meliToken->refreshToken(Ml_account::where('ml_user_id', $id)->first());
            // event(new SyncMeliAccountEvent());
            $this->meli = new Meli(ENV('APP_ID'), ENV('APP_SECRET_KEY'));
        return  $this->mlOrders->getAllOrders($token, $id, 0);
        $items = null;

        Log::debug('Starting async..');


    
        if($scroll_id != null){
            $items = $this->mlProducts->getProductsScrollId($id, $token, $scroll_id);
        }else{
            $items = $this->mlProducts->getScanId($token, $id);
        }
        
        if($items['httpCode'] == 401){
            $meliToken = new MeliToken();
            $new_token = $meliToken->refreshToken(Ml_account::where('ml_user_id', $id)->first());
            if($new_token['success'] != true){
                Log::debug('Couldnt solve..');
                return 400;
            }else{
                Log::debug('Recursive index..');
                $this->index($id, $new_token['new_token'], $scroll_id);
               // return redirect()->route('account.async', ['id'=> $id, 'token'=> $new_token['new_token']]);
            }
            
        }
        if($items['httpCode'] == 200)
        {
            $items = $items['body'];
            if(count($items['results']) == 0){
                //$orders = $mlOrders->getOrders($token, $id);
                $this->mlOrders->getAllOrders($token, $id, 0);
                
            }

            foreach($items['results'] as $item){
                $this->n++;
               // echo $item.'<br>';
                $product = $this->mlProducts->getProductById($item, $token);
                // echo '<pre>';
                // print_r($product);
                // echo '</pre>';
                if($product['httpCode'] == 200){
                   $this->productsRepository->saveProduct($product['body'], $id);
                        echo 'Ok saving prod. :'. $item.'<br>';
                }
                //Create store function



            }
            echo "End of loop, product No.: ".$this->n."<br>";
           
            if(array_key_exists('scroll_id', $items)){
                $this->index($id, $token, $items['scroll_id']);
            }


        }
        return "<br><br>End baby";

    }
    // private function syncProducts(){

    // }
    public function meliLogin(){
        $this->meli = new Meli(ENV('APP_ID'), ENV('APP_SECRET_KEY'));
        $this->site_id = $_GET['site_id'];
        $this->id = $_GET['id'];

        if (isset($_GET['code'])) {
            
            $mlUser = $this->meli->authorize($_GET['code'], ENV('REDIRECT_URI').'?site_id='.$this->site_id.'&id='.$this->id);
            $me = $this->meli->get('users/'.$mlUser['body']->user_id, ['access_token'=> $mlUser['body']->access_token]);
           // echo $me['body']->email;
            echo '<pre>';
            print_r($mlUser);
            print_r($me['body']);
            echo '</pre>';
            
            
            $ml_account = Ml_account::where('id', $mlUser['body']->user_id)->first();
            if (!$ml_account) {
                Ml_account::create([
                    'ml_user_id' => $mlUser['body']->user_id,
                    'ml_email' => $me['body']->email,
                    'ml_token' => $mlUser['body']->access_token,
                    'ml_refresh_token' => $mlUser['body']->refresh_token,
                    'user_id' => $this->id
                ]);
            }else{
                //Redirijir a una ruta con el mensaje que ya existe
                return "Ya existe";
            }
            return redirect()->to(env('APP_URL').'/home');
   
        }
        

    // $meli->getAuthUrl("http://localhost:8100/_auth/ml_auth",Meli::$AUTH_URL['MLM']); //  Don't forget to change the $AUTH_URL value to match your user's Site Id.
    // $user = $meli->authorize($_GET['code'], 'http://localhost:8100/_auth/ml_auth');
     //return dd($user);
    //  $siteId = Auth::user()->site_id;
    //return "You're in baby";
     echo '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">';
     echo '<div class="container">';
     echo '<div class="row justify-content-md-center mt-3">';
     echo '<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQ_wepaIpNn7AeNtaWxPe_jheonnTJbS516Bc4jWnkyS6t9rtuL" class="img-fluid" alt="Responsive image">';
     echo '</div>';
     echo '<div class="row justify-content-md-center mt-3">';
     echo '<p><a class="btn btn-primary" alt="Login using MercadoLibre oAuth 2.0" class="btn" href="' . $this->meli->getAuthUrl(ENV('REDIRECT_URI').'?site_id='.$this->site_id.'&id='.$this->id, Meli::$AUTH_URL[$this->site_id]) . '">Autentificate con MercadoLibre</a></p>';
     echo '</div>';
     echo '</div>';
     

    

    }
}
