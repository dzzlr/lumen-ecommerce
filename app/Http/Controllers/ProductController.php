<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {

    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'weight' => 'required',
            'stock' => 'required',
            'image' => 'required'
        ]);

        $product = Product::create($validated);
        if ($product) {
            return response()->json([
                'status' => 'success',
                'message' => 'Product created successfully',
                'data' => $product
            ], 200);
        }
        else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Product failed to created'
            ], 400);
        }
    }
}