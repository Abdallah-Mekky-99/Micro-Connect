<x-layout>
    <x-slot:title>
        Home Feed
    </x-slot:title>

    <div class="max-w-2xl mx-auto">
        @if(request('search'))
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">Search Results</h1>
                    <p class="text-sm text-base-content/60 mt-1">
                        Found {{ count($chirps) }} {{ count($chirps) === 1 ? 'chirp' : 'chirps' }} matching "<span class="font-bold text-primary">{{ request('search') }}</span>"
                    </p>
                </div>
                <a href="{{ route('chirps.index') }}" class="btn btn-sm btn-outline rounded-full">
                    Clear Search
                </a>
            </div>
        @else
            <h1 class="text-3xl font-bold">Latest Chirps</h1>

            <!-- the form -->
            <div class="card bg-base-100 shadow mt-8">
                <div class="card-body">
                    <form method="POST" action="/chirps">
                        @csrf
                        <div class="form-control w-full">
                            <textarea name="message" placeholder="What's on your mind?"
                                class="textarea textarea-bordered w-full resize-none @error('message') textarea-error @enderror" rows="4"
                                required maxlength="255">{{ old('message') }}</textarea>
                            @error('message')
                                <div class="label">
                                    <span class="label-text-alt text-error"> {{ $message }} </span>
                                </div>
                            @enderror
                        </div>

                        <div class="mt-4 flex items-center justify-end">
                            <button type="submit" class="btn btn-primary btn-sm">
                                Chirp
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <div class="space-y-4 mt-8">
            @forelse ($chirps as $chirp)
                <x-chirp :chirp="$chirp" />
            @empty
                <div class="hero py-12 bg-base-100 rounded-xl border border-base-200 shadow-sm mt-8">
                    <div class="hero-content text-center">
                        <div class="max-w-md">
                            <svg class="mx-auto h-12 w-12 opacity-30 text-base-content" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                </path>
                            </svg>
                            @if(request('search'))
                                <p class="mt-4 text-base-content/70 font-medium">No results found for "{{ request('search') }}".</p>
                                <p class="text-xs text-base-content/50 mt-1">Try check your spelling or search for something else.</p>
                                <a href="{{ route('chirps.index') }}" class="btn btn-primary btn-sm mt-4 rounded-full">Clear Search</a>
                            @else
                                <p class="mt-4 text-base-content/60">No chirps yet. Be the first to chirp!</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-layout>
