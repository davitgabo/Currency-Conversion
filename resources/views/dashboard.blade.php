<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="table-auto w-full border-collapse border border-gray-200">
                        <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-200 px-4 py-2">Order ID</th>
                            <th class="border border-gray-200 px-4 py-2">Customer Email</th>
                            <th class="border border-gray-200 px-4 py-2">Order Date</th>
                            <th class="border border-gray-200 px-4 py-2">From Currency</th>
                            <th class="border border-gray-200 px-4 py-2">To Currency</th>
                            <th class="border border-gray-200 px-4 py-2">From Amount</th>
                            <th class="border border-gray-200 px-4 py-2">To Amount</th>
                            <th class="border border-gray-200 px-4 py-2">Status</th>
                            <th class="border border-gray-200 px-4 py-2">Payed</th>
                            <th class="border border-gray-200 px-4 py-2">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td class="border border-gray-200 px-4 py-2">{{ $order->id }}</td>
                                <td class="border border-gray-200 px-4 py-2">{{ $order->email }}</td>
                                <td class="border border-gray-200 px-4 py-2">{{ $order->order_date }}</td>
                                <td class="border border-gray-200 px-4 py-2">{{ $order->from_currency}}</td>
                                <td class="border border-gray-200 px-4 py-2">{{ $order->to_currency}}</td>
                                <td class="border border-gray-200 px-4 py-2">{{ $order->from_amount}}</td>
                                <td class="border border-gray-200 px-4 py-2">{{ $order->to_amount}}</td>
                                <td class="border border-gray-200 px-4 py-2">{{ $order->status }}</td>
                                <td class="border border-gray-200 px-4 py-2">{{ $order->payed }}</td>
                                <td class="border border-gray-200 px-4 py-2">
                                    <form action="{{ route('orders.approve', $order->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Approve</button>
                                    </form>
                                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="inline-block ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
