@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-4xl font-bold mb-8">History</h1>
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="w-1/3 text-left py-3 px-4">Product</th>
                    <th class="w-1/3 text-left py-3 px-4">Amount</th>
                    <th class="text-left py-3 px-4">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($histories as $history)
                    <tr>
                        <td class="w-1/3 text-left py-3 px-4">{{ $history->product->name }}</td>
                        <td class="w-1/3 text-left py-3 px-4">{{ $history->amount }}</td>
                        <td class="text-left py-3 px-4">{{ $history->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
