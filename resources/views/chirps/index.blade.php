<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chirp') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 lg:p-8">
                    <div>
                        <form method="POST" action="{{ route('chirps.store') }}">
                            @csrf
                            <textarea
                                name="message"
                                placeholder="{{ __('What\'s on your mind?') }}"
                                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            >{{ old('message') }}</textarea>
                            <x-input-error :messages="$errors->get('message')" class="mt-2"/>
                            <x-primary-button class="mt-4">{{ __('Chirp') }}</x-primary-button>
                        </form>
                    </div>
                    <div class="mt-8 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                                    <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                                        @forelse ($chirps as $chirp)
                                            <div class="p-6 flex space-x-2">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="h-6 w-6 text-gray-600 -scale-x-100" fill="none"
                                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                                </svg>
                                                <div class="flex-1">
                                                    <div class="flex justify-between items-center">
                                                        <div>
                                                            <span class="text-gray-800">{{ $chirp->user->name }}</span>
                                                            <small
                                                                class="ml-2 text-sm text-gray-600">{{ $chirp->created_at->format('j M Y, g:i a') }}</small>
                                                            @unless ($chirp->created_at->eq($chirp->updated_at))
                                                                <small class="text-sm text-gray-600">
                                                                    &middot; {{ __('edited') }}</small>
                                                            @endunless
                                                        </div>
                                                        @if ($chirp->user->is(auth()->user()))
                                                            <x-dropdown>
                                                                <x-slot name="trigger">
                                                                    <button>
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                             class="h-4 w-4 text-gray-400"
                                                                             viewBox="0 0 20 20" fill="currentColor">
                                                                            <path
                                                                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                                        </svg>
                                                                    </button>
                                                                </x-slot>
                                                                <x-slot name="content">
                                                                    <x-dropdown-link
                                                                        :href="route('chirps.edit', $chirp)">
                                                                        {{ __('Edit') }}
                                                                    </x-dropdown-link>
                                                                    <form method="POST" action="{{ route('chirps.destroy', $chirp) }}">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <x-dropdown-link :href="route('chirps.destroy', $chirp)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                                            {{ __('Delete') }}
                                                                        </x-dropdown-link>
                                                                    </form>
                                                                </x-slot>
                                                            </x-dropdown>
                                                        @endif
                                                    </div>
                                                    <p class="mt-4 text-lg text-gray-900">{{ $chirp->message }}</p>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-center p-6">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none"
                                                     viewBox="0 0 24 24" stroke="currentColor"
                                                     aria-hidden="true">
                                                    <path vector-effect="non-scaling-stroke"
                                                          stroke-linecap="round"
                                                          stroke-linejoin="round" stroke-width="2"
                                                          d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                                                </svg>
                                                <h3 class="mt-2 text-sm font-semibold text-gray-900">No
                                                    chirps</h3>
                                                <p class="mt-1 text-sm text-gray-500">Get started by creating a
                                                    new
                                                    Chirp.</p>
                                                <div class="mt-6">
                                                    <a href="{{route('chirps.create')}}"
                                                       class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                        <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20"
                                                             fill="currentColor" aria-hidden="true">
                                                            <path
                                                                d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"/>
                                                        </svg>
                                                        New Chirp
                                                    </a>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                                <div class="mt-6">
                                    {{$chirps->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
