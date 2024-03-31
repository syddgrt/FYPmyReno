<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modify Portfolio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-black-900 dark:text-black-100">
                    <!-- Your modification form goes here -->
                    <form action="{{ route('portfolios.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <!-- Title input -->
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-black-700 dark:text-black-300">Title</label>
                            <input type="text" name="title" id="title" value="{{ $portfolio->title }}" class="mt-1 p-2 w-full border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        
                        <!-- Description input -->
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                            <textarea name="description" id="description" class="mt-1 p-2 w-full border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">{{ $portfolio->description }}</textarea>
                        </div>
                        
                        <!-- Image or text description selection -->
                        <div class="mb-4">
                            <label for="submission_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Submission Type</label>
                            <select name="submission_type" id="submission_type" class="mt-1 p-2 w-full border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="image" selected>Image</option>
                                <option value="text">Text Description</option>
                            </select>
                        </div>
                        
                        <!-- Image upload input -->
                        <div class="mb-4" id="image_upload">
                            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Image</label>
                            <input type="file" name="image" id="image" class="mt-1 p-2 w-full border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        
                        <!-- Text description input -->
                        <div class="mb-4" id="text_description" style="display: none;">
                            <label for="text_description_content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Text Description</label>
                            <textarea name="text_description_content" id="text_description_content" rows="5" class="mt-1 p-2 w-full border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        </div>
                        
                        <!-- Submit button -->
                        <div class="flex justify-end">
                            <button type="submit" class="bg-indigo-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const imageUpload = document.getElementById('image_upload');
        const textDescription = document.getElementById('text_description');
        const submissionTypeSelect = document.getElementById('submission_type');

        // Hide/show image or text description input based on selection
        submissionTypeSelect.addEventListener('change', function () {
            if (submissionTypeSelect.value === 'image') {
                imageUpload.style.display = 'block';
                textDescription.style.display = 'none';
            } else if (submissionTypeSelect.value === 'text') {
                imageUpload.style.display = 'none';
                textDescription.style.display = 'block';
            }
        });
    });
</script>
