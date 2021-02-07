<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add a post') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 py-12">
        <x-validation-errors class="mb-5" :errors="$errors"/>
        <form method="POST">
            @csrf
            <x-label>Title</x-label>
            <x-input required name="title" :placeholder="__('Type a title here...')" />

            <x-label class="mt-5">Content</x-label>
            <x-textarea required name="description" placeholder="Start typing the post content here..." rows="10"/>

            <x-button type="submit" class="text-lg mt-5">Create ></x-button>
        </form>
    </div>
</x-app-layout>
