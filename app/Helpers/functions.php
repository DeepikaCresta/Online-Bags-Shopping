<?php

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;

function create_esewa_order(){
    $order_data = session()->get('order_data');
    $order = new Order();
    $order->user_id = $order_data['user_id'];
    $order->status = 'pending';
    $order->order_tracking_id = 'ot-'.date("U");
    $order->payment_type = $order_data['payment_type'];
    $order->tax = $order_data['tax'];
    $order->subtotal = $order_data['subtotal'];
    $order->total = $order_data['total'];
    $order->save();
    foreach(Cart::content() as $cartItem) {
        $order->orderItems()->create([
            'product_id' => $cartItem->id,
            'quantity' => $cartItem->qty,
            'price' => str_replace(',', '', $cartItem->price)
        ]);
        $product = Product::where('id', $cartItem->id)->first();
        $product->quantity = max(0, $product->quantity - $cartItem->qty);
        $product->save();
    }
    Cart::destroy();
    session()->forget('payment_data');
    session()->forget('order_data');
}
function create_signature($message){
    $secret = '8gBm/:&EnhH.1/q';
    $s = hash_hmac('sha256', $message, $secret, true);
    $hashInBase64 =  base64_encode($s); 
    return $hashInBase64;
}