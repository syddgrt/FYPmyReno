<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Leave a Review') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('reviews.store', $project) }}" method="POST" id="reviewForm">
                            
                        @csrf
    <input type="hidden" name="project_id" value="{{ $project->id }}">
    <input type="hidden" name="designer_id" value="{{ $designer->id }}">
    <input type="hidden" name="collaboration_id" value="{{ $collaboration->id }}"> <!-- Add this line -->
                        
                        <div class="mb-4">
                            <label for="rating" class="block text-gray-700 text-sm font-bold mb-2">Rating:</label>
                            <div class="flex items-center">
                                <div id="ratingStars" class="rating">
                                    <input type="radio" name="rating" id="star5" value="5"><label for="star5"></label>
                                    <input type="radio" name="rating" id="star4" value="4"><label for="star4"></label>
                                    <input type="radio" name="rating" id="star3" value="3"><label for="star3"></label>
                                    <input type="radio" name="rating" id="star2" value="2"><label for="star2"></label>
                                    <input type="radio" name="rating" id="star1" value="1"><label for="star1"></label>
                                </div>
                                <div class="ml-2 rating-value">0</div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="feedback" class="block text-gray-700 text-sm font-bold mb-2">Feedback:</label>
                            <textarea name="feedback" id="feedback" class="form-textarea rounded-md shadow-sm mt-1 block w-full" rows="4"></textarea>
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Submit Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: space-between;
        }
        .rating input[type="radio"] {
            display: none;
        }
        .rating label {
            cursor: pointer;
            width: 30px;
            height: 30px;
            background-color: #ccc;
            border-radius: 50%;
            margin: 0 2px;
            position: relative;
        }
        .rating label::before {
            content: "\2605";
            font-size: 24px;
            color: #fff;
            line-height: 30px;
            text-align: center;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }
        .rating input[type="radio"]:checked ~ label {
            background-color: #f90;
        }
    </style>

<script>
    const stars = document.querySelectorAll('.rating input');
    const ratingValue = document.querySelector('.rating-value');

    stars.forEach((star) => {
        star.addEventListener('click', () => {
            const rating = star.value;
            ratingValue.textContent = rating;
            document.querySelector('input[name="rating"]').value = rating;
        });
    });
</script>
</x-app-layout>
