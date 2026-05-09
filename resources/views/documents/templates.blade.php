@extends('layouts.app')

@section('content')
<div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
    <a href="{{ route('dashboard') }}" style="color: white; background: var(--card-bg); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; border: 1px solid var(--border-color);">
        <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
    </a>
    <h1 style="margin-bottom: 0;">Template Dokumen Cepat</h1>
</div>

<!-- Pilih Template -->
<div style="margin-bottom: 32px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <h4 style="font-size: 16px; font-weight: 600;">Pilih Template</h4>
        <span style="font-size: 11px; color: var(--primary-green);">3 Template Tersedia</span>
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px;">
        <div class="menu-card" style="border-color: var(--primary-green); padding: 16px; gap: 8px; position: relative;">
            <i data-lucide="mail" style="color: var(--primary-green); width: 18px;"></i>
            <h3 style="font-size: 14px;">Surat Izin</h3>
            <p style="font-size: 10px;">Izin sakit, kegiatan organisasi, atau keperluan mendesak lainnya.</p>
            <span class="badge badge-green" style="font-size: 8px;">Akademik</span>
            <i data-lucide="check-circle-2" style="position: absolute; top: 12px; right: 12px; width: 14px; color: var(--primary-green);"></i>
        </div>
        <div class="menu-card" style="padding: 16px; gap: 8px;">
            <i data-lucide="lightbulb" style="color: var(--primary-purple); width: 18px;"></i>
            <h3 style="font-size: 14px;">Proposal PKM</h3>
            <p style="font-size: 10px;">Struktur standar PKM-K, PKM-R, dan PKM lainnya sesuai panduan.</p>
            <span class="badge badge-purple" style="font-size: 8px;">Riset</span>
        </div>
        <div class="menu-card" style="padding: 16px; gap: 8px;">
            <i data-lucide="file-text" style="color: var(--primary-green); width: 18px;"></i>
            <h3 style="font-size: 14px;">Abstrak Skripsi</h3>
            <p style="font-size: 10px;">Template abstrak bilingual (Indo-Inggris) dengan format resmi.</p>
            <span class="badge badge-green" style="font-size: 8px;">Final Project</span>
        </div>
    </div>
</div>

<div style="background: var(--card-bg); border-radius: 20px; padding: 24px; border: 1px solid var(--border-color);">
    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 24px;">
        <i data-lucide="edit-3" style="color: var(--primary-purple); width: 18px;"></i>
        <h4 style="font-size: 16px; font-weight: 600;">Parameter Dokumen</h4>
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
        <div>
            <label style="font-size: 11px; color: var(--text-muted); display: block; margin-bottom: 8px;">Nama Lengkap Mahasiswa</label>
            <input type="text" class="form-input" placeholder="Contoh: Budi Santoso">
        </div>
        <div>
            <label style="font-size: 11px; color: var(--text-muted); display: block; margin-bottom: 8px;">NIM</label>
            <input type="text" class="form-input" placeholder="Contoh: 2109012345">
        </div>
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
        <div>
            <label style="font-size: 11px; color: var(--text-muted); display: block; margin-bottom: 8px;">Tujuan (Dosen/Instansi)</label>
            <input type="text" class="form-input" placeholder="Contoh: Kaprodi Informatika">
        </div>
        <div>
            <label style="font-size: 11px; color: var(--text-muted); display: block; margin-bottom: 8px;">Alasan/Keterangan Singkat</label>
            <input type="text" class="form-input" placeholder="Contoh: Menghadiri Lomba Nasional">
        </div>
    </div>
    
    <div style="margin-bottom: 24px;">
        <label style="font-size: 11px; color: var(--text-muted); display: block; margin-bottom: 8px;">Lampiran Pendukung (Opsional)</label>
        <div class="upload-box" style="padding: 20px; border-style: dashed; margin-bottom: 0;">
            <i data-lucide="upload-cloud" style="width: 24px; margin-bottom: 8px; color: var(--text-muted);"></i>
            <p style="font-size: 11px; color: var(--text-muted);">Klik atau seret file PDF/Gambar ke sini (Maks 5MB)</p>
        </div>
    </div>
    
    <div class="doc-preview" style="margin-bottom: 24px;">
        <div style="width: 40px; height: 4px; background: #444; border-radius: 2px; align-self: center; margin-bottom: 12px;"></div>
        <div class="doc-line" style="width: 60%;"></div>
        <div class="doc-line" style="width: 40%;"></div>
        <div style="margin-top: 12px;">
            <div class="doc-line" style="width: 100%; margin-bottom: 8px;"></div>
            <div class="doc-line" style="width: 100%; margin-bottom: 8px;"></div>
            <div class="doc-line" style="width: 80%; margin-bottom: 8px;"></div>
        </div>
        <div style="margin-top: auto; align-self: flex-end; width: 60px;">
            <div class="doc-line" style="width: 100%; margin-bottom: 4px;"></div>
            <div class="doc-line" style="width: 80%;"></div>
        </div>
        <button style="position: absolute; bottom: 12px; left: 50%; transform: translateX(-50%); background: rgba(0,0,0,0.5); border: none; color: white; padding: 4px 12px; border-radius: 20px; font-size: 9px; display: flex; align-items: center; gap: 4px;">
            <i data-lucide="maximize" style="width: 10px;"></i> Preview Fullscreen
        </button>
    </div>
    
    <div style="margin-bottom: 24px;">
        <p style="font-size: 13px; font-weight: 600; margin-bottom: 12px;">Format Unduhan</p>
        <div class="radio-group">
            <div class="radio-item selected">
                <div class="radio-circle"></div>
                <i data-lucide="file-text" style="width: 16px; color: var(--primary-green);"></i>
                <div style="flex: 1;">
                    <p style="font-size: 12px; font-weight: 600;">PDF Document (.pdf)</p>
                </div>
            </div>
            <div class="radio-item">
                <div class="radio-circle"></div>
                <i data-lucide="file-type-2" style="width: 16px; color: var(--text-muted);"></i>
                <div style="flex: 1;">
                    <p style="font-size: 12px; font-weight: 600;">Word Document (.docx)</p>
                </div>
            </div>
        </div>
    </div>
    
    <button style="width: 100%; background: var(--primary-green); color: black; border: none; padding: 16px; border-radius: 12px; font-weight: 700; font-size: 14px; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: var(--shadow-green);">
        <i data-lucide="download" style="width: 18px;"></i> BUAT DOKUMEN SEKARANG
    </button>
    <p style="text-align: center; font-size: 10px; color: var(--text-muted); margin-top: 12px;">*Dokumen akan diproses otomatis menggunakan AI untuk memastikan tata bahasa yang baku dan sopan.</p>
</div>
@endsection
