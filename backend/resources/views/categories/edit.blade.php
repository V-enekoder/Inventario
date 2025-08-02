@extends('layouts.app')

@section('content')
    <h1>Editar Categoría: {{ $category->name }}</h1>

    <form action="{{ route('categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="name" class="form-label">Nombre de la Categoría</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $category->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Descripción (Opcional)</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">Actualizar Categoría</button>
    </form>
@endsection