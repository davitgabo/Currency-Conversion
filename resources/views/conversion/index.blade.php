<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currency Converter</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
<div class="bg-white shadow-md rounded-lg p-8 max-w-lg w-full">
    <h1 class="text-2xl font-semibold text-gray-700 mb-6">Currency Converter</h1>

    <form method="GET" class="space-y-6">
        @csrf

        <!-- From Currency -->
        <div>
            <label for="from_currency" class="block text-sm font-medium text-gray-700">From Currency</label>
            <select name="from_currency" id="from_currency" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="">Select Currency</option>
                <option value="EUR" {{ (isset($response['from_currency']) && $response['from_currency'] === 'EUR') ? 'selected' : '' }}>EUR</option>
                <option value="USD" {{ (isset($response['from_currency']) && $response['from_currency'] === 'USD') ? 'selected' : '' }}>USD</option>
                <option value="GEL" {{ (isset($response['from_currency']) && $response['from_currency'] === 'GEL') ? 'selected' : '' }}>GEL</option>
            </select>
            @error('from_currency')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- To Currency -->
        <div>
            <label for="to_currency" class="block text-sm font-medium text-gray-700">To Currency</label>
            <select name="to_currency" id="to_currency" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="">Select Currency</option>
                <option value="EUR" {{ (isset($response['to_currency']) && $response['to_currency'] === 'EUR') ? 'selected' : '' }}>EUR</option>
                <option value="USD" {{ (isset($response['to_currency']) && $response['to_currency'] === 'USD') ? 'selected' : '' }}>USD</option>
                <option value="GEL" {{ (isset($response['to_currency']) && $response['to_currency'] === 'GEL') ? 'selected' : '' }}>GEL</option>
            </select>
            @error('to_currency')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- From Amount -->
        <div>
            <label for="from_amount" class="block text-sm font-medium text-gray-700">From Amount</label>
            <input type="text" name="from_amount" id="from_amount" value="{{ $response['from_amount_decimal'] ?? null }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Enter amount">
            @error('from_amount')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- To Amount -->
        <div>
            <label for="to_amount" class="block text-sm font-medium text-gray-700">To Amount</label>
            <input value="{{ $response['to_amount_decimal'] ?? '' }}" type="text" name="to_amount" id="to_amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Calculated amount">
            @error('to_amount')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Submit Buttons -->
        <div class="flex justify-end space-x-4">
            <button type="reset" class="px-4 py-2 bg-gray-200 rounded-md text-gray-700 hover:bg-gray-300">Reset</button>
            <button
                type="submit"
                formaction="{{ route('currency.convert') }}"
                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                Convert
            </button>
            <button
                type="submit"
                formaction="{{ route('currency.pay') }}"
                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                Pay
            </button>
        </div>
    </form>
</div>
</body>
</html>
