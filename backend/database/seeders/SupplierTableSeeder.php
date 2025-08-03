<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Supplier::create([
            'name'    => 'Proveedor A',
            'contact' => 'Andrés López',
            'phone'   => '(XX) XXXX-XXXX',
            'email'   => 'proveedorA@example.com',
            'address' => 'Calle Olinto, 112',
        ]);

        Supplier::create([
            'name'    => 'Proveedor B',
            'contact' => 'José Carlos Martínez',
            'phone'   => '(XX) XXXX-XXXX',
            'email'   => 'proveedorB@example.com',
            'address' => 'Calle José Machado, 845',
        ]);

        Supplier::create([
            'name'    => 'Proveedor Q',
            'contact' => 'Marcos Pérez',
            'phone'   => '(XX) XXXX-XXXX',
            'email'   => 'proveedorQ@example.com',
            'address' => 'Plaza Modelo, 789',
        ]);

        Supplier::create([
            'name'    => 'Proveedor R',
            'contact' => 'Amanda García',
            'phone'   => '(XX) XXXX-XXXX',
            'email'   => 'proveedorR@example.com',
            'address' => 'Calle Principal, 123',
        ]);

        Supplier::create([
            'name'    => 'Proveedor S',
            'contact' => 'Josué Santos',
            'phone'   => '(XX) XXXX-XXXX',
            'email'   => 'proveedorS@example.com',
            'address' => 'Avenida Secundaria, 456',
        ]);

        Supplier::create([
            'name'    => 'Proveedor T',
            'contact' => 'Carolina Ruiz',
            'phone'   => '(XX) XXXX-XXXX',
            'email'   => 'proveedorT@example.com',
            'address' => 'Plaza Central, 789',
        ]);

        Supplier::create([
            'name'    => 'Proveedor U',
            'contact' => 'Rafael Ortiz',
            'phone'   => '(XX) XXXX-XXXX',
            'email'   => 'proveedorU@example.com',
            'address' => 'Calle Central, 123',
        ]);

        Supplier::create([
            'name'    => 'Proveedor V',
            'contact' => 'Vanesa Santos',
            'phone'   => '(XX) XXXX-XXXX',
            'email'   => 'proveedorV@example.com',
            'address' => 'Avenida Principal, 456',
        ]);

        Supplier::create([
            'name'    => 'Proveedor W',
            'contact' => 'Gabriel Moreno',
            'phone'   => '(XX) XXXX-XXXX',
            'email'   => 'proveedorW@example.com',
            'address' => 'Plaza Secundaria, 789',
        ]);

        Supplier::create([
            'name'    => 'Proveedor X',
            'contact' => 'Laura Ortiz',
            'phone'   => '(XX) XXXX-XXXX',
            'email'   => 'proveedorX@example.com',
            'address' => 'Calle Modelo, 123',
        ]);

        Supplier::create([
            'name'    => 'Proveedor Y',
            'contact' => 'Diego Santos',
            'phone'   => '(XX) XXXX-XXXX',
            'email'   => 'proveedorY@example.com',
            'address' => 'Avenida de la Prueba, 456',
        ]);

        Supplier::create([
            'name'    => 'Proveedor Z',
            'contact' => 'Juliana Gómez',
            'phone'   => '(XX) XXXX-XXXX',
            'email'   => 'proveedorZ@example.com',
            'address' => 'Plaza del Ejemplo, 789',
        ]);
    }
}
