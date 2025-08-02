@csrf
<!-- Campo Producto -->
<div class="mb-4">
    <label for="product_id" class="block text-sm font-medium text-gray-700">Producto</label>
    {{-- Asumimos que pasas una variable $products con todos los productos --}}
    <select name="product_id" id="product_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        @foreach($products as $product)
            <option value="{{ $product->id }}" 
                {{-- Si hay un error de validación, mantiene el valor antiguo. Si estamos editando, muestra el valor actual. --}}
                {{ (old('product_id', $movement->product_id ?? '') == $product->id) ? 'selected' : '' }}>
                {{ $product->name }}
            </option>
        @endforeach
    </select>
</div>

<!-- Campo Tipo -->
<div class="mb-4">
    <label for="type" class="block text-sm font-medium text-gray-700">Tipo de Movimiento</label>
    <select name="type" id="type" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        <option value="entrada" {{ (old('type', $movement->type ?? '') == 'entrada') ? 'selected' : '' }}>Entrada</option>
        <option value="salida" {{ (old('type', $movement->type ?? '') == 'salida') ? 'selected' : '' }}>Salida</option>
        <option value="ajuste" {{ (old('type', $movement->type ?? '') == 'ajuste') ? 'selected' : '' }}>Ajuste</option>
    </select>
</div>

<!-- Campo Cantidad -->
<div class="mb-4">
    <label for="quantity" class="block text-sm font-medium text-gray-700">Cantidad</label>
    <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $movement->quantity ?? '') }}" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
</div>

<!-- Campo Motivo (Opcional) -->
<div class="mb-6">
    <label for="reason" class="block text-sm font-medium text-gray-700">Motivo o Notas (opcional)</label>
    <textarea name="reason" id="reason" rows="3" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('reason', $movement->reason ?? '') }}</textarea>
</div>

<!-- Botones -->
<div class="flex items-center justify-end">
    <a href="{{ route('stock-movements.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded mr-2">
        Cancelar
    </a>
    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
        {{ $btnText }}
    </button>
</div>