<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Database\Seeder;
use Faker\Factory;


class ProdukTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kategori::all()->each(function (Kategori $kategori)
        {
            $produk = Produk::factory()->make();
            $produks = collect([$produk]);
            $faker = Factory::create();

            for ($i=0; $i < random_int(1, 1000); $i++) { 
                $nama = $faker->name;;
                $stok = $faker->numberBetween(1, 100);
                $harga = $faker->numberBetween(1000, 1000000);

                $produk = Produk::make([
                    'nama' => $nama,
                    'stok' => $stok,
                    'harga' => $harga
                ]);

                $produks->push($produk);
            }

            $kategori->produks()->saveMany($produks);
        });
    }
}
