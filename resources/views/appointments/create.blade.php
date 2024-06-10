<x-app-layout>
    <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Schedule Appointment') }}
            </h2>
            <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight mt-2">
                {{ __('For Client') }}: <span class="text-blue-600 dark:text-black-400">{{ $client->name }}</span>
            </h3>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('schedules.store', ['redirect' => 'collaborations.index']) }}">
                        @csrf

                        <div class="mb-4">
                            <label for="project_id" class="block text-gray-700 text-sm font-bold mb-2">Project:</label>
                            <div class="bg-blue-500 text-white px-4 py-2 rounded-full inline-block">
                                {{ $project->title }}
                            </div>
                            <input type="hidden" name="project_id" value="{{ request()->input('project_id') }}">
                        </div>


                        <div class="mb-4">
                            <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Date:</label>
                            <input type="date" name="date" id="date" class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ old('date') }}" required />
                        </div>

                        <div class="mb-4">
                            <label for="time" class="block text-gray-700 text-sm font-bold mb-2">Time:</label>
                            <input type="time" name="time" id="time" class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ old('time') }}" required />
                        </div>

                        <div class="mb-4">
                            <label for="meeting_type" class="block text-gray-700 text-sm font-bold mb-2">Meeting Type:</label>
                            <select name="meeting_type" id="meeting_type" class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                                <option value="online" selected>Online</option>
                                <option value="physical">Physical</option>                               
                            </select>
                        </div>

                        <div class="mb-4" id="online-meeting" style="display: none;">
                            <label for="place" class="block text-gray-700 text-sm font-bold mb-2">Online Platform (include the link):</label>
                            <input type="text" name="place" id="online-place" class="form-input rounded-md shadow-sm mt-1 block w-full" placeholder="Enter online meeting platform" />
                        </div>

                        <div class="mb-4" id="physical-meeting" style="display: none;">
                            <label for="place" class="block text-gray-700 text-sm font-bold mb-2">Place:</label>
                            <input type="text" name="place" id="place" class="form-input rounded-md shadow-sm mt-1 block w-full" placeholder="Enter physical location" />
                            <div id="map-container" style="border: 1px solid #ccc; border-radius: 5px; overflow: hidden;">
                                <div id="map" style="height: 400px;"></div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Display success message -->
    @if(session('success'))
        <script>
            window.location.href = 'http://127.0.0.1:8000/collaboration-requests';
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </script>
    @endif

    <!-- Google Maps API and Places Library -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAUqiIfEi5XPW6cA8ZwzW0qB9Pwfh1FC-g&libraries=places&callback=initMap" async defer></script>

    <script>
        let map, marker, autocomplete, geocoder;

        function initMap() {
            geocoder = new google.maps.Geocoder();

            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 3.197, lng: 101.644},
                zoom: 8
            });

            marker = new google.maps.Marker({
                position: {lat: 3.197, lng: 101.644},
                map: map,
                draggable: true
            });

            // Initialize the autocomplete object
            autocomplete = new google.maps.places.Autocomplete(
                document.getElementById('place'), 
                { types: ['geocode'] }
            );

            // When the user selects an address from the dropdown, populate the address fields
            autocomplete.addListener('place_changed', fillInAddress);

            // Listen for marker drag events
            google.maps.event.addListener(marker, 'dragend', function() {
                geocodePosition(marker.getPosition());
            });

            // Initialize the place input field with the marker's initial position
            geocodePosition(marker.getPosition());
        }

        function geocodePosition(position) {
            geocoder.geocode({location: position}, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        document.getElementById('place').value = results[0].formatted_address;
                    } else {
                        console.error('No results found');
                    }
                } else {
                    console.error('Geocoder failed due to: ' + status);
                }
            });
        }

        function fillInAddress() {
            const place = autocomplete.getPlace();

            if (place.geometry) {
                map.panTo(place.geometry.location);
                map.setZoom(15);
                marker.setPosition(place.geometry.location);
                document.getElementById('place').value = place.formatted_address;
            }
        }

        function toggleMeetingFields() {
            var type = document.getElementById('meeting_type').value;
            if (type === 'physical') {
                document.getElementById('physical-meeting').style.display = 'block';
                document.getElementById('online-meeting').style.display = 'none';
            } else {
                document.getElementById('physical-meeting').style.display = 'none';
                document.getElementById('online-meeting').style.display = 'block';
            }
        }

        // Call the function once when the page loads to set the initial state
        window.onload = toggleMeetingFields;

        // Event listener to toggle extra input fields when meeting type changes
        document.getElementById('meeting_type').addEventListener('change', toggleMeetingFields);
    </script>
</x-app-layout>
