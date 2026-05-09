@extends('layouts.app', ['title' => 'User Preferences'])

@section('content')
<div style="margin-top: 30px; max-width: 600px;">
    <h1 style="font-size: 28px; font-weight: bold; margin-bottom: 30px; color: #1f2937;">User Preferences</h1>

    <form method="POST" action="{{ route('user-preferences.update') }}" style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="theme">Theme Preference</label>
            <select id="theme" name="theme">
                <option value="light" {{ old('theme', $preference->theme ?? 'light') == 'light' ? 'selected' : '' }}>Light</option>
                <option value="dark" {{ old('theme', $preference->theme ?? 'light') == 'dark' ? 'selected' : '' }}>Dark</option>
                <option value="auto" {{ old('theme', $preference->theme ?? 'light') == 'auto' ? 'selected' : '' }}>Auto (System)</option>
            </select>
        </div>

        <div class="form-group">
            <label for="language">Language</label>
            <select id="language" name="language">
                <option value="en" {{ old('language', $preference->language ?? 'en') == 'en' ? 'selected' : '' }}>English</option>
                <option value="id" {{ old('language', $preference->language ?? 'en') == 'id' ? 'selected' : '' }}>Indonesian (Bahasa Indonesia)</option>
            </select>
        </div>

        <div class="form-group">
            <label for="notifications_enabled">
                <input type="checkbox" id="notifications_enabled" name="notifications_enabled" value="1" {{ old('notifications_enabled', $preference->notifications_enabled ?? true) ? 'checked' : '' }}>
                Enable Notifications
            </label>
        </div>

        <div class="form-group">
            <label for="email_digest">Email Digest Frequency</label>
            <select id="email_digest" name="email_digest">
                <option value="never" {{ old('email_digest', $preference->email_digest ?? 'weekly') == 'never' ? 'selected' : '' }}>Never</option>
                <option value="daily" {{ old('email_digest', $preference->email_digest ?? 'weekly') == 'daily' ? 'selected' : '' }}>Daily</option>
                <option value="weekly" {{ old('email_digest', $preference->email_digest ?? 'weekly') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                <option value="monthly" {{ old('email_digest', $preference->email_digest ?? 'weekly') == 'monthly' ? 'selected' : '' }}>Monthly</option>
            </select>
        </div>

        <div class="form-group">
            <label for="timezone">Timezone</label>
            <select id="timezone" name="timezone">
                <option value="UTC" {{ old('timezone', $preference->timezone ?? 'UTC') == 'UTC' ? 'selected' : '' }}>UTC</option>
                <option value="Asia/Jakarta" {{ old('timezone', $preference->timezone ?? 'UTC') == 'Asia/Jakarta' ? 'selected' : '' }}>Asia/Jakarta (WIB)</option>
                <option value="Asia/Makassar" {{ old('timezone', $preference->timezone ?? 'UTC') == 'Asia/Makassar' ? 'selected' : '' }}>Asia/Makassar (WITA)</option>
                <option value="Asia/Jayapura" {{ old('timezone', $preference->timezone ?? 'UTC') == 'Asia/Jayapura' ? 'selected' : '' }}>Asia/Jayapura (WIT)</option>
            </select>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <button type="submit" class="btn btn-primary">Save Preferences</button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary" style="background-color: #6b7280;">Cancel</a>
        </div>
    </form>
</div>
@endsection
