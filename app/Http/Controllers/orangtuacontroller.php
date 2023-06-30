<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orangtua;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

//use Illuminate\Support\Facades\Validator;

class orangtuacontroller extends Controller
{
    public function index()
    {
        //get data from table posts
        $ortu = Orangtua::latest()->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Pelanggaran',
            'data'    => $ortu
        ], 200);
    }

    /**
     * show
     *
     * @param  mixed $id
     * @return void
     */
    public function show($id_orangtua)
    {
        try {
            $ortu = Orangtua::findOrFail($id_orangtua);
            return response()->json([
                'success' => true,
                'message' => 'Detail Data Pelanggaran',
                'data'    => $ortu
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'Message' => 'data tidak ada bos'
            ]);
        }

        //find post by ID
        // $ortu = DB::table('orangtua')->where('id_orangtua', $id_orangtua)->first();

        // //make response JSON
        // if (!$ortu) {
        //     return response()->json([
        //         'Message' => 'data tidak ada'
        //     ]);
        // }
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Detail Data Pelanggaran',
        //     'data'    => $ortu
        // ], 200);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //set validation

        //save to database
        $ortu = Orangtua::create([
            'nama_orangtua'           => $request->nama_orangtua,
            'alamat'                    => $request->alamat,
            'no_hp_orangtua'             => $request->no_hp_orangtua,

        ]);

        //success save to database
        if ($ortu) {

            return response()->json([
                'success' => true,
                'message' => 'Post Created',
                'data'    => $ortu
            ], 201);
        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Post Failed to Save',
        ], 409);
    }

    public function update(Request $request, orangtua $orangtua)
    {
        //set validation
        // $validator = Validator::make($request->all(), [
        // 'nama_orangtua'   => 'required',

        // ]);

        //response error validation
        // if ($validator->fails()) {
        //      return response()->json($validator->errors(), 400);
        // }

        //find post by ID


        $ortu = Orangtua::findOrFail($orangtua->id_orangtua);

        if ($ortu) {

            //update post
            $ortu->update([
                'nama_orangtua'           => $request->nama_orangtua,
                'alamat'                    => $request->alamat,
                'no_hp_orangtua'             => $request->no_hp_orangtua,

            ]);
            return response()->json([
                'success' => true,
                'message' => 'Post Updated',
                'data'    => $ortu
            ], 200);
        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Post Not Found',
        ], 404);
    }
    public function destroy($id)
    {
        //find post by ID
        $ortu = Orangtua::findOrfail($id);

        if ($ortu) {

            //delete post
            $ortu->delete();

            return response()->json([
                'success' => true,
                'message' => 'Post Deleted',
            ], 200);
        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Post Not Found',
        ], 404);
    }
}
