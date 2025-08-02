@extends('layouts.app')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-700">Detalles del Movimiento #{{ $movement->id }}</h2>
            <a href="{{ route('stock-movements.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                Volver al listado
            </a>
        </div>

        <div class="space-y-4">
            <div>
                <strong class="text-gray-600">ID:</strong>
                <span class="text-gray-800">{{ $movement->id }}</span>
            </div>
            <div>
                <strong class="text-gray-600">Producto:</strong>
                <span class="text-gray-800">{{ $movement->product->name ?? 'N/A' }}</span>
            </div>
            <div>
                <strong class="text-gray-600">Tipo:</strong>
                <span class="text-gray-800">{{ ucfirst($movement->type) }}</span>
            </div>
            <div>
                <strong class="text-gray-600">Cantidad:</strong>
                <span class="text-gray-800">{{ $movement->quantity }}</span>
            </div>
            <div>
                <strong class="text-gray-600">Motivo:</strong>
                <p class="text-gray-800">{{ $movement->reason ?? 'Sin motivo especificado' }}</p>
            </div>
            <div>
                <strong class="text-gray-600">Fecha de Creación:</strong>
                <span class="text-gray-800">{{ $movement->created_at->format('d/m/Y H:i:s') }}</span>
            </div>
            <div>
                <strong class="text-gray-600">Última Actualización:</strong>
                <span class="text-gray-800">{{ $movement->updated_at->format('d/m/Y H:i:s') }}</span>
            </div>
        </div>

        <div class="mt-6 border-t pt-4">
             <a href="{{ route('stock-movements.edit', $movement) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Editar</a>
        </div>
    </div>
</div>
@endsection