@extends('layouts.app', ['title' => 'Notifications'])

@section('content')
<div style="margin-top: 30px;">
    <h1 style="font-size: 28px; font-weight: bold; color: #1f2937; margin-bottom: 30px;">Notifications</h1>

    @if ($notifications->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Message</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notifications as $notification)
                    <tr>
                        <td>{{ $notification->id }}</td>
                        <td>{{ Str::limit($notification->message, 50) }}</td>
                        <td>
                            <span style="padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500; background-color: #fef3c7; color: #92400e;">
                                {{ strtoupper($notification->type) }}
                            </span>
                        </td>
                        <td>
                            <span style="padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500; background-color: {{ $notification->is_sent ? '#d1fae5' : '#fee2e2' }}; color: {{ $notification->is_sent ? '#065f46' : '#991b1b' }};">
                                {{ $notification->is_sent ? 'Sent' : 'Pending' }}
                            </span>
                        </td>
                        <td>{{ $notification->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            @if (!$notification->is_sent)
                                <form method="POST" action="{{ route('notifications.mark-sent', $notification) }}" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn" style="background-color: #10b981; color: white; padding: 6px 12px; font-size: 12px;">Mark Sent</button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('notifications.destroy', $notification) }}" style="display: inline;" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 12px;">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div style="background-color: #f3f4f6; padding: 40px; border-radius: 8px; text-align: center;">
            <p style="color: #6b7280;">No notifications found</p>
        </div>
    @endif
</div>
@endsection
