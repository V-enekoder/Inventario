@extends('layouts.app')

@section('content')
    <h1>Detalles del Proveedor</h1>

    <div class="card">
        <div class="card-header">
            <h4>{{ $supplier->name }}</h4>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $supplier->id }}</p>
            <p><strong>Nombre del Contacto:</strong> {{ $supplier->contact_name ?? 'No especificado' }}</p>
            <p><strong>Email:</strong> {{ $supplier->email }}</p>
            <p><strong>Teléfono:</strong> {{ $supplier->phone ?? 'No especificado' }}</p>
            <p><strong>Dirección:</strong> {{ $supplier->address ?? 'No especificada' }}</p>
            <p><strong>Registrado el:</strong> {{ $supplier->created_at->format('d/m/Y H:i') }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('suppliers.index') }}" class="btn btn-primary">Volver al listado</a>
            <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-warning">Editar</a>
        </div>
    </div>
@endsection