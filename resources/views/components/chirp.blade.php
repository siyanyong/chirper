@props(['chirp']) {{-- Passing in a Chirp model --}}

<div class="card bg-base-100 shadow">
    <div class="card-body">
        {{-- Flex for avatar and content --}}
        <div class="flex space-x-3">
            @if ($chirp->user)
                {{-- if user exists --}}
                <div class="avatar">
                    <div class="size-10 rounded-full">
                        <img src="https://avatars.laravel.cloud/{{ urlencode($chirp->user->email) }}"
                            alt="{{ $chirp->user->name }}'s avatar" class="rounded-full" />
                    </div>
                </div>
            @else
                {{-- else if user does not exist --}}
                <div class="avatar placeholder">
                    <div class="size-10 rounded-full">
                        <img src="https://avatars.laravel.cloud/f61123d5-0b27-434c-a4ae-c653c7fc9ed6?vibe=stealth"
                            alt="Anonymous User" class="rounded-full" />
                    </div>
                </div>
            @endif
            {{-- What we had previously:  --}}
            <div class="min-w-0 flex-1">
                {{-- Flex for name/time and action buttons --}}
                <div class="flex justify-between w-full">
                    {{-- Flex for name and time --}}
                    <div class="flex items-center gap-1">
                        <span class="text-sm font-semibold">{{ $chirp->user ? $chirp->user->name : 'Anonymous' }}</span>
                        <span class="text-base-content/60">·</span>
                        <span class="text-sm text-base-content/60">{{ $chirp->created_at->diffForHumans() }}</span>
                        @if ($chirp->updated_at->gt($chirp->created_at->addSeconds(5)))
                            <span class="text-base-content/60">·</span>
                            <span class="text-sm text-base-content/60 italic">edited</span>
                        @endif
                    </div>
                    {{-- Flex for action buttons --}}
                    <div class="flex gap-1">
                        <a href="/chirps/{{ $chirp->id }}/edit" class="btn btn-ghost btn-xs">
                            Edit
                        </a>
                        <form method="POST" action="/chirps/{{ $chirp->id }}">
                            @csrf
                            @method('DELETE')
                            {{-- HTTP method spoofing since only GET and POST allowed --}}
                            <button type="submit"
                                onclick="return confirm('Are you sure you want to delete this chirp?')"
                                class="btn btn-ghost btn-xs text-error">
                                Delete
                            </button>
                            {{-- client-side! confirm() is JS --}}
                            {{-- the browser secretly wraps that string in a function --}}
                            {{-- false means that form is not submitted --}}
                        </form>
                    </div>
                </div>

                <p class="mt-1">
                    {{ $chirp->message }}
                </p>
            </div>
        </div>
    </div>
</div>
