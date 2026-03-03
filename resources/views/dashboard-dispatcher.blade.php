<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot> --}}

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <livewire:diets-manager />
    </div>
</x-app-layout>

{{-- <label for="consistency">Consistencia</label>
<select class="selectpicker form-control mb-1" name="consistency[]" multiple data-style="btn-light">
     @foreach($options as $value => $label)
        <option value="{{ $value }}"
            {{ in_array($value, $selectedConsistencies) ? 'selected' : '' }}>
            {{ $label }}
        </option>
    @endforeach
</select>

<label for="specifications">Especificaciones</label>
<select class="selectpicker form-control mb-1" name="specifications[]" multiple data-style="btn-primary">
    <option value="hipoglucida">Hipoglúcida</option>
    <option value="hiperproteica">Hiperprotéica</option>
    <option value="hiposodica">Hiposódica</option>
    <option value="hipograsa">Hipograsa</option>
    <option value="astringente">Astringente</option>
    <option value="alta_en_fibra">Alta en fibra</option>
    <option value="sin_lacteos">Sin lácteos</option>
    <option value="sin_irritantes">Sin irritantes</option>
    <option value="hipercalorica">Hipercalórica</option>
</select> --}}
