<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Make a Payment for {{ $project->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Invoicing Section -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold mb-2">Invoice Details</h2>
                        <div class="overflow-x-auto">
                            <table class="table-auto border-collapse border border-gray-800 w-full">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="border border-gray-600 px-4 py-2">Description</th>
                                        <th class="border border-gray-600 px-4 py-2">Amount (RM)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border border-gray-600 px-4 py-2">Project Name</td>
                                        <td class="border border-gray-600 px-4 py-2">{{ $project->title }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-600 px-4 py-2">Project Description</td>
                                        <td class="border border-gray-600 px-4 py-2">{{ $project->description }}</td>
                                    </tr>
                                    @if($collaboration)
                                    <tr>
                                        <td class="border border-gray-600 px-4 py-2">Designer Email</td>
                                        <td class="border border-gray-600 px-4 py-2">{{ $collaboration->designer->email }}</td>
                                    </tr>
                                    @endif
                                    <!-- Add more invoice details as needed -->
                                    <tr>
                                        @php
                                            $totalCost = $finance->actual_cost + $finance->tax + $finance->additional_fees;
                                        @endphp
                                        <td class="border border-gray-600 px-4 py-2">Breakdown of Price</td>
                                        <td class="border border-gray-600 px-4 py-2">
                                            <ul>
                                                <li>Proposed Cost: RM{{ number_format($finance->cost_estimation, 2) }}</li>
                                                <li>Actual Cost: RM{{ number_format($finance->actual_cost, 2) }}</li>
                                                <li>Tax: RM{{ number_format($finance->tax, 2) }}</li>
                                                <li>Additional Fees: RM{{ number_format($finance->additional_fees, 2) }}</li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-600 px-4 py-2 font-bold">Total Amount Due</td>
                                        <td class="border border-gray-600 px-4 py-2 font-bold">RM{{ number_format($totalCost, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Payment Form -->
                    <form id="payment-form" action="{{ route('process.payment', $project->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="card-element" class="block text-gray-700 font-bold mb-2">Credit or Debit Card</label>
                            <div id="card-element" class="border border-gray-300 p-2 rounded-lg"></div>
                            <div id="card-errors" role="alert" class="text-red-500 mt-2"></div>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        // Stripe Payment Integration
        const stripe = Stripe('{{ env('STRIPE_KEY') }}');
        const elements = stripe.elements();
        const card = elements.create('card');
        card.mount('#card-element');

        const form = document.getElementById('payment-form');
        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            const { token, error } = await stripe.createToken(card);
            if (error) {
                document.getElementById('card-errors').textContent = error.message;
            } else {
                const hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);
                form.submit();
            }
        });
    </script>
</x-app-layout>
