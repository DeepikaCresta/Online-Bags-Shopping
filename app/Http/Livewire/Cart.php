<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Cart as CartFacade;
use Illuminate\Http\Request;

class Cart extends Component
{
    public function addToCart(Request $request)
    {
        $p = Product::find($request->input('product_id'));
        if(!$p){
            return redirect()->back()->with([
                'error' => true,
                'message' => 'Product not found.'
            ]);
        }
        CartFacade::add($p->id, $p->name, 1, $p->price)->associate('App\Models\Product');
        return redirect()->route('cart')->with([
            'success' => true,
            'message' => 'Item has been added to your cart.'
        ]);
    }
    public function incQty(Request $req)
    {
        $rowId = $req->row_id;
        $product = CartFacade::get($rowId);
        $qty = $product->qty + 1;
        CartFacade::update($rowId, $qty);
        return redirect()->route('cart')->with([
            'success' => true,
            'message' => 'Item quantity increased.'
        ]);
    }
    public function decQty(Request $req)
    {
        $rowId = $req->row_id;
        $product = CartFacade::get($rowId);
        if ($product) {
            $qty = max(1, $product->qty - 1);
            CartFacade::update($rowId, $qty);
            return redirect()->route('cart')->with([
                'success' => true,
                'message' => 'Item quantity decreased.'
            ]);
        }
        return redirect()->route('cart')->with([
            'error' => true,
            'message' => 'Item not found in cart.'
        ]);
    }
    public function destroyItem(Request $req)
    {
        $rowId = $req->row_id;
        CartFacade::remove($rowId);
        return redirect()->back()->with([
            'success' => true,
            'message' => 'Item has been removed from your cart.'
        ]);
    }
    public function destroyCart(Request $req)
    {
        CartFacade::destroy();
        return redirect()->back()->with([
            'success' => true,
            'message' => 'Item has been removed from your cart.'
        ]);
    }
    public function render()
    {
        return view('livewire.cart');
    }
}
