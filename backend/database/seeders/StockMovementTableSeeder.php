<?php

namespace Database\Seeders;

use App\Models\StockMovement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockMovementTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // NOTA: Este seeder asigna un product_id aleatorio entre 1 y 5.
        // Asegúrate de tener al menos 5 productos en tu tabla 'products'
        // antes de ejecutar este seeder para evitar errores de clave foránea.

        StockMovement::create([
            'product_id' => rand(1, 5), // Asigna un producto aleatorio con ID entre 1 y 5
            'quantity'   => 10,
            'type'       => 'entrada',
            'date'       => now(),
            'note'       => 'Recepción de pedido inicial del proveedor A.',
        ]);

        StockMovement::create([
            'product_id' => rand(1, 5),
            'quantity'   => 3,
            'type'       => 'salida', // 'saida' en portugués es 'salida' en español
            'date'       => now(),
            'note'       => 'Venta realizada para el cliente X.',
        ]);

        StockMovement::create([
            'product_id' => rand(1, 5),
            'quantity'   => 25,
            'type'       => 'entrada',
            'date'       => now(),
            'note'       => 'Entrada de nuevo inventario.',
        ]);

        StockMovement::create([
            'product_id' => rand(1, 5),
            'quantity'   => 5,
            'type'       => 'salida',
            'date'       => now(),
            'note'       => 'Envío para la sucursal del centro.',
        ]);

        StockMovement::create([
            'product_id' => rand(1, 5),
            'quantity'   => 2,
            'type'       => 'ajuste', // Un tipo de movimiento adicional como ejemplo
            'date'       => now(),
            'note'       => 'Ajuste de inventario por producto dañado.',
        ]);
    }
}
