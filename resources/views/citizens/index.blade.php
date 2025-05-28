<x-app-layout>
<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            {{ __('Gestión de Ciudadanos') }}
        </h2>

        <div class="flex items-center gap-3">
            <!-- Botón: Crear -->
            <a href="{{ route('citizens.create') }}" 
               class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md shadow hover:bg-blue-700 transition">
                + Crear Ciudadano
            </a>

            <!-- Botón: Importar -->
            <button onclick="document.getElementById('importModal').showModal()" 
                    class="px-4 py-2 bg-green-600 text-white text-sm rounded-md shadow hover:bg-green-700 transition">
                Importar
            </button>
        </div>
    </div>

    <!-- Modal: Importación de Ciudadanos -->
    <dialog id="importModal" class="rounded-lg p-6 shadow-xl w-full max-w-md backdrop:bg-black/30">
        <form method="POST" action="{{ route('citizens.import') }}" enctype="multipart/form-data">
            @csrf
            <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Importar archivo XLSX/CSV</h2>

            <input type="file" name="file" 
                   class="mb-4 w-full border px-4 py-2 rounded text-sm" required>

            <div class="flex justify-end gap-4 mt-4">
                <button type="button" onclick="document.getElementById('importModal').close()" 
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
         x-data="{ showModal: false, selectedCitizen: {} }"
         @open-citizen-modal.window="selectedCitizen = $event.detail; showModal = true">

        <h3 class="text-lg font-bold mb-8 text-center text-gray-800 dark:text-gray-100">Listado de Ciudadanos</h3>

        @if ($citizens->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($citizens as $citizen)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 flex flex-col justify-between transform transition-all duration-300 
                                hover:shadow-2xl hover:scale-105 hover:bg-gray-100 dark:hover:bg-gray-700"
                         x-data="{ confirmDelete: false }">

                        <div>
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white cursor-pointer"
                                @click="$dispatch('open-citizen-modal', {
                                    id: '{{ $citizen->id }}',
                                    name: '{{ $citizen->first_name }} {{ $citizen->last_name }}',
                                    birth_date: '{{ \Carbon\Carbon::parse($citizen->birth_date)->format('d/m/Y') }}',
                                    phone: '{{ $citizen->phone ?? 'N/D' }}',
                                    address: '{{ $citizen->address ?? 'N/D' }}',
                                    city: '{{ $citizen->city?->name ?? 'Sin ciudad asignada' }}'
                                })">
                                {{ $citizen->first_name }} {{ $citizen->last_name }}
                            </h4>
                            <p class="mt-2 text-gray-600 dark:text-gray-300 text-sm">
                                Ciudad: {{ $citizen->city?->name ?? 'Sin ciudad' }}
                            </p>
                                <p class="mt-2 text-gray-600 dark:text-gray-300 text-sm">
                                Telefono: {{ $citizen->phone ?? 'N/D' }}
                            </p>
                            <p class="mt-2 text-gray-600 dark:text-gray-300 text-sm">
                                Dirección: {{ $citizen->address ?? 'N/D' }}
                            </p>
                        </div>

                        <div class="mt-6 flex justify-between">
                            <a href="{{ route('citizens.edit', $citizen->id) }}"
                               class="text-blue-600 hover:underline font-semibold">Editar</a>
                            <button @click="confirmDelete = true"
                                    class="text-red-600 hover:underline font-semibold">Eliminar</button>
                        </div>

                        <!-- Confirmación de eliminación -->
                        <template x-if="confirmDelete">
                            <div class="mt-4 bg-red-100 dark:bg-red-700/40 p-4 rounded shadow">
                                <p class="text-sm text-red-800 dark:text-red-200 mb-3">
                                    ¿Estás seguro de eliminar a este ciudadano?
                                </p>
                                <div class="flex justify-end space-x-3">
                                    <button @click="confirmDelete = false"
                                            class="px-3 py-1 bg-gray-300 dark:bg-gray-600 text-sm rounded hover:bg-gray-400 dark:hover:bg-gray-500 transition">
                                        Cancelar
                                    </button>
                                    <form action="{{ route('citizens.destroy', $citizen->id) }}" method="POST">
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

            <!-- Modal -->
            <div x-show="showModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                 @click.self="showModal = false">
                <div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow-2xl w-full max-w-md text-gray-800 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold" x-text="selectedCitizen.name"></h2>
                        <button @click="showModal = false"
                                class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 text-xl">&times;</button>
                    </div>
                    <p><strong>Fecha de nacimiento:</strong> <span x-text="selectedCitizen.birth_date"></span></p>
                    <p><strong>Teléfono:</strong> <span x-text="selectedCitizen.phone"></span></p>
                    <p><strong>Dirección:</strong> <span x-text="selectedCitizen.address"></span></p>
                    <p><strong>Ciudad:</strong> <span x-text="selectedCitizen.city"></span></p>
                </div>
            </div>

            <!-- Paginación -->
            <div class="mt-8">
                {{ $citizens->links() }}
            </div>
        @else
            <div class="text-center text-gray-500 dark:text-gray-400 mt-12">
                No hay ciudadanos registrados.
            </div>
        @endif
    </div>
</x-app-layout>
