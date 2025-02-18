<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Détails de la catégorie') }} : {{ $category->name }}
            </h2>
            <a href="{{ route('categories.index') }}"
                class="px-4 py-2 text-white bg-gray-500 rounded hover:bg-gray-600">
                Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Image de la catégorie -->
                        <div>
                            @if($category->image)
                                <img src="{{ asset($category->image) }}" alt="{{ $category->name }}"
                                    class="w-full h-64 object-cover rounded">
                            @else
                                <div class="w-full h-64 bg-gray-200 rounded flex items-center justify-center">
                                    <span class="text-gray-500">Aucune image</span>
                                </div>
                            @endif
                        </div>

                        <!-- Informations de la catégorie -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Informations</h3>
                            <dl class="grid grid-cols-1 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Nom</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $category->name }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Slug</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $category->slug }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $category->description ?? 'Aucune description' }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Mega Catégorie</dt>
                                    <dd class="mt-1">
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full {{ $category->isMega ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $category->isMega ? 'Oui' : 'Non' }}
                                        </span>
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Nombre de produits</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $category->products->count() }}</dd>
                                </div>
                            </dl>

                            <div class="mt-6 flex space-x-3">
                                <a href="{{ route('categories.edit', $category) }}"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                    Modifier
                                </a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700"
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>