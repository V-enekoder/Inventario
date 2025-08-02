@extends('layouts.app')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Crear Nuevo Movimiento de Stock</h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">¡Ups!</strong>
                <span class="block sm:inline">Hay algunos problemas con tu entrada.</span>
                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('stock-movements.store') }}" method="POST">
            @include('stock-movements._form', ['btnText' => 'Guardar Movimiento'])
        </form>
    </div>
</div>
@endsection