<x-app-layout>
<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            {{ __('Gestión de Ciudades') }}
        </h2>

        <div class="flex items-center gap-3">
            <!-- Botón: Crear Ciudad -->
            <a href="{{ route('cities.create') }}" 
               class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md shadow hover:bg-blue-700 transition">
                + Crear Ciudad
            </a>

            <!-- Botón: Importar -->
            <button onclick="document.getElementById('importModalCity').showModal()" 
                    class="px-4 py-2 bg-green-600 text-white text-sm rounded-md shadow hover:bg-green-700 transition">
                Importar
            </button>
        </div>
    </div>

    <!-- Modal de Importación de Ciudades -->
    <dialog id="importModalCity" class="rounded-lg p-6 shadow-xl w-full max-w-md backdrop:bg-black/30">
        <form method="POST" action="{{ route('cities.import') }}" enctype="multipart/form-data">
            @csrf
            <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Importar archivo XLSX/CSV</h2>

            <input type="file" name="file" 
                   class="mb-4 w-full border px-4 py-2 rounded text-sm" required>

            <div class="flex justify-end gap-4 mt-4">
                <button type="button" onclick="document.getElementById('importModalCity').close()" 
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    Cancelar
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Importar
                </button>
            </div>
        </form>
    </dialog>
</x-slot>


    <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8"
         x-data="{ showModal: false, selectedCity: {} }"
         @open-city-modal.window="selectedCity = $event.detail; showModal = true">

        <h3 class="text-lg font-bold mb-8 text-center text-gray-800 dark:text-gray-100">Listado de Ciudades</h3>

        @if ($cities->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($cities as $city)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 flex flex-col justify-between transform transition-all duration-300 
                                hover:shadow-2xl hover:scale-105 hover:bg-gray-100 dark:hover:bg-gray-700"
                         x-data="{ confirmDelete: false, editMode: false }">

                        <!-- Vista normal -->
                        <template x-if="!editMode">
                            <div>
                                <h4 class="text-xl font-semibold text-gray-900 dark:text-white cursor-pointer"
                                    @click="$dispatch('open-city-modal', {
                                        id: '{{ $city->id }}',
                                        name: '{{ $city->name }}',
                                        description: '{{ $city->description }}',
                                        created_at: '{{ optional($city->created_at)->format('d/m/Y') }}'
                                    })">
                                    {{ $city->name }}
                                </h4>
                                
                                <p class="mt-2 text-gray-600 dark:text-gray-300">{{ $city->description }}</p>

                                <div class="mt-6 flex justify-between">
                                    <button @click="editMode = true"
                                            class="text-blue-600 hover:underline font-semibold">Editar</button>
                                    <button @click="confirmDelete = true"
                                            class="text-red-600 hover:underline font-semibold">Eliminar</button>
                                </div>
                            </div>
                        </template>

                        <!-- Formulario de edición -->
                        <template x-if="editMode">
                            <form method="POST" action="{{ route('cities.update', $city->id) }}" class="mt-2">
                                @csrf
                                @method('PUT')

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                                    <input type="text" name="name" value="{{ $city->name }}"
                                        class="mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                                    <textarea name="description"
                                        class="mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ $city->description }}</textarea>
                                </div>

                                <div class="flex justify-end space-x-3">
                                    <button type="button" @click="editMode = false"
                                        class="px-3 py-1 bg-gray-300 dark:bg-gray-600 text-sm rounded hover:bg-gray-400 dark:hover:bg-gray-500 transition">
                                        Cancelar
                                    </button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
                                        Guardar
                                    </button>
                                </div>
                            </form>
                        </template>

                        <!-- Confirmación de eliminación -->
                        <template x-if="confirmDelete">
                            <div class="mt-4 bg-red-100 dark:bg-red-700/40 p-4 rounded shadow">
                                <p class="text-sm text-red-800 dark:text-red-200 mb-3">
                                    ¿Estás seguro de eliminar esta ciudad?
                                </p>
                                <div class="flex justify-end space-x-3">
                                    <button @click="confirmDelete = false"
                                            class="px-3 py-1 bg-gray-300 dark:bg-gray-600 text-sm rounded hover:bg-gray-400 dark:hover:bg-gray-500 transition">
                                        Cancelar
                                    </button>
                                    <form action="{{ route('cities.destroy', $city->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition">
                                            Confirmar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </template>
                    </div>
                @endforeach
            </div>

            <!-- Modal global -->
            <div x-show="showModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                 @click.self="showModal = false">
                <div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow-2xl w-full max-w-md text-gray-800 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold" x-text="selectedCity.name"></h2>
                        <button @click="showModal = false"
                                class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 text-xl">&times;</button>
                    </div>
                    <p x-text="selectedCity.description"></p>
                    <p class="mt-4 text-xs text-gray-500 dark:text-gray-400">
                        ID: <span x-text="selectedCity.id"></span> |
                        Creado: <span x-text="selectedCity.created_at || 'Fecha no disponible'"></span>
                    </p>
                </div>
            </div>

            <!-- Paginación -->
            <div class="mt-8">
                {{ $cities->links() }}
            </div>
        @else
            <div class="text-center text-gray-500 dark:text-gray-400 mt-12">
                No hay ciudades registradas.
            </div>
        @endif
    </div>
</x-app-layout>
