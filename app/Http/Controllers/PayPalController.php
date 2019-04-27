<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;

class PayPalController extends Controller
{
    public function confirm(Request $request){
        // 3. Call PayPal to get the transaction details
        $orderId=$request->order_id;
        
        $client = PayPalClient::client();
        $response = $client->execute(new OrdersGetRequest($orderId));
        return $this->sendResponse('result',$response->result->status);
    }
}
