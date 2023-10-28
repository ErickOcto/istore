<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class DashboardProductController extends Controller
{
    public function index(){
        $products = Product::with(['galleries', 'category'])
        ->where('user_id', Auth::user()->id)
        ->get();

        return view('pages.dashboard-product', compact('products'));
    }

    public function detail(){
        $products = Product::with(['galleries', 'category'])
        ->where('user_id', Auth::user()->id)
        ->get();
        return view('pages.dashboard-product-detail', compact('products'));
    }

    public function uploadGallery(Request $request){

        $data = $request->all();

        $data['photo'] = $request->file('photo')->store('assets/product', 'public');

        //dd($data);

        Product::create($data);

        return redirect()->route('dashboard-product-detail', $request->product_id);
    }

    public function deleteGallery($id){
        $item = ProductGallery::findOrFail($id);
        $item->delete();

        return redirect()->route('dashboard-product-detail', $item->product_id);
    }

    public function create(){
        $categories = Category::all();
        return view('pages.dashboard-product-add', compact('categories'));
    }

        public function store(ProductRequest $request)
    {
        $data = $request->all();

        //dd($data);

        $data['category_id'] = $request->category_id;
        $data['slug'] = Str::slug($request->name);
        //dd($data);

        $product = Product::create($data);

        $gallery = [
            'product_id' => $product->id,
            'photo' => $request->file('photo')->store('assets/product', 'public'),
        ];

        ProductGallery::create($gallery);

        return redirect(route('dashboard-product'));
    }

    public function update(Request $request, $id){
        $data = $request->all();
        $item = Product::findOrFail($id);

        $data['slug'] = Str::slug($request->name);
        //dd($data);
        $item->update($data);
        return redirect()->route('dashboard.product');
    }
}
