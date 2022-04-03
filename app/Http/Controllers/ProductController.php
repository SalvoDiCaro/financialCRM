<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Auth;
use App\Events\UserRegistered;
use DB;

class ProductController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        if ($user->agent_code == '00000000') {
            $products = Product::all();
            return view('products.index', compact('products'));
        }else{
            return redirect()->route('home')
            ->with('error', 'Non autorizzato.');
        }
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->agent_code == '00000000') {
            return view('products.create');
        }else{
            return redirect()->route('home')
            ->with('error', 'Non autorizzato.');
        }
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->agent_code == '00000000') {
            request()->validate([
                'name' => 'required',
            ]);

            //Create a product with default rubric and assing user role to product
            $product = Product::create(['name' => $request->name, 'details' => $request->details]);
            $product->save();

            return redirect()->route('products.index')
                ->with('success', 'product created successfully.');
        }else{
            return redirect()->route('home')
            ->with('error', 'Non autorizzato.');
        }

    }

    public function show($id)
    {
        $user = Auth::user();

        if ($user->agent_code == '00000000') {
            $product = Product::find($id);

            return view('products.show', compact('product'));
        }else{
            return redirect()->route('home')
            ->with('error', 'Non autorizzato.');
        }

    }

    public function edit(Product $product)
    {
        $user = Auth::user();

        if ($user->agent_code == '00000000') {
            $product = Product::find($product->id);
            return view('products.edit', compact('product'));
        }else{
            return redirect()->route('home')
            ->with('error', 'Non autorizzato.');
        }

    }

    public function update(Request $request, Product $product)
    {
        $user = Auth::user();

        if ($user->agent_code == '00000000') {
            request()->validate([
                'name' => 'required',
            ]);

            $products = Product::find($product->id);
            $products->update($request->all());

            return redirect()->route('products.index')
                ->with('success', 'product updated successfully');
        }else{
            return redirect()->route('home')
            ->with('error', 'Non autorizzato.');
        }

    }

    public function destroy(Product $product)
    {
        $user = Auth::user();

        if ($user->agent_code == '00000000') {

            $product->delete();

            return redirect()->route('products.index')
                ->with('success', 'product deleted successfully');

        }else{
            return redirect()->route('home')
            ->with('error', 'Non autorizzato.');
        }

    }
}
