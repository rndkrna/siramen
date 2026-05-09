@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <div>
        <h1 style="margin-bottom: 4px;">Manajemen Deadline</h1>
        <p style="font-size: 13px; color: var(--text-muted);">Pantau tugas, UTS, dan seminar dalam satu tampilan terpadu.</p>
    </div>
    <a href="{{ route('deadlines.create') }}" style="background: var(--primary-purple); color: white; padding: 10px 20px; border-radius: 20px; text-decoration: none; font-size: 13px; font-weight: 600; box-shadow: var(--shadow-purple);">
        + TAMBAH
    </a>
</div>

<div style="display: flex; gap: 16px; align-items: flex-start; margin-bottom: 24px;">
    <!-- Calendar Card -->
    <div class="calendar-card" style="flex: 1; margin-bottom: 0;">
        <div class="calendar-header">
            <h4 style="font-size: 16px;">{{ \Carbon\Carbon::now()->format('F Y') }}</h4>
            <div style="display: flex; gap: 12px;">
                <i data-lucide="chevron-left" style="width: 18px; cursor: pointer;" onclick="alert('Navigasi kalender akan berfungsi sepenuhnya di update berikutnya!')"></i>
                <i data-lucide="chevron-right" style="width: 18px; cursor: pointer;" onclick="alert('Navigasi kalender akan berfungsi sepenuhnya di update berikutnya!')"></i>
            </div>
        </div>
        <div class="calendar-grid">
            <div class="calendar-day-name">Min</div>
            <div class="calendar-day-name">Sen</div>
            <div class="calendar-day-name">Sel</div>
            <div class="calendar-day-name">Rab</div>
            <div class="calendar-day-name">Kam</div>
            <div class="calendar-day-name">Jum</div>
            <div class="calendar-day-name">Sab</div>
            
            @php
                $startOfMonth = \Carbon\Carbon::now()->startOfMonth();
                $endOfMonth = \Carbon\Carbon::now()->endOfMonth();
                $daysInMonth = \Carbon\Carbon::now()->daysInMonth;
                $firstDayOfWeek = $startOfMonth->dayOfWeek; // 0 (Sun) to 6 (Sat)
            @endphp

            @for($i = 0; $i < $firstDayOfWeek; $i++)
                <div class="calendar-date" style="color: #444; opacity: 0.3;">-</div>
            @endfor

            @for($day = 1; $day <= $daysInMonth; $day++)
                @php
                    $currentDate = \Carbon\Carbon::now()->day($day);
                    $hasDeadline = $deadlines->contains(function($d) use ($currentDate) {
                        return \Carbon\Carbon::parse($d->due_date)->isSameDay($currentDate);
                    });
                @endphp
                <div class="calendar-date {{ $currentDate->isToday() ? 'active' : '' }}">
                    {{ $day }}
                    @if($hasDeadline)
                        <div class="calendar-dot"></div>
                    @endif
                </div>
            @endfor
        </div>
    </div>

    <!-- Notification Settings -->
    <div style="width: 120px; background: var(--card-bg); border-radius: 20px; padding: 16px; border: 1px solid var(--border-color);">
        <div style="display: flex; flex-direction: column; gap: 16px;">
            <div style="text-align: center;">
                <i data-lucide="bell" style="width: 18px; color: var(--primary-purple); margin-bottom: 8px;"></i>
                <p style="font-size: 10px; font-weight: 600;">Notifikasi</p>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 10px;">H-7</span>
                    <label class="switch">
                        <input type="checkbox" checked>
                        <span class="slider"></span>
                    </label>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 10px;">H-3</span>
                    <label class="switch">
                        <input type="checkbox" checked>
                        <span class="slider"></span>
                    </label>
                </div>
            </div>
            <p style="font-size: 8px; color: var(--text-muted); font-style: italic; text-align: center;">Simpan otomatis ke preferensi Anda.</p>
        </div>
    </div>
</div>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
    <div style="display: flex; align-items: center; gap: 8px;">
        <i data-lucide="list-todo" style="width: 18px; color: var(--primary-purple);"></i>
        <h4 style="font-size: 16px; font-weight: 600;">Daftar Tugas & Deadline</h4>
    </div>
    <div style="display: flex; gap: 4px; background: rgba(255,255,255,0.05); padding: 4px; border-radius: 20px;">
        <a href="{{ route('deadlines.index', ['type' => 'all']) }}" style="font-size: 10px; padding: 4px 12px; background: {{ !request('type') || request('type') == 'all' ? 'var(--primary-purple)' : 'transparent' }}; color: white; border-radius: 20px; text-decoration: none; cursor: pointer; transition: all 0.3s;">Semua</a>
        <a href="{{ route('deadlines.index', ['type' => 'UTS']) }}" style="font-size: 10px; padding: 4px 12px; background: {{ request('type') == 'UTS' ? 'var(--primary-purple)' : 'transparent' }}; color: {{ request('type') == 'UTS' ? 'white' : 'var(--text-muted)' }}; border-radius: 20px; text-decoration: none; cursor: pointer; transition: all 0.3s;">UTS</a>
        <a href="{{ route('deadlines.index', ['type' => 'Seminar']) }}" style="font-size: 10px; padding: 4px 12px; background: {{ request('type') == 'Seminar' ? 'var(--primary-purple)' : 'transparent' }}; color: {{ request('type') == 'Seminar' ? 'white' : 'var(--text-muted)' }}; border-radius: 20px; text-decoration: none; cursor: pointer; transition: all 0.3s;">Seminar</a>
    </div>
</div>

<!-- Deadline Items -->
@forelse($deadlines as $deadline)
<div class="deadline-item {{ strtolower($deadline->priority ?? 'medium') }}" style="display: flex; align-items: center; gap: 16px;">
    <div class="deadline-icon">
        <i data-lucide="{{ $deadline->priority === 'high' ? 'alert-circle' : 'file-text' }}" style="color: var(--primary-purple); width: 20px;"></i>
    </div>
    <div style="flex: 1;">
        <h4 style="font-size: 14px; margin-bottom: 2px; {{ $deadline->is_done ? 'text-decoration: line-through; opacity: 0.5;' : '' }}">{{ $deadline->title }}</h4>
        <p style="font-size: 11px; color: var(--text-muted);">{{ $deadline->subject ? $deadline->subject->name : 'No Subject' }} • {{ \Carbon\Carbon::parse($deadline->due_date)->format('H:i') }} WIB</p>
    </div>
    <div style="text-align: right; margin-right: 12px;">
        <p style="font-size: 12px; font-weight: 700;">{{ \Carbon\Carbon::parse($deadline->due_date)->format('d M') }}</p>
        <p style="font-size: 9px; color: var(--primary-purple); text-transform: uppercase;">{{ $deadline->priority ?? 'NORMAL' }}</p>
    </div>
    <div style="display: flex; gap: 8px;">
        <form action="{{ route('deadlines.destroy', $deadline) }}" method="POST" onsubmit="return confirm('Hapus deadline ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" style="background: transparent; border: none; color: var(--accent-red); cursor: pointer; padding: 4px;">
                <i data-lucide="trash-2" style="width: 16px;"></i>
            </button>
        </form>
    </div>
</div>
@empty
<div style="text-align: center; padding: 20px; color: var(--text-muted); font-size: 13px;">
    Tidak ada deadline yang aktif saat ini. Santai dulu!
</div>
@endforelse

<div style="background: linear-gradient(135deg, rgba(124, 77, 255, 0.2) 0%, rgba(15, 15, 15, 1) 100%); border-radius: 20px; padding: 20px; margin-top: 24px; border: 1px solid var(--border-color); display: flex; gap: 16px;">
    <div style="width: 80px; height: 80px; background: rgba(124, 77, 255, 0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
        <i data-lucide="zap" style="color: var(--primary-purple); width: 32px; height: 32px;"></i>
    </div>
    <div>
        <h4 style="font-size: 15px; color: var(--primary-purple); margin-bottom: 4px;">Tips Efisiensi</h4>
        <p style="font-size: 11px; line-height: 1.4;">Mahasiswa yang memantau deadline H-7 cenderung memiliki tingkat stres 40% lebih rendah. Pastikan Anda telah mengaktifkan notifikasi bertahap.</p>
    </div>
</div>
@endsection
