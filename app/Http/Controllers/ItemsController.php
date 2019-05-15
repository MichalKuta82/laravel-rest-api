<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use Validator;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $items = Item::all();
        return response()->json($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            $response = ['response' => $validator->messages(), 'success' => false];
            return $response;
        }else{
            $item = Item::create([
                'name' => $request->input('name'),
                'body' => $request->input('body'),
            ]);
            return response()->json($item);
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
        //
        $item = Item::findOrFail($id);
        return response()->json($item);
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
        //
        $validator = Validator::make($request->all(),[
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            $response = ['response' => $validator->messages(), 'success' => false];
            return $response;
        }else{
            $item = Item::findOrFail($id);
            $item->name = $request->input('name');
            $item->body = $request->input('body');
            $item->save();
            return response()->json($item);
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
        //
        $item = Item::findOrFail($id);
        $item->delete();
        // return response()->json(['item' => $item, 'success' => 'Item has been deleted'], 200);
        $response = ['response' => 'Item has been deleted', 'success' => true];
            return $response;
    }
}
