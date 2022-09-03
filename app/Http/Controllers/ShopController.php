<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $validated = $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'nullable|max:200',
            'address' => 'nullable|max:200',
            'phone' => 'nullable|max:13',
            'logo' => 'nullable|max:255'
        ]);

        $validated['user_id'] = $request->user_id;
        $shop = Shop::create($validated);
        if ($shop) {
            return response()->json([
                'status' => 'success',
                'message' => 'Shop created successfully',
                'data' => $shop
            ], 200);
        }
        else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Shop failed to created'
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
        $shop = Shop::where('id', $id)->first();

        if ($shop) {
            return response()->json([
                'status' => 'success',
                'messages' => 'Successfully get retrieved shop info data',
                'data' => $shop
            ], 200);
        }
        else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to get retrieve shop info data'
            ], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) //$id
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
            'name' => 'sometimes|max:255',
            'description' => 'sometimes|max:200',
            'address' => 'sometimes|max:200',
            'phone' => 'sometimes|max:13',
            'logo' => 'sometimes|max:255'
        ]);

        $shop = Shop::where('id', $id)->update($validated);
        $shop_data = Shop::where('id', $id)->first();

        if ($shop) {
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully updated shop info data',
                'data' => $shop_data
            ], 200);
        }
        else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to update shop info data'
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
        $shop = Shop::destroy($id);

        if ($shop) {
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully deleted shop',
            ], 200);
        }
        else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to delete shop'
            ], 400);
        }
    }
}