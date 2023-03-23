<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use App\Models\User;
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
        $data = Shop::all()->makeHidden(['user_id']);
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

        $user = User::where('id', $credentials->sub)->first();

        $validated = $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'nullable|max:200',
            'address' => 'nullable|max:200',
            'image' => 'nullable|max:255'
        ]);

        $validated['user_id'] = $user->id;
        $shop = Shop::create($validated);
        if ($shop) {
            return response()->json([
                'code' => 200,
                'status' => 'OK',
                'message' => 'Shop created successfully'
            ], 200);
        }
        else {
            return response()->json([
                'code' => 400,
                'status' => 'BAD_REQUEST',
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
                'code' => 200,
                'status' => 'OK',
                'message' => 'Successfully get retrieved shop info data',
                'data' => $shop->makeHidden(['user_id'])
            ], 200);
        } else {
            return response()->json([
                'code' => 400,
                'status' => 'BAD_REQUEST',
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
     * @param  int  $id
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $this->validate($request, [
            'name' => 'nullable|max:255',
            'description' => 'nullable|max:200',
            'address' => 'nullable|max:200',
            'image' => 'nullable|max:255'
        ]);

        $shop = Shop::where('id', $id)->update($validated);

        if ($shop) {
            return response()->json([
                'code' => 200,
                'status' => 'OK',
                'message' => 'Successfully updated shop info data',
            ], 200);
        }
        else {
            return response()->json([
                'code' => 400,
                'status' => 'BAD_REQUEST',
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
                'code' => 200,
                'status' => 'OK',
                'message' => 'Successfully deleted shop',
            ], 200);
        }
        else {
            return response()->json([
                'code' => 400,
                'status' => 'BAD_REQUEST',
                'message' => 'Failed to delete shop'
            ], 400);
        }
    }
}