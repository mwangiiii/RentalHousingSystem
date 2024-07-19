@extends('layouts.app')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Payments Dashboard') }}
</h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-2xl font-bold mb-4">Payments</h3>

                <div class="mb-4">
                    <form method="GET" action="{{ route('landlord.payments.filter') }}">
                        <div class="flex items-center space-x-4">
                            <div>
                                <x-label for="date" :value="__('Date')" />
                                <x-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date')" autofocus />
                            </div>
                            <div>
                                <x-label for="property_id" :value="__('Property')" />
                                <x-select id="property_id" name="property_id" :options="$properties" fieldName="name" idField="id" />
                            </div>
                            <div>
                                <x-label for="status" :value="__('Status')" />
                                <x-select id="status" name="status" :options="$statuses" fieldName="name" idField="id" />
                            </div>
                            <div class="flex items-center justify-end mt-4">
                                <x-button type="submit" class="ml-4">
                                    {{ __('Filter') }}
                                </x-button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Date') }}</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Amount') }}</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Tenant') }}</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Property') }}</th>
                            </tr>
                        </thead>
                        <tbody id="payments-table" class="bg-white divide-y divide-gray-200">
                            @foreach ($payments as $payment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $payment->payment_date }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $payment->amount }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $payment->status }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $payment->tenant->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $payment->tenant->property->name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="pagination-links">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection