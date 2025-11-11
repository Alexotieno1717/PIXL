<!-- Artists to follow -->
<div class="border-pixel-light/10 mt-10 border p-4">
    <h2 class="text-pixel-light/60 text-sm">Artists to follow</h2>
    <ol class="mt-4 flex flex-col gap-4">
        @foreach($profiles as $profile)
            <li class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-2.5">
                    <img
                        src="{{ $profile->avatar_url }}"
                        alt="Avatar of {{$profile->display_name }}"
                        class="size-8 object-cover"
                    />
                    <p class="truncate text-sm">{{ $profile->handle }}</p>
                </div>
                <button
                    class="bg-pixel-dark/50 hover:bg-pixel-dark/60 active:bg-pixel-dark/75 border-pixel/50 hover:border-pixel/60 active:border-pixel/75 text-pixel border px-2 py-1 text-sm"
                >
                    Follow
                </button>
            </li>
        @endforeach
    </ol>
    <a href="#" class="text-pixel-light/60 mt-4 inline-block text-sm"
    >Show more</a
    >
</div>
