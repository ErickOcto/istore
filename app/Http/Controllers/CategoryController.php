<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::all();
        $products = Product::with(['galleries'])->paginate(4);
        $newProducts = Product::with(['galleries'])->latest()->paginate(4);
        return view('pages.category', compact('categories', 'products', 'newProducts'));
    }

    public function categoriesDetail(Request $request, $slug){
        $categories = Category::all();
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::with(['galleries'])->where('category_id', $category->id)->paginate(32);
        //dd($category->name);
        return view('pages.categories-detail', compact('category', 'products', 'categories'));
    }
}
