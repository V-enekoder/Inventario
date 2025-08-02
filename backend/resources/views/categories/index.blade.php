@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Listado de Categorías</h1>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">Crear Nueva Categoría</a>
    </div>

    @if ($categories->isEmpty())
        <div class="alert alert-info">No hay categorías registradas.</div>
    @else
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description ?? 'Sin descripción' }}</td>
                        <td>
                            <a href="{{ route('categories.show', $category) }}" class="btn btn-info btn-sm">Ver</a>
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta categoría?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection