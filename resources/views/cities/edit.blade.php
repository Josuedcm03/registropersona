<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Editar Ciudad
            </h2>
            <a href="{{ route('cities.index') }}" 
               class="px-4 py-2 bg-gray-300 text-gray-800 text-sm rounded-md hover:bg-gray-400">
                ← Volver al listado
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-6 text-center">Editar Ciudad</h3>

                <form action="{{ route('cities.update', $city->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Nombre
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $city->name) }}" 
                               class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('name')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Descripción
                        </label>
                        <textarea name="description" id="description" rows="4" 
                                  class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description', $city->description) }}</textarea>
                        @error('description')
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
