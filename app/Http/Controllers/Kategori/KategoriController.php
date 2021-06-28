<?php

namespace App\Http\Controllers\Kategori;

use App\Http\Controllers\Controller;
use App\Http\Resources\KategoriIndexResource;
use App\Http\Resources\KategoriShowResource;
use App\Models\Kategori;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index()
    {
        return KategoriIndexResource::collection(Kategori::all());
    }

    public function show($id)
    {
        try {
            $id_decrypt =  Crypt::decrypt($id);
            $query = Kategori::findOrFail($id_decrypt);
            return new KategoriShowResource($query);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Data Tidak Ditemukan'], 404);
        }
    }

    public function store(Request $request)
    {        
        $validator = $this->validator($request);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }else {
            try {
                $kategori = new Kategori;
                $kategori->nama = $request->nama_kategori;

                $kategori->save();
                return $kategori;
            } catch (\Throwable $th) {
                return response()->json(['message' => $th->getMessage()], 422);
            }
        }
    }

    public function update(Request $request)
    {
        try {
            $id = Crypt::decrypt($request->id);
            
            $validator = $this->validator($request);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            } else {
                $kategori = Kategori::findOrFail($id);
                $kategori->update([
                    'nama' => $request->nama_kategori
                ]);
                return $kategori;
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 404);
        }
    }

    private function validator($request)
    {
        $data = [
            'nama_kategori' => $request->nama_kategori
        ];

        $rules = [
            'nama_kategori' => 'required'
        ];

        $messages = [
            'nama_kategori.required' => 'Nama Kategori Kosong!'
        ];

        return Validator::make($data, $rules, $messages);
    }
}