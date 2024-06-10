<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Appointment
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold mb-4">Edit Appointment</h1>

                    <!-- Display any validation errors here -->
                    @if ($errors->any())
                        <div class="mb-4">
                            <div class="font-medium text-red-600">
                                {{ __('Whoops! Something went wrong.') }}
                            </div>

                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Appointment Edit Form -->
                    <form method="POST" action="{{ route('appointments.update', $appointment->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Date -->
                        <div class="mt-4">
                            <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                            <input id="date" type="date" name="date" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('date', $appointment->date) }}" required>
                        </div>

                        <!-- Time -->
                        <div class="mt-4">
                            <label for="time" class="block text-sm font-medium text-gray-700">Time</label>
                            <input id="time" type="time" name="time" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('time', $appointment->time) }}" required>
                        </div>


                        <!-- Meeting Type -->
                        <div class="mt-4">
                            <label for="meeting_type" class="block text-sm font-medium text-gray-700">Meeting Type</label>
                            <select name="meeting_type" id="meeting_type" class="form-select block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="online" {{ $appointment->meeting_type == 'online' ? 'selected' : '' }}>Online</option>
                                <option value="physical" {{ $appointment->meeting_type == 'physical' ? 'selected' : '' }}>Physical</option>
                            </select>
                        </div>

                        <!-- Online Meeting Place (including link) -->
                        <div class="mt-4" id="online-meeting" style="{{ $appointment->meeting_type == 'online' ? 'display: block;' : 'display: none;' }}">
                            <label for="online-place" class="block text-sm font-medium text-gray-700">Online Meeting Platform (include the link)</label>
                            <input id="online-place" type="text" name="online_place" class="form-input rounded-md shadow-sm mt-1 block w-full" placeholder="Enter online meeting platform" value="{{ old('online_place', $appointment->place) }}">
                        </div>

                        <!-- Physical Meeting Place with Google Maps -->
                        <div class="mt-4" id="physical-meeting" style="{{ $appointment->meeting_type == 'physical' ? 'display: block;' : 'display: none;' }}">
                            <label for="physical-place" class="block text-sm font-medium text-gray-700">Place</label>
                            <input id="physical-place" type="text" name="physical_place" class="form-input rounded-md shadow-sm mt-1 block w-full" placeholder="Enter physical location" value="{{ old('physical_place', $appointment->place) }}">
                            <div id="map-container" style="border: 1px solid #ccc; border-radius: 5px; overflow: hidden;">
                                <div id="map" style="height: 400px;"></div>
                            </div>
                        </div>


                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Appointment</button>
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
                document.getElementById('physical-place'), 
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
                        document.getElementById('physical-place').value = results[0].formatted_address;
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

        console.log('Place:', place); // Log the place object to see its structure

        if (place.geometry) {
            console.log('Place Geometry:', place.geometry); // Log the geometry object
            map.panTo(place.geometry.location);
            map.setZoom(15);
            marker.setPosition(place.geometry.location);
            document.getElementById('physical-place').value = place.formatted_address;
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
        window.onload = function () {
            toggleMeetingFields();
            initMap();
        };

        // Event listener to toggle extra input fields when meeting type changes
        document.getElementById('meeting_type').addEventListener('change', toggleMeetingFields);
    </script>
</x-app-layout>

