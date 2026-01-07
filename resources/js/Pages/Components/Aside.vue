<script setup>

</script>

<template>
    <!-- Sidebar -->
    <aside
        class="-mx-4 my-4 hidden w-80 shrink-0 overflow-y-auto px-4 lg:block"
    >
        <input
            type="text"
            placeholder="#Search an idea or pixel"
            class="border-pixel-light/50 w-full text-sm"
        />
        <hr class="border-pixel-light/10 mt-2" />
        <!-- Artists to follow -->
<!--        <x-artist-to-follow />-->

        <!-- Follow idea streams -->
        <div class="border-pixel-light/10 mt-4 border p-4">
            <h2 class="text-pixel-light/60 text-sm">Follow Idea Streams</h2>
            <ol class="mt-4 flex flex-col gap-2.5">
                <li class="flex items-center justify-between gap-4">
                    <p class="truncate text-sm">Breakfast ideas and whatever</p>
                    <button
                        class="bg-pixel-dark/50 hover:bg-pixel-dark/60 active:bg-pixel-dark/75 border-pixel/50 hover:border-pixel/60 active:border-pixel/75 text-pixel grid size-7 shrink-0 place-items-center border text-2xl leading-none"
                    >
                        +
                    </button>
                </li>
                <li class="flex items-center justify-between gap-4">
                    <p class="truncate text-sm">Quick book to read</p>
                    <button
                        class="bg-pixel-dark/50 hover:bg-pixel-dark/60 active:bg-pixel-dark/75 border-pixel/50 hover:border-pixel/60 active:border-pixel/75 text-pixel grid size-7 shrink-0 place-items-center border text-2xl leading-none"
                    >
                        +
                    </button>
                </li>
                <li class="flex items-center justify-between gap-4">
                    <p class="truncate text-sm">Inspiration for Art</p>
                    <button
                        class="bg-pixel-dark/50 hover:bg-pixel-dark/60 active:bg-pixel-dark/75 border-pixel/50 hover:border-pixel/60 active:border-pixel/75 text-pixel grid size-7 shrink-0 place-items-center border text-2xl leading-none"
                    >
                        +
                    </button>
                </li>
            </ol>
            <a href="#" class="text-pixel-light/60 mt-4 inline-block text-sm"
            >Show more</a
            >
        </div>
    </aside>

</template>
