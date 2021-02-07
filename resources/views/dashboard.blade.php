<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex justify-between">
            <h3 class="font-semibold text-3xl text-gray-700 leading-tight inline-flex items-center">
                {{ __('My Posts') }}

            </h3>
            <div class="flex items-center">
                <x-dropdown align="left" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>Sort by</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link href="?sort=desc">
                            Latest
                        </x-dropdown-link>
                        <x-dropdown-link href="?sort=asc">
                            Oldest
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
                <x-button class="ml-10" type="button" onclick="location.href = '/dashboard/post'">
                    Add a post >
                </x-button>
            </div>
        </div>

        <hr class="my-8"/>

        @if(!empty(session('success')))
            <div class="mt-3 text-green-600">
                {{ session('success') }}
            </div>
        @endif

        @foreach ($posts as $post)
            <x-blog-post :title="$post->title"
                         :content="$post->description"
                         :date="$post->published_at"
                         :owner="$post->user"
            ></x-blog-post>
        @endforeach
    </div>
</x-app-layout>
