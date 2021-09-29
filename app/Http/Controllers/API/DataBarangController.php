<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DataBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DataBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $databarangs = DataBarang::latest()->get();

        return response()->json([
           'data' => $databarangs
        ],200);
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
        $validator = $request->validate([
            'namaBarang'   => 'required',
            'idPenjual' => 'required',
            'foto' => 'required|file|mimes:png,jpg',
            'hargaBarang' => 'required'
        ]);

        try {
            $fileName = time().$request->file('foto')->getClientOriginalName();
            $path = $request->file('foto')->storeAs('uploads/fotobarang', $fileName);
            $validator['foto']=$path;
            $databarangs = DataBarang::create($validator);
            return response()->json([
                'success' => true,
                'message' => 'Data Created',
                'data' => $databarangs
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data Failed to Save',
            ], 409);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($idBarang)
    {
        $databarangs = DataBarang::findOrfail($idBarang);

        return response()->json([
            'success' => true,
            'message' => 'Detail Barang',
            'data' => $databarangs
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $idBarang
     * @return \Illuminate\Http\Response
     */
    public function edit($idBarang)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $idBarang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idBarang)
    {
        $validator = $request->validate([
            'namaBarang'   => 'required',
            'idPenjual' => 'required',
            'foto' => '',
            'hargaBarang' => 'required'
        ]);

        try {
            if($request->file('foto')){
                $fileName = time().$request->file('foto')->getClientOriginalName();
                $path = $request->file('foto')->storeAs('uploads/fotobarang', $fileName);
                $validator['foto']=$path;
            }
                $response = DataBarang::find($idBarang);
                $response->update($validator);
                return response()->json([
                    'success' => true,
                    'message' => 'Data Updated',
                    'data' => $response
                ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data Failed to Save',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $idBarang
     * @return \Illuminate\Http\Response
     */
    public function destroy($idBarang)
    {
        $databarangs = DataBarang::findOrFail($idBarang);

        if($databarangs){
            $databarangs->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data Deleted',
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Post Not Found',
        ], 404);
    }
}
