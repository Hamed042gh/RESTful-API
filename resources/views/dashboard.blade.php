<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Test All APIs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <!-- Developer Notes Section -->
                <div class="p-6 bg-gray-100 border-b border-gray-200">
                    <p class="text-gray-700 font-bold">
                        {{ __("Developer Notes:") }}
                    </p>
                    <ul class="list-disc pl-5 text-gray-600">
                        <!-- Instructions for using Postman and API testing -->
                        <li>{{ __("The links below are for viewing posts.") }}</li>
                        <li>{{ __("For Create, Update, and Delete operations, please use Postman.") }}</li>
                        <li>{{ __("Postman Instructions:") }}
                            <ul class="list-disc pl-5 text-sm text-gray-500">
                                <li>{{ __("Use the API endpoint URL and the appropriate HTTP method (POST, PUT, DELETE).") }}</li>
                                <li>{{ __("Include necessary parameters in the body for Create and Update requests.") }}</li>
                                <li>{{ __("For Delete requests, provide the post ID in the URL.") }}</li>
                            </ul>
                        </li>
                        <li>{{ __("For viewing posts, the API links below can be used directly.") }}</li>
                    </ul>
                </div>

                <!-- API Test Links Section -->
                <!-- Link to View All Posts -->
                <div class="p-6 text-green-900">
                    <p class="font-semibold">{{ __("Show All Posts:") }}</p>
                    <code class="bg-gray-200 px-2 py-1 rounded block">
                        {{ url('api/v1/posts') }}
                    </code>
                    <p class="text-sm text-gray-600 mt-2">
                        {{ __("Example:") }}
                        <a href="{{ url('api/v1/posts') }}" class="text-blue-500 underline">
                            api/v1/posts
                        </a>
                    </p>
                </div>

                <!-- Link to View a Specific Post -->
                <div class="p-6 text-gray-900">
                    <p class="font-semibold">{{ __("Show a Specific Post:") }}</p>
                    <code class="bg-gray-200 px-2 py-1 rounded block">
                        {{ url('api/v1/posts/{id}') }}
                    </code>
                    <p class="text-sm text-gray-600 mt-2">
                        {{ __("Example:") }}
                        <a href="{{ url('api/v1/posts/1') }}" class="text-blue-500 underline">
                            api/v1/posts/1
                        </a>
                    </p>
                </div>

                <!-- Create Post Form -->
                <div class="p-6 text-gray-900">
                    <p class="font-semibold">{{ __("Create a Post:") }}</p>
                    <form action="{{ route('posts.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">{{ __("Title") }}</label>
                            <input type="text" name="title" id="title" placeholder="Enter post title" required>
                        </div>
                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-700">{{ __("Content") }}</label>
                            <textarea name="content" id="content" placeholder="Enter post content" required></textarea>
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        </div>
                        <!-- Submit Button -->
                        <button type="submit">{{ __("Create Post") }}</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>