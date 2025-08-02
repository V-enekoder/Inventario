@extends('layouts.app')

@section('content')
    <h1>Editar Proveedor: {{ $supplier->name }}</h1>

    <form action="{{ route('suppliers.update', $supplier) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="name" class="form-label">Nombre de la Empresa</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $supplier->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="contact_name" class="form-label">Nombre del Contacto</label>
            <input type="text" class="form-control @error('contact_name') is-invalid @enderror" id="contact_name" name="contact_name" value="{{ old('contact_name', $supplier->contact_name) }}">
            @error('contact_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $supplier->email) }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Teléfono</label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $supplier->phone) }}">
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Dirección</label>
            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address', $supplier->address) }}</textarea>
            @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">Actualizar Proveedor</button>
    </form>
@endsection