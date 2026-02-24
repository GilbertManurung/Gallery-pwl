@extends('layouts.app')

@section('title', 'Upload File')
@section('header', 'Upload File')

@section('content')

{{-- Error --}}
@if($errors->any())
    <div style="background:#f8d7da;border:1px solid #f5c6cb;color:#721c24;
                padding:0.75rem 1rem;border-radius:6px;margin-bottom:1rem;">
        <ul style="margin:0;padding-left:1.5rem;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('error'))
    <div style="background:#f8d7da;border:1px solid #f5c6cb;color:#721c24;
                padding:0.75rem 1rem;border-radius:6px;margin-bottom:1rem;">
        {{ session('error') }}
    </div>
@endif

<h2 style="font-size:1.5rem;font-weight:600;margin-bottom:1rem;">
    Upload File
</h2>

<div style="background:#fff;padding:2rem;border-radius:8px;box-shadow:0 2px 6px rgba(0,0,0,0.1);max-width:600px;">
    {{-- ❗ FORM WAJIB PERSIS SEPERTI INI --}}
    <form action="{{ route('dashboard.store') }}"
          method="POST"
          enctype="multipart/form-data"
          style="display:flex;flex-direction:column;gap:1.5rem;">

        @csrf

        <div>
            <label for="title" style="display:block;font-weight:600;margin-bottom:0.5rem;">
                Judul Gambar <span style="color:#dc3545;">*</span>
            </label>
            <input type="text" 
                   name="title" 
                   id="title"
                   value="{{ old('title') }}"
                   required
                   placeholder="Masukkan judul gambar"
                   style="width:100%;padding:0.75rem;border:1px solid #ddd;border-radius:6px;font-size:1rem;">
        </div>
        
        <div>
            <label for="topic" style="display:block;font-weight:600;margin-bottom:0.5rem;">
                Kategori <span style="color:#dc3545;">*</span>
            </label>
            <select name="topic" 
                    id="topic"
                    required
                    style="width:100%;padding:0.75rem;border:1px solid #ddd;border-radius:6px;font-size:1rem;">
                <option value="">-- Pilih Kategori --</option>
                <option value="aesthetic" {{ old('topic') == 'aesthetic' ? 'selected' : '' }}>Aesthetic</option>
                <option value="sport" {{ old('topic') == 'sport' ? 'selected' : '' }}>Sport</option>
            </select>
        </div>

        <div>
            <label for="file" style="display:block;font-weight:600;margin-bottom:0.5rem;">
                File Gambar <span style="color:#dc3545;">*</span>
            </label>
            <input type="file"
                   name="file"
                   id="file"
                   accept="image/jpeg,image/png,image/jpg"
                   required
                   style="width:100%;padding:0.75rem;border:1px solid #ddd;border-radius:6px;font-size:1rem;">
            <small style="display:block;margin-top:0.5rem;color:#666;">
                Format: JPG, JPEG, PNG. Maksimal: 5MB
            </small>
        </div>

        <div style="display:flex;gap:1rem;margin-top:1rem;">
            <button type="submit"
                    style="flex:1;padding:0.75rem 1.5rem;background:#007bff;color:#fff;
                           border:none;border-radius:6px;font-size:1rem;font-weight:600;
                           cursor:pointer;">
                Upload
            </button>
            
            <a href="{{ route('dashboard') }}"
               style="flex:1;padding:0.75rem 1.5rem;background:#6c757d;color:#fff;
                      border-radius:6px;font-size:1rem;font-weight:600;text-align:center;
                      text-decoration:none;display:flex;align-items:center;justify-content:center;">
                Batal
            </a>
        </div>
    </form>
</div>

{{-- Info --}}
<div style="background:#e7f3ff;border:1px solid #bee5eb;padding:1rem;border-radius:6px;margin-top:2rem;max-width:600px;">
    <h3 style="font-size:1rem;font-weight:600;margin-bottom:0.5rem;color:#004085;">
        ℹ️ Informasi Upload
    </h3>
    <ul style="margin:0;padding-left:1.5rem;color:#004085;">
        <li>Gambar yang diupload akan muncul di <strong>Dashboard (Public Gallery)</strong></li>
        <li>Semua user dapat melihat gambar yang Anda upload</li>
        <li>Nama Anda akan tercantum sebagai uploader (watermark)</li>
        <li>Anda dapat melihat semua konten Anda di menu <strong>Collection → My Content</strong></li>
    </ul>
</div>

@endsection