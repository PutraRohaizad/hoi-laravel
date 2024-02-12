<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $qproduct = Product::query();

        if ($name = $request->input('name')) {
            $qproduct->where('name', 'like', "%$name%");
        }
        $products =  $qproduct->get();

        $users = User::get();
        $carts = Cart::with('user', 'product')->where('user_id', auth()->user()->id)->get();
        $orders = Order::where('user_id', auth()->user()->id)->get();

        return view('home', compact(
            'products',
            'users',
            'carts',
            'orders'
        ));
    }

    public function addcart(Request $request)
    {
        $request->validate([
            'quantity' => 'required'
        ]);

        // Checking if record already exist add the quantity
        $id = $request->input('product_id');
        $quantity = $request->input('quantity');
        $qcart = Cart::query()->where('product_id', $id)->where('user_id', auth()->user()->id)->first();
        if ($qcart != null) {
            $qcart->quantity = $qcart->quantity + $quantity;
            $qcart->save();
        } else {
            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $request->input('product_id');
            $cart->quantity = $request->input('quantity');
            $cart->save();
        }

        return redirect()->route('index')->with(['success' => 'The record have been add to your cart']);
    }

    public function clearCart()
    {
        $carts = Cart::get();

        foreach ($carts as $cart) {
            $cart->delete();
        }

        return redirect()->back()->with(['success' => 'Your Cart has been cleared!! :)']);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'address' => ['required']
        ]);

        $carts = Cart::query()->where('user_id', auth()->user()->id)->get();
        foreach ($carts as $cart) {
            $order = new Order;
            $order->user_id = $cart->user_id;
            $order->address = $request->address;
            $order->product_id = $cart->product_id;
            $order->quantity = $cart->quantity;
            $order->save();
            $cart->delete();
        }

        return redirect()->back()->with(['success' => 'Your Order has been sent!! :)']);
    }
}
