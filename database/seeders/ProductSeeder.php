<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cursos       = Category::where('name', 'CURSOS')->first();
        $tenis        = Category::where('name', 'TENIS')->first();
        $celulares    = Category::where('name', 'CELULARES')->first();
        $computadoras = Category::where('name', 'COMPUTADORAS')->first();

        $data = [
            [
                'name'        => 'LARAVEL Y LIVEWIRE',
                'cost'        => 200,
                'price'       => 350,
                'barcode'     => '000000001',
                'stock'       => 1000,
                'alerts'      => 10,
                'category_id' => $cursos->id,
                'image'       => 'curso.png'
            ],
            [
                'name'        => 'RUNNING NIKE',
                'cost'        => 600,
                'price'       => 650,
                'barcode'     => '000000002',
                'stock'       => 1000,
                'alerts'      => 10,
                'category_id' => $tenis->id,
                'image'       => 'tenis.png'
            ],
            [
                'name'        => 'IPHONE 11',
                'cost'        => 900,
                'price'       => 1400,
                'barcode'     => '000000003',
                'stock'       => 1000,
                'alerts'      => 10,
                'category_id' => $celulares->id,
                'image'       => 'iphone11.png'
            ],
            [
                'name'        => 'PC GAMMER',
                'cost'        => 790,
                'price'       => 1000,
                'barcode'     => '000000004',
                'stock'       => 1000,
                'alerts'      => 10,
                'category_id' => $computadoras->id,
                'image'       => 'pcgammer.png'
            ]
        ];

        for ($i=5; $i < 400; $i++) {
            $data[] = [
                'name'        => "Product-$i",
                'cost'        => 790,
                'price'       => 1000,
                'barcode'     => str_pad($i, 9, 0, STR_PAD_LEFT),
                'stock'       => 1000,
                'alerts'      => 10,
                'category_id' => $computadoras->id,
                'image'       => 'pcgammer.png'
            ];
        }

        foreach ($data as $product) {
            Product::create($product);
        }
    }
}
