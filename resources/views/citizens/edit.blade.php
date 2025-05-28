<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Editar Ciudadano
            </h2>
            <a href="{{ route('citizens.index') }}" 
               class="px-4 py-2 bg-gray-300 text-gray-800 text-sm rounded-md hover:bg-gray-400">
                ← Volver al listado
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-6 text-center">Editar Ciudadano</h3>

                <form action="{{ route('citizens.update', $citizen->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Nombre
                        </label>
                        <input type="text" name="first_name" id="first_name"
                               value="{{ old('first_name', $citizen->first_name) }}"
                               class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('first_name')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Apellido
                        </label>
                        <input type="text" name="last_name" id="last_name"
                               value="{{ old('last_name', $citizen->last_name) }}"
                               class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('last_name')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="birth_date" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Fecha de nacimiento
                        </label>
                        <input type="date" name="birth_date" id="birth_date"
                               value="{{ old('birth_date', $citizen->birth_date) }}"
                               class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('birth_date')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Teléfono
                        </label>
                        <input type="text" name="phone" id="phone"
                               value="{{ old('phone', $citizen->phone) }}"
                               class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('phone')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Dirección
                        </label>
                        <input type="text" name="address" id="address"
                               value="{{ old('address', $citizen->address) }}"
                               class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('address')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="city_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Ciudad
                        </label>
                        <select name="city_id" id="city_id"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Seleccione una ciudad</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}" {{ old('city_id', $citizen->city_id) == $city->id ? 'selected' : '' }}>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('city_id')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-black text-sm rounded-md hover:bg-blue-700 transition">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
