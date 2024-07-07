<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::all();
        return response()->json($orders);
    }

    public function store(Request $request){
        // $new_order = Order::create($request->all());
        // return response()->json($new_order);

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'date' => 'required'
        ]);
      
        $order = new Order([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'date' => $request->get('date'),
        ]);
      
        $order->save();
      
        return response()->json($order);
    }

    public function show($id) {
        // $order = Order::findOrFail($id);
        $order = Order::with(['products'])->where('id', '=', $id)->get();
        return response()->json($order);
    }

    public function update(Request $request, $id) {
        
        $order = Order::find($id);
        $order->name = $request->name;
        $order->description = $request->description;
        $order->date = $request->date;
        $order->update();

        return response()->json($order);
    }

    public function destroy($id) {
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json("Ordine cancellato");
    }

    public function addProduct(Request $request, $id) {
        $order = Order::find($id);
        $order->products()->attach($request->products);
        return response()->json("Prodotto associato all'ordine");
    }

    public function removeProduct(Request $request, $id) {
        $order = Order::find($id);
        $order->products()->detach($request->products);
        return response()->json("Prodotto rimosso dall'ordine");
    }
}
