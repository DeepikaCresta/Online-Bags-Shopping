<?php

namespace App\Http\Livewire;

use App\Mail\OrderCompletedMail;
use App\Mail\OrderReceived;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\InvoiceService;
use Livewire\Component;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Checkout extends Component
{
    public function makeOrder(Request $request)
    {
        $validatedRequest = $request->validate([
            'country' => 'required',
            'billing_address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'phone' => 'required',
            'zipcode' => 'required|numeric',
            'order_notes' => '',
        ]);

        $user = Auth::user();
        if ($user->billingDetails === null) {
            $user->billingDetails()->create($validatedRequest);
        } else {
            $user->billingDetails()->update($validatedRequest);
        }

        $totalShipping = Cart::content()->sum(function ($item) {
            return ($item->options->shipping_cost ?? 0) * $item->qty;
        });

        $total = (float) str_replace(',', '', Cart::total())+$totalShipping;
        
        $order_data = [
            'user_id' => Auth::user()->id,
            'order_tracking_id' => 'ot-' . date("U"),
            'tax' => Cart::tax(),
            'shipping_cost' => $totalShipping,
            'payment_type' => 'cash',
            'subtotal' => Cart::subtotal(),
            'total' => $total,
        ];
        session()->put('order_data', $order_data);

        $order = create_esewa_order();
        $invoiceService = new InvoiceService();
        $invoice = $invoiceService->createInvoice($order);
        Mail::to(Auth::user()->email)->send(new OrderReceived($order,$invoice));
        return redirect()->route('dashboard')->with([
            'success' => true,
            'message' => 'Your order has been placed successfully.'
        ]);
    }

    public function render()
    {
        if (Cart::count() <= 0) {
            return redirect()->route('home')->with([
                'success' => false,
                'message' => 'Your cart is empty.'
            ]);
        }
        $user = Auth::user();
        $billingDetails = $user->billingDetails;

        $totalShipping = Cart::content()->sum(function ($item) {
            return ($item->options->shipping_cost ?? 0) * $item->qty;
        });

        // Grand total including shipping
        $total = (float) str_replace(',', '', Cart::total());
        $grandTotal = $total + $totalShipping;

        return view('livewire.checkout', compact('billingDetails', 'totalShipping', 'grandTotal'));
    }
}
