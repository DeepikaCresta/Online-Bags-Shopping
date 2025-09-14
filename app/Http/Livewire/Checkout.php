<?php

namespace App\Http\Livewire;

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

        $order_data = [
            'user_id' => Auth::user()->id,
            'order_tracking_id' => 'ot-' . date("U"),
            'tax' => Cart::tax(),
            'payment_type' => 'cash',
            'subtotal' => Cart::subtotal(),
            'total' => Cart::total()
        ];
        session()->put('order_data', $order_data);

        create_esewa_order();
        return redirect()->route('dashboard')->with(['success','Order has been placed.']);
    }

    public function render()
    {
        if (Cart::count() <= 0) {
            session()->flash('error', 'Your cart is empty.');
            return redirect()->route('home');
        }
        $user = Auth::user();
        $billingDetails = $user->billingDetails;
        return view('livewire.checkout', compact('billingDetails'));
    }
}
