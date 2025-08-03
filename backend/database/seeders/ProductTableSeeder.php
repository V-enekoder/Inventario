<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        Product::create([
            'name'           => 'Kit de Pinturas al Óleo Profesional',
            'description'    => 'Set con 12 colores vibrantes de pintura al óleo de alta calidad.',
            'barcode'        => '1122334455667',
            'category_id'    => rand(1, 4), // ID de categoría aleatorio entre 1 y 4
            'cost_price'     => 150.00,
            'sale_price'     => 250.00,
            'stock_quantity' => 15,
            'unit'           => 'unidad',
            'stock_min'      => 3,
            'supplier_id'    => rand(1, 4), // ID de proveedor aleatorio entre 1 y 4
        ]);

        Product::create([
            'name'           => 'Lienzo de Algodón 50x70cm',
            'description'    => 'Lienzo preparado con imprimación acrílica, listo para pintar.',
            'barcode'        => '2233445566778',
            'category_id'    => rand(1, 4),
            'cost_price'     => 30.00,
            'sale_price'     => 55.00,
            'stock_quantity' => 50,
            'unit'           => 'unidad',
            'stock_min'      => 10,
            'supplier_id'    => rand(1, 4),
        ]);

        Product::create([
            'name'           => 'Set de Lápices de Carboncillo',
            'description'    => 'Kit con lápices de carboncillo de diferentes durezas para bocetos y dibujos.',
            'barcode'        => '3344556677889',
            'category_id'    => rand(1, 4),
            'cost_price'     => 25.00,
            'sale_price'     => 45.00,
            'stock_quantity' => 30,
            'unit'           => 'unidad',
            'stock_min'      => 5,
            'supplier_id'    => rand(1, 4),
        ]);

        Product::create([
            'name'           => 'Bloque de Arcilla Terracota 5kg',
            'description'    => 'Arcilla natural de terracota, ideal para modelado y escultura.',
            'barcode'        => '4455667788990',
            'category_id'    => rand(1, 4),
            'cost_price'     => 40.00,
            'sale_price'     => 70.00,
            'stock_quantity' => 20,
            'unit'           => 'unidad',
            'stock_min'      => 4,
            'supplier_id'    => rand(1, 4),
        ]);

        Product::create([
            'name'           => 'Kit de Herramientas para Esculpir',
            'description'    => 'Set con 8 herramientas de acero para modelar arcilla y otros materiales.',
            'barcode'        => '5566778899001',
            'category_id'    => rand(1, 4),
            'cost_price'     => 80.00,
            'sale_price'     => 130.00,
            'stock_quantity' => 25,
            'unit'           => 'unidad',
            'stock_min'      => 5,
            'supplier_id'    => rand(1, 4),
        ]);

        Product::create([
            'name'           => 'Tableta Gráfica Profesional',
            'description'    => 'Tableta digitalizadora con 8192 niveles de presión y área activa de 10x6 pulgadas.',
            'barcode'        => '6677889900112',
            'category_id'    => rand(1, 4),
            'cost_price'     => 400.00,
            'sale_price'     => 650.00,
            'stock_quantity' => 10,
            'unit'           => 'unidad',
            'stock_min'      => 2,
            'supplier_id'    => rand(1, 4),
        ]);

        Product::create([
            'name'           => 'Lápiz Óptico de Alta Precisión',
            'description'    => 'Lápiz digital compatible con tablets y tabletas gráficas.',
            'barcode'        => '7788990011223',
            'category_id'    => rand(1, 4),
            'cost_price'     => 120.00,
            'sale_price'     => 200.00,
            'stock_quantity' => 40,
            'unit'           => 'unidad',
            'stock_min'      => 8,
            'supplier_id'    => rand(1, 4),
        ]);

        Product::create([
            'name'           => 'Póster "La Noche Estrellada" 60x90cm',
            'description'    => 'Reproducción de alta calidad de la obra de Van Gogh en papel couché.',
            'barcode'        => '8899001122334',
            'category_id'    => rand(1, 4),
            'cost_price'     => 50.00,
            'sale_price'     => 95.00,
            'stock_quantity' => 100,
            'unit'           => 'unidad',
            'stock_min'      => 10,
            'supplier_id'    => rand(1, 4),
        ]);

        Product::create([
            'name'           => 'Colección de Postales de Arte',
            'description'    => 'Kit con 20 tarjetas postales de obras de arte famosas.',
            'barcode'        => '9900112233445',
            'category_id'    => rand(1, 4),
            'cost_price'     => 15.00,
            'sale_price'     => 30.00,
            'stock_quantity' => 200,
            'unit'           => 'unidad',
            'stock_min'      => 20,
            'supplier_id'    => rand(1, 4),
        ]);
    }
}
