@extends('layouts.app')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Payments') }}
</h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-2xl font-bold mb-4">Make Payment</h3>

                @if (session('success'))
                <div id="success-banner" class="bg-green-200 text-green-800 p-4 mb-4 rounded-lg">
                    {{ session('success') }}
                </div>
                @endif

                @if (session('error'))
                <div id="success-banner" class="bg-red-200 text-red-800 p-4 mb-4 rounded-lg">
                    {{ session('error') }}
                </div>
                @endif

                <form action="{{ route('tenant.payments.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <x-label for="phone_number" :value="__('Phone Number')" />
                        <x-input id="phone_number" class="block mt-1 w-full" type="tel" name="phone_number" :value="old('phone_number')" required autofocus />
                        <x-input-error for="phone_number" class="mt-2" />
                    </div>
                    <div class="mb-4">
                        <x-label for="payment_reason_id" :value="__('Reason For Payment')" />
                        <x-select name="payment_reason_id" id="payment_reason_id" :options="$paymentReasons" fieldName="name" idField="id" class="block mt-1 w-full">
                        </x-select>
                        <x-input-error for="payment_reason_id" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-button>
                            {{ __('Make Payment') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection