@extends('layouts.app')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-700">Movimientos de Stock</h2>
            <a href="{{ route('stock-movements.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                Crear Nuevo Movimiento
            </a>
        </div>
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($stockMovements as $movement)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $movement->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $movement->product->name ?? 'Producto no encontrado' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $movement->type == 'entrada' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $movement->type == 'salida' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $movement->type == 'ajuste' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                    {{ ucfirst($movement->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $movement->quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('stock-movements.show', $movement) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Ver</a>
                                <a href="{{ route('stock-movements.edit', $movement) }}" class="text-blue-600 hover:text-blue-900 mr-3">Editar</a>
                                <form action="{{ route('stock-movements.destroy', $movement) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este movimiento?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No se encontraron movimientos de stock.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $stockMovements->links() }} {{-- Para la paginación --}}
        </div>
    </div>
</div>
@endsection