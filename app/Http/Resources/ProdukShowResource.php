<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;

class ProdukShowResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => Crypt::encrypt($this->id),
            'nama_produk' => $this->nama,
            'stok_produk' => $this->stok,
            'harga_produk' => $this->harga
        ];
    }
}