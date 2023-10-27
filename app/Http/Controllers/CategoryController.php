<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::all();
        $products = Product::with(['galleries'])->paginate(32);
        return view('pages.category', compact('categories', 'products'));
    }
}
