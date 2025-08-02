@extends('layouts.app')

@section('content')
    <h1>Detalles de la Categoría</h1>

    <div class="card">
        <div class="card-header">
            <h4>{{ $category->name }}</h4>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $category->id }}</p>
            <p><strong>Descripción:</strong> {{ $category->description ?? 'Sin descripción' }}</p>
            <p><strong>Creada el:</strong> {{ $category->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Última actualización:</strong> {{ $category->updated_at->format('d/m/Y H:i') }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('categories.index') }}" class="btn btn-primary">Volver al listado</a>
            <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">Editar</a>
        </div>
    </div>
@endsection