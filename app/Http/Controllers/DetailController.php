<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    public function index(Request $request, $id){
        $product = Product::with(['galleries', 'user'])->where('slug', $id)->firstOrFail();
        //dd($product);
        return view('pages.details', compact('product'));
    }

    public function add(Request $request, $id){
        $data = [
            'product_id' => $id,
            'user_id' => Auth::user()->id,
        ];
        Cart::create($data);

        return redirect()->back();
    }
}
