<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Payment Successful!
            <!-- New checkmark icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block text-green-500 animate-checkmark" viewBox="0 0 20 20" fill="white">
    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z" clip-rule="evenodd" />
</svg>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" id="payment-details">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-2xl font-bold mb-4">Payment Details</h3>
                    <div class="mb-4">
                        <p class="font-semibold">Project:</p>
                        <p id="project-title">{{ $project->title }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="font-semibold">Amount:</p>
                        <p id="payment-amount">RM{{ number_format($finance->actual_cost + $finance->tax + $finance->additional_fees, 2) }}</p>
                    </div>
                    <!-- Highlight the charge ID in a colored rectangle -->
                    <div class="mb-4 flex items-center">
                        <div class="bg-gray-200 rounded-md p-2 mr-2">
                            <p class="text-sm font-semibold">Charge ID:</p>
                            <p>{{ $charge->id }}</p>
                        </div>
                        <!-- Clipboard icon for copying the charge ID -->
                        <button onclick="copyChargeId()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out transform hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-4m0 0l4-4m-4 4V4h6a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2h6"/>
                            </svg>
                        </button>
                    </div>
                    <div class="mb-4">
                        <p class="font-semibold">Client:</p>
                        <p>{{ auth()->user()->name }}</p>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('download.invoice') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out transform hover:scale-105">
                            Download Invoice
                        </a>
                    </div>
                    <div class="mt-8">
                        <p class="text-lg font-semibold">Thank you for choosing myReno!</p>
                        @if($collaboration)
                            <p class="text-lg">Special thanks to {{ $collaboration->designer->name }} for their involvement to this project.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fade-in animation for payment details section
        document.addEventListener('DOMContentLoaded', function() {
            const paymentDetails = document.getElementById('payment-details');
            paymentDetails.classList.add('animate-fadeIn');

            // Confetti animation
            confetti();
        });

        // Function to copy the charge ID
        function copyChargeId() {
            const chargeId = "{{ $charge->id }}";
            navigator.clipboard.writeText(chargeId);

            // Show custom popup notification
            showNotification("Charge ID copied to clipboard: " + chargeId);
        }

        // Function to show custom notification
        function showNotification(message) {
            // Create a notification element
            const notification = document.createElement('div');
            notification.classList.add('notification');
            notification.textContent = message;

            // Append notification to the body
            document.body.appendChild(notification);

            // Remove notification after 3 seconds
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
    </script>
</x-app-layout>
<style>
    /* Style for custom notification */
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        z-index: 9999;
        animation: slideIn 0.5s ease forwards, fadeOut 0.5s ease-in-out 2.5s forwards;
    }

    @keyframes slideIn {
        from {
            transform: translateY(-100%);
        }
        to {
            transform: translateY(0);
        }
    }

    @keyframes fadeOut {
        0% {
            opacity: 1;
        }
        100% {
            opacity: 0;
        }
    }

    @keyframes bounce {
    0% {
        transform: translateY(-20%);
    }
    50% {
        transform: translateY(0);
    }
    100% {
        transform: translateY(-20%);
    }
    }

    .animate-checkmark {
        animation: bounce 0.5s infinite;
    }
</style>
