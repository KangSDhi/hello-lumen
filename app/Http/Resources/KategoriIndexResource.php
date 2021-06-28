<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;

class KategoriIndexResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => Crypt::encrypt($this->id),
            'nama_kategori' => $this->nama
        ];
    }
}