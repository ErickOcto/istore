<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax())
        {
            $query = Product::with('user', 'category');

            return DataTables::of($query)
            ->addColumn('action', function($item){
                return '
                    <div class="btn-group">
                        <div class="dropdown">
                            <button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle mr-1 mb-1">
                                Aksi
                            </button>
                            <div class="dropdown-menu">
                                <a href="'. route('product.edit', $item->id) . '" class="dropdown-item">Edit</a>

                                <form action="' . route('product.destroy', $item->id) .'" method="POST">
                                    ' . method_field('delete') . csrf_field() . '
                                    <button type="submit" class="dropdown-item text-danger">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                ';
            })
            ->rawColumns(['action'])
            ->make();
        }
        return view('pages.admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $categories = Category::all();
        return view('pages.admin.product.create', compact('users', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $data = $request->all();

        $data['category_id'] = $request->category_id;
        $data['slug'] = Str::slug($request->name);

        //dd($data);

        Product::create($data);

        //dd($data);

        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Product::findOrFail($id);

        $users = User::all();
        $categories = Category::all();

        return view('pages.admin.product.edit', compact('item', 'users', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, $id)
    {
        $data = $request->all();
        $item = Product::findOrFail($id);

        $data['slug'] = Str::slug($request->name);
        //dd($data);
        $item->update($data);
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Product::findOrFail($id);
        $item->delete();
        return redirect(route('product.index'));
    }
}
