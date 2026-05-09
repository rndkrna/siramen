@extends('layouts.app')

@section('content')
<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
    <div style="display: flex; align-items: center; gap: 12px;">
        <a href="{{ route('dashboard') }}" style="color: white; background: var(--card-bg); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; border: 1px solid var(--border-color);">
            <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
        </a>
        <h1 style="margin-bottom: 0;">Planner Tugas Kelompok</h1>
    </div>
    <a href="{{ route('teams.create') }}" style="background: var(--primary-purple); color: white; padding: 10px 20px; border-radius: 20px; text-decoration: none; font-size: 13px; font-weight: 600; box-shadow: var(--shadow-purple);">
        + KELOMPOK BARU
    </a>
</div>

@forelse($teams as $team)
<div style="background: var(--card-bg); border-radius: 20px; padding: 20px; border: 1px solid var(--border-color); margin-bottom: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
            <p style="font-size: 10px; color: var(--primary-green); font-weight: 700; text-transform: uppercase;">Mata Kuliah: Proyek Kelompok • {{ strtoupper($team->status) }}</p>
            <h3 style="font-size: 18px; margin-top: 4px;">{{ $team->name }}</h3>
            <p style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">{{ $team->description }}</p>
        </div>
        <div style="text-align: right;">
            <p style="font-size: 10px; color: var(--text-muted);">Dibuat pada</p>
            <p style="font-size: 14px; font-weight: 700; color: white;">{{ $team->created_at->format('d M Y') }}</p>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 300px; gap: 16px;">
    <!-- Column 1 -->
    <div>
        <!-- Anggota Tim -->
        <div style="background: var(--card-bg); border-radius: 20px; padding: 20px; border: 1px solid var(--border-color); margin-bottom: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i data-lucide="users" style="color: var(--primary-green); width: 18px;"></i>
                    <h4 style="font-size: 15px; font-weight: 600;">Anggota Tim & Progress</h4>
                </div>
                <button onclick="document.getElementById('form-member-{{ $team->id }}').style.display = 'block'" style="background: transparent; border: 1px solid var(--border-color); color: var(--text-muted); padding: 4px 8px; border-radius: 8px; cursor: pointer; font-size: 10px;">+ TAMBAH</button>
            </div>
            
            <div id="form-member-{{ $team->id }}" style="display: none; margin-bottom: 20px; padding: 12px; background: rgba(255,255,255,0.03); border-radius: 12px; border: 1px dashed var(--border-color);">
                <form action="{{ route('teams.members.store', $team) }}" method="POST">
                    @csrf
                    <input type="text" name="name" placeholder="Nama Anggota" style="width: 100%; background: #222; border: 1px solid var(--border-color); color: white; padding: 8px; border-radius: 8px; font-size: 12px; margin-bottom: 8px;" required>
                    <input type="email" name="email" placeholder="Email Akun Teman (Opsional)" style="width: 100%; background: #222; border: 1px solid var(--border-color); color: white; padding: 8px; border-radius: 8px; font-size: 12px; margin-bottom: 8px;">
                    <input type="text" name="role" placeholder="Role (e.g. Designer)" style="width: 100%; background: #222; border: 1px solid var(--border-color); color: white; padding: 8px; border-radius: 8px; font-size: 12px; margin-bottom: 12px;">
                    <div style="display: flex; gap: 8px;">
                        <button type="submit" style="flex: 1; background: var(--primary-green); color: white; border: none; padding: 8px; border-radius: 8px; font-size: 11px; font-weight: 700; cursor: pointer;">SIMPAN</button>
                        <button type="button" onclick="document.getElementById('form-member-{{ $team->id }}').style.display = 'none'" style="flex: 1; background: #333; color: white; border: none; padding: 8px; border-radius: 8px; font-size: 11px; cursor: pointer;">BATAL</button>
                    </div>
                </form>
            </div>

            <div style="display: flex; flex-direction: column; gap: 16px;">
                @foreach($team->members as $member)
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 32px; height: 32px; background: #333; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700;">
                        {{ substr($member->name, 0, 1) }}
                    </div>
                    <div style="flex: 1;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                            <div>
                                <span style="font-size: 12px; font-weight: 600;">{{ $member->name }}</span>
                                <span style="font-size: 10px; color: var(--text-muted); margin-left: 4px;">• {{ $member->role }}</span>
                            </div>
                            <span style="font-size: 11px; color: var(--primary-green);">{{ $member->progress }}%</span>
                        </div>
                        <div class="progress-bar" style="height: 4px; margin: 0;"><div class="progress-fill" style="width: {{ $member->progress }}%;"></div></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Distribusi Tugas -->
        <div style="background: var(--card-bg); border-radius: 20px; padding: 20px; border: 1px solid var(--border-color);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i data-lucide="clipboard-list" style="color: var(--primary-purple); width: 18px;"></i>
                    <h4 style="font-size: 15px; font-weight: 600;">Distribusi Tugas</h4>
                </div>
                <button onclick="document.getElementById('form-task-{{ $team->id }}').style.display = 'block'" style="background: transparent; border: 1px solid var(--border-color); color: var(--text-muted); padding: 4px 8px; border-radius: 8px; cursor: pointer; font-size: 10px;">+ TUGAS</button>
            </div>

            <div id="form-task-{{ $team->id }}" style="display: none; margin-bottom: 20px; padding: 12px; background: rgba(255,255,255,0.03); border-radius: 12px; border: 1px dashed var(--border-color);">
                <form action="{{ route('teams.tasks.store', $team) }}" method="POST">
                    @csrf
                    <input type="text" name="task_name" placeholder="Nama Tugas" style="width: 100%; background: #222; border: 1px solid var(--border-color); color: white; padding: 8px; border-radius: 8px; font-size: 12px; margin-bottom: 8px;" required>
                    <select name="priority" style="width: 100%; background: #222; border: 1px solid var(--border-color); color: white; padding: 8px; border-radius: 8px; font-size: 12px; margin-bottom: 12px;">
                        <option value="low">Low Priority</option>
                        <option value="medium" selected>Medium Priority</option>
                        <option value="high">High Priority</option>
                    </select>
                    <div style="display: flex; gap: 8px;">
                        <button type="submit" style="flex: 1; background: var(--primary-purple); color: white; border: none; padding: 8px; border-radius: 8px; font-size: 11px; font-weight: 700; cursor: pointer;">TAMBAHKAN</button>
                        <button type="button" onclick="document.getElementById('form-task-{{ $team->id }}').style.display = 'none'" style="flex: 1; background: #333; color: white; border: none; padding: 8px; border-radius: 8px; font-size: 11px; cursor: pointer;">BATAL</button>
                    </div>
                </form>
            </div>
            
            <table class="team-table">
                <thead>
                    <tr>
                        <th>Tugas</th>
                        <th>PIC</th>
                        <th>Status</th>
                        <th>Prioritas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($team->tasks as $task)
                    <tr>
                        <td>{{ $task->task_name }}</td>
                        <td>{{ $task->member->name ?? '-' }}</td>
                        <td><span class="status-badge status-{{ $task->status }}">{{ strtoupper($task->status) }}</span></td>
                        <td style="color: {{ $task->priority == 'high' ? 'var(--accent-red)' : 'var(--text-muted)' }}; text-transform: uppercase; font-size: 10px;">{{ $task->priority }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Column 2 -->
    <div>
        <!-- Diskusi Tim (Static placeholder for now, but clean) -->
        <div style="background: var(--card-bg); border-radius: 20px; padding: 20px; border: 1px solid var(--border-color); height: 400px; display: flex; flex-direction: column;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i data-lucide="message-square" style="color: var(--primary-purple); width: 18px;"></i>
                    <h4 style="font-size: 14px; font-weight: 600;">Diskusi Tim</h4>
                </div>
            </div>
            
            <div style="flex: 1; overflow-y: auto; display: flex; flex-direction: column; gap: 12px; justify-content: center; text-align: center;">
                <p style="font-size: 12px; color: var(--text-muted);">Belum ada pesan di grup ini.</p>
            </div>
            
            <div style="margin-top: 16px; background: #2A2A2A; border-radius: 12px; padding: 8px 12px; display: flex; align-items: center; gap: 8px;">
                <input type="text" placeholder="Ketik pesan..." style="background: transparent; border: none; color: white; font-size: 12px; flex: 1; outline: none;">
                <i data-lucide="send" style="width: 16px; color: var(--primary-purple); cursor: pointer;"></i>
            </div>
        </div>
    </div>
</div>
@empty
<div style="background: var(--card-bg); border-radius: 20px; padding: 60px; text-align: center; border: 1px solid var(--border-color);">
    <i data-lucide="users" style="width: 48px; height: 48px; color: var(--text-muted); margin-bottom: 16px;"></i>
    <h3 style="color: var(--text-muted);">Belum ada Kelompok</h3>
    <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 24px;">Kolaborasi dengan teman sekelas untuk mengerjakan proyek bersama.</p>
    <a href="{{ route('teams.create') }}" style="background: var(--primary-purple); color: white; padding: 12px 32px; border-radius: 20px; font-weight: 700; text-decoration: none; display: inline-block;">BUAT KELOMPOK BARU</a>
</div>
@endforelse
@endsection
