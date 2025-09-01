@extends('layouts.layout')
@section('title', 'Bargain Details')
@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Bargain Details</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <img src="{{ $bargain->profile_image ? asset('storage/' . $bargain->profile_image) : 'https://via.placeholder.com/150' }}"
                    class="rounded w-48 h-48 object-cover mb-4">
                <p><span class="font-bold">Name:</span> {{ $bargain->name }}</p>
                <p><span class="font-bold">Username:</span> {{ $bargain->username }}</p>
                <p><span class="font-bold">Registration No:</span> {{ $bargain->registration_number }}</p>
                <p><span class="font-bold">Status:</span> {{ $bargain->status }}</p>
            </div>
            <div>
                <p><span class="font-bold">Email:</span> {{ $bargain->email }}</p>
                <p><span class="font-bold">Website:</span> {{ $bargain->website }}</p>
                <p><span class="font-bold">Phone:</span> {{ $bargain->phone }}</p>
                <p><span class="font-bold">Whatsapp:</span> {{ $bargain->whatsapp }}</p>
                <p><span class="font-bold">Address:</span> {{ $bargain->address }}</p>
            </div>
        </div>

        <div class="mt-6 flex gap-2">
            <a href="{{ route('bargains.edit', $bargain->id) }}"
                class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Edit</a>
            <a href="{{ route('bargains.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Back</a>
        </div>
    </div>
@endsection
