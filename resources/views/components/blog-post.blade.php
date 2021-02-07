<article class="mt-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h1 class="text-4xl text-weight-600">{{ $title }}</h1>
            <div class="text-gray-600">
                Published at {{ $date->format('F jS, Y') }} by {{ $owner->name }}
            </div>
            <p class="mt-3 text-gray-700 text-xl">
                {{ $content }}
            </p>
        </div>
    </div>
</article>
