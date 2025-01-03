<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Test All APIs') }}
        </h2>
    </x-slot>

    <!-- Display Token -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <!-- Developer Notes Section -->
                <div class="p-6 bg-gray-100 border-b border-gray-200">
                    <p class="text-gray-700 font-bold">
                        {{ __("Developer Notes:") }}
                    </p>
                    <ul class="list-disc pl-5 text-gray-600">
                        <li>{{ __("The links below are for viewing posts.") }}</li>
                        <li>{{ __("For Create, Update, and Delete operations, please use Postman.") }}</li>
                        <p class="text-gray-700 font-bold">{{ __("Postman Instructions:") }}
                        <ul class="list-disc pl-5 text-sm text-gray-500">
                            <li>{{ __("Use the API endpoint URL and the appropriate HTTP method (POST, PUT, DELETE).") }}</li>
                            <li>{{ __("Include necessary parameters in the body for Create and Update requests.") }}</li>
                            <li>{{ __("For Delete requests, provide the post ID in the URL.") }}</li>
                        </ul>
                        <p>{{ __("You must be logged in to perform actions like creating, updating, or deleting posts.") }}</p>
                        <p>{{ __("You can test these APIs using Postman by first logging in and getting a valid token.") }}</p>
                        <p>Your Token for creating a post:
                            <code class="bg-gray-200 px-2 py-1 rounded block">{{ session('token') ? session('token') : 'No Token Found' }}</code>
                        </p>
                        <p>{{ __("The token you receive after logging in should be included in the 'Authorization' header as 'Bearer Token' for API requests.") }}</p>
                        </p>
                        <li>{{ __("For viewing posts, the API links below can be used directly.") }}</li>
                        <li>{{ __("You can test with any user ID that exists in the system.") }}</li>
                        <li>{{ __("The user ID in your token will be automatically included for authorized actions like creating or viewing posts.") }}</li>
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
                            <input type="text" name="title" id="title" placeholder="Enter post title" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        </div>
                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-700">{{ __("Content") }}</label>
                            <textarea name="content" id="content" placeholder="Enter post content" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required></textarea>
                            <input type="hidden" name="api_token" value="{{ session('token') }}"> <!-- Correctly fetch the token -->
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" class="border-b-2 border-black pb-1">
                            {{ __("Create Post") }}
                        </button>

                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
