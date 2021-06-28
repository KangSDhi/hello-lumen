<?php

namespace App\Http\Controllers\Produk;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProdukIndexResource;
use App\Http\Resources\ProdukShowResource;
use App\Models\Produk;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        return ProdukIndexResource::collection(Produk::all());
    }

    public function show($id)
    {
        try {
            $id_decrypt = Crypt::decrypt($id);
            $query = Produk::findOrFail($id_decrypt);
            return new ProdukShowResource($query);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Data Tidak Ditemukan']);
        }
    }

    public function store(Request $request)
    {
        $validator = $this->validator($request);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            try {
                $produk = new Produk;
                $produk->kategori_id = $request->kategori_id;
                $produk->nama = $request->nama_produk;
                $produk->stok = $request->stok_produk;
                $produk->harga = $request->harga_produk;
                $produk->save();

                return $produk;
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
                $produk = Produk::findOrFail($id);
                $produk->update([
                    'nama' => $request->nama_produk,
                    'stok' => $request->stok_produk,
                    'harga' => $request->harga_produk
                ]);
                return $produk;
            }
            
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 404);
        }
    }

    private function validator($request)
    {
        $data = [
            'kategori_id' => $request->kategori_id,
            'nama_produk' => $request->nama_produk,
            'stok_produk' => $request->stok_produk,
            'harga_produk' => $request->harga_produk
        ];

        $rules = [
            'kategori_id' => 'required',
            'nama_produk' => 'required',
            'stok_produk' => 'required',
            'harga_produk' => 'required'
        ];

        $messages = [
            'kategori_id.required' => 'ID Kategori Kosong!',
            'nama_produk.required' => 'Nama Produk Kosong!',
            'stok_produk.required' => 'Stok Produk Kosong!',
            'harga_produk.required' => 'Harga Produk Kosong!'
        ];

        return Validator::make($data, $rules, $messages);
    }
}