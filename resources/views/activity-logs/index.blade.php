@extends('layouts.app', ['title' => 'Activity Logs'])

@section('content')
<div style="margin-top: 30px;">
    <h1 style="font-size: 28px; font-weight: bold; color: #1f2937; margin-bottom: 30px;">Activity Logs</h1>

    @if ($logs->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Resource</th>
                    <th>Description</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ $log->user?->name ?? 'Unknown' }}</td>
                        <td>
                            <span style="padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500; background-color: #e0e7ff; color: #4338ca;">
                                {{ strtoupper($log->action) }}
                            </span>
                        </td>
                        <td>{{ $log->resource_type ?? 'N/A' }}</td>
                        <td>{{ Str::limit($log->description, 50) }}</td>
                        <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination if available -->
        @if (method_exists($logs, 'links'))
            <div style="margin-top: 20px;">
                {{ $logs->links() }}
            </div>
        @endif
    @else
        <div style="background-color: #f3f4f6; padding: 40px; border-radius: 8px; text-align: center;">
            <p style="color: #6b7280;">No activity logs found</p>
        </div>
    @endif
</div>
@endsection
