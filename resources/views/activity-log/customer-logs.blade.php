@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h3 class="text-dark mb-4">Logs for {{ $customer->name }}</h3>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Field</th>
                    <th>Old Value</th>
                    <th>New Value</th>
                    <th>Changed At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                <tr>
                    <td>{{ $log->field }}</td>
                    <td>{{ $log->old_value }}</td>
                    <td>{{ $log->new_value }}</td>
                    <td>{{ $log->created_at->format('F d, Y h:i A') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection