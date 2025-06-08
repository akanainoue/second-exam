<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;
use App\Models\ProductSeason;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateRequest;

class ProductController extends Controller
{

    // public function index (){
    //     $products = Product::with('seasons')->paginate(6);
    //     $seasons = Season::all();
    //     return view('index', compact('products','seasons'));
    // }

    public function index()
    {
        $products = Product::with('seasons')->paginate(6);
        $seasons = Season::all();

        return view('index', compact('products', 'seasons'));
    }

    public function search (Request $request)
    {
        $products = Product::with('seasons')->KeywordSearch($request->keyword)->paginate(6);
        $seasons = Season::all();
        return view('index', compact('products', 'seasons'));
    }

    public function sort (Request $request)
    {
        $query = Product::with('seasons');
        $sort = $request->input('sort');
        if ($sort === 'high') {
            $query->orderBy('price', 'desc');
        } elseif ($sort === 'low') {
            $query->orderBy('price', 'asc');
        }
        $products = $query->paginate(6)->appends($request->all());
        $seasons = Season::all();
        return view ('index', compact('products', 'seasons', 'sort'));
    }

    public function register()
    {
        $seasons = Season::all();
        return view('register', compact('seasons'));
    }

    public function store(RegisterRequest $request)
    {
        $validated = $request->only(['name', 'price', 'image', 'seasons[]', 'description']);

        $path = $request->file('image')->store('public/fruits');
        $validated['image'] = basename($path);

        $product = Product::create($validated);
        $product->seasons()->sync($request->input('seasons'));

        return redirect()->route('products.index');
    }

    public function detail ($productId)
    {
        $product = Product::with('seasons')->findOrFail($productId);
        $seasons = Season::all();
        return view('detail', compact('product', 'seasons'));
    }

    public function update(UpdateRequest $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/fruits');
            $validated['image'] = basename($path);
        } else {
            // 新しい画像がなければ、既存画像のまま（更新しない）
            unset($validated['image']);
        }

        $product->update($validated);
        $product->seasons()->sync($request->input('seasons', []));

        return redirect()->route('products.index');
    }

    public function destroy($productId)
    {
        $product = Product::findOrFail($productId);
        $product->seasons()->detach();
        $product->delete();

        return redirect()->route('products.index');
    }
}


