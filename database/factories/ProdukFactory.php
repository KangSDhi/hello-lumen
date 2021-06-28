<?php

namespace Database\Factories;

use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdukFactory extends Factory
{
    protected $model = Produk::class;

    public function definition()
    {
        $nama = $this->faker->name;
        $stok = $this->faker->numberBetween(1, 1000);
        $harga = $this->faker->numberBetween(1000, 1000000);
        return [
            'nama' => $nama,
            'stok' => $stok,
            'harga' => $harga
        ];
    }
}
