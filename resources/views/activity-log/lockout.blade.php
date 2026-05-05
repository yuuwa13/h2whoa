@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h3 class="text-dark mb-4">Login Lockout Logs</h3>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>IP Address</th>
                    <th>Locked At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                <tr>
                    <td>{{ $log->ip_address }}</td>
                    <td>{{ $log->created_at->format('F d, Y h:i A') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $logs->links() }}
</div>
@endsection