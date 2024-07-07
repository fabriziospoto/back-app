<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        return response()->json($products);
    }

    public function store(Request $request){
        // $new_product = Product::create($request->all());
        // return response()->json($new_product);

        $request->validate([
            'name' => 'required',
            'price' => 'required'
        ]);
      
        $product = new Product([
            'name' => $request->get('name'),
            'price' => $request->get('price')
        ]);
      
        $product->save();
      
        return response()->json($product);
    }

    public function show($id) {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    public function update(Request $request, $id) {
        
        $product = Product::find($id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->update();

        return response()->json($product);
    }

    public function destroy($id) {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json("Prodotto cancellato");
    }
}
