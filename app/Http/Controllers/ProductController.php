<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use App\Models\User;
use App\Models\Product;

class ProductController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::all();
        return response()->json([
            'code' => 200,
            'status' => 'OK',
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $token = $request->bearerToken();
        $credentials = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));

        $user = User::find($credentials->sub);
        $shop = $user->shop;

        if (is_null($shop)) {
            return response()->json([
                'code' => 400,
                'status' => 'BAD_REQUEST',
                'message' => 'You must be created Shop first'
            ], 400);
        } else {
            $shop = $shop->makeHidden(['user_id']);
        }

        $validated = $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'nullable|max:255',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'image' => 'nullable|max:255'
        ]);

        $validated['shop_id'] = $shop->id;
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::where('id', $id)->first();

        if ($product) {
            return response()->json([
                'code' => 200,
                'status' => 'OK',
                'message' => 'Successfully get retrieved product info data',
                'data' => $product
            ], 200);
        } else {
            return response()->json([
                'code' => 400,
                'status' => 'BAD_REQUEST',
                'message' => 'Failed to get retrieve product info data'
            ], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $Request) //$id
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $this->validate($request, [
            'name' => 'nullable|max:255',
            'description' => 'nullable|max:255',
            'price' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'stock' => 'nullable|numeric|min:0',
            'image' => 'nullable|max:255',
        ]);

        $product = Product::where('id', $id)->update($validated);

        if ($product) {
            return response()->json([
                'code' => 200,
                'status' => 'OK',
                'message' => 'Successfully updated product info data',
            ], 200);
        }
        else {
            return response()->json([
                'code' => 400,
                'status' => 'BAD_REQUEST',
                'message' => 'Failed to update product info data'
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::destroy($id);

        if ($product) {
            return response()->json([
                'code' => 200,
                'status' => 'OK',
                'message' => 'Successfully deleted product',
            ], 200);
        }
        else {
            return response()->json([
                'code' => 400,
                'status' => 'BAD_REQUEST',
                'message' => 'Failed to delete product'
            ], 400);
        }
    }
}