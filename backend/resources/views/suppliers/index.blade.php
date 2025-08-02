@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Listado de Proveedores</h1>
        <a href="{{ route('suppliers.create') }}" class="btn btn-primary">Crear Nuevo Proveedor</a>
    </div>

    @if ($suppliers->isEmpty())
        <div class="alert alert-info">No hay proveedores registrados.</div>
    @else
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de la Empresa</th>
                    <th>Contacto</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suppliers as $supplier)
                    <tr>
                        <td>{{ $supplier->id }}</td>
                        <td>{{ $supplier->name }}</td>
                        <td>{{ $supplier->contact_name }}</td>
                        <td>{{ $supplier->email }}</td>
                        <td>
                            <a href="{{ route('suppliers.show', $supplier) }}" class="btn btn-info btn-sm">Ver</a>
                            <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este proveedor?');">
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