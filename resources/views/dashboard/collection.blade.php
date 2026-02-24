@extends('layouts.app')

@section('title', 'Collection')
@section('header', 'Collection')

@section('content')

{{-- ================= NOTIFIKASI ================= --}}
@if(session('success'))
    <div style="background:#d4edda;border:1px solid #c3e6cb;color:#155724;
                padding:0.75rem 1rem;border-radius:6px;margin-bottom:1.5rem;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background:#f8d7da;border:1px solid #f5c6cb;color:#721c24;
                padding:0.75rem 1rem;border-radius:6px;margin-bottom:1.5rem;">
        {{ session('error') }}
    </div>
@endif

{{-- ================= MY FAVORIT ================= --}}
<h2 style="font-size:1.5rem;font-weight:600;margin-bottom:1rem;">
    My Favorit
</h2>

@if($myFavorites->isEmpty())
    <div style="background:#f8f9fa;padding:2rem;border-radius:8px;text-align:center;margin-bottom:3rem;">
        <svg width="64" height="64" viewBox="0 0 24 24" style="opacity:0.3;margin-bottom:1rem;">
            <path fill="#999" d="M12 20.325q-.35 0-.713-.125t-.637-.4l-1.725-1.575q-2.65-2.425-4.788-4.813T2 8.15Q2 5.8 3.575 4.225T7.5 2.65q1.325 0 2.5.562t2 1.538q.825-.975 2-1.538t2.5-.562q2.35 0 3.925 1.575T22 8.15q0 2.875-2.125 5.275T15.05 18.25l-1.7 1.55q-.275.275-.637.4t-.713.125Z"/>
        </svg>
        <p style="color:#888;font-size:1rem;margin-bottom:1rem;">
            Anda belum memiliki gambar favorit.
        </p>
        <a href="{{ route('dashboard') }}" 
           style="display:inline-block;background:#ff4757;color:#fff;padding:0.5rem 1.5rem;
                  border-radius:6px;text-decoration:none;">
            <svg width="16" height="16" viewBox="0 0 24 24" style="vertical-align:middle;margin-right:6px;">
                <path fill="#fff" d="M12 20.325q-.35 0-.713-.125t-.637-.4l-1.725-1.575q-2.65-2.425-4.788-4.813T2 8.15Q2 5.8 3.575 4.225T7.5 2.65q1.325 0 2.5.562t2 1.538q.825-.975 2-1.538t2.5-.562q2.35 0 3.925 1.575T22 8.15q0 2.875-2.125 5.275T15.05 18.25l-1.7 1.55q-.275.275-.637.4t-.713.125Z"/>
            </svg>
            Lihat Galeri
        </a>
    </div>
@else
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:1.5rem;margin-bottom:3rem;">
    @foreach($myFavorites as $favorite)
        <div style="background:#fff;padding:1rem;border-radius:8px;box-shadow:0 2px 6px rgba(0,0,0,0.1);
                    border:2px solid #ff4757;">

            <div style="position:relative;margin-bottom:0.5rem;">
                <img
                    src="{{ $favorite->image_url }}"
                    alt="{{ $favorite->title }}"
                    style="width:100%;height:160px;object-fit:cover;border-radius:6px;background:#f0f0f0;cursor:pointer;"
                    onclick="window.location.href='{{ route('dashboard') }}'"
                    onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%22100%22%3E%3Crect width=%22100%22 height=%22100%22 fill=%22%23ddd%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dy=%22.3em%22 fill=%22%23999%22 font-size=%2214%22%3ENo Image%3C/text%3E%3C/svg%3E';"
                >

                {{-- Badge "Favorite" --}}
                <div style="position:absolute;top:6px;left:6px;
                            background:#ff4757;color:#fff;
                            font-size:0.65rem;padding:3px 8px;border-radius:4px;font-weight:600;
                            display:flex;align-items:center;gap:4px;">
                    <svg width="10" height="10" viewBox="0 0 24 24">
                        <path fill="#fff" d="M12 20.325q-.35 0-.713-.125t-.637-.4l-1.725-1.575q-2.65-2.425-4.788-4.813T2 8.15Q2 5.8 3.575 4.225T7.5 2.65q1.325 0 2.5.562t2 1.538q.825-.975 2-1.538t2.5-.562q2.35 0 3.925 1.575T22 8.15q0 2.875-2.125 5.275T15.05 18.25l-1.7 1.55q-.275.275-.637.4t-.713.125Z"/>
                    </svg>
                    FAVORIT
                </div>

                {{-- Watermark dengan nama uploader --}}
                <div style="position:absolute;bottom:6px;right:6px;
                            background:rgba(0,0,0,0.7);color:#fff;
                            font-size:0.65rem;padding:3px 8px;border-radius:4px;
                            display:flex;align-items:center;gap:4px;">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span>© {{ $favorite->user->name ?? 'Unknown' }}</span>
                </div>
            </div>

            <h3 style="text-align:center;font-weight:600;font-size:1rem;margin:0.5rem 0;">
                {{ $favorite->title }}
            </h3>

            <p style="text-align:center;font-size:0.8rem;color:#555;margin:0.25rem 0;">
                {{ ucfirst($favorite->topic) }}
            </p>

            <p style="text-align:center;font-size:0.75rem;color:#888;margin:0.25rem 0;">
                Oleh: {{ $favorite->user->name ?? 'Unknown' }}
            </p>

            <div style="display:flex;gap:0.5rem;margin-top:0.75rem;">
                <a href="{{ $favorite->image_url }}" target="_blank"
                   style="flex:1;text-align:center;padding:0.5rem;background:#007bff;color:#fff;
                          border-radius:4px;text-decoration:none;font-size:0.85rem;">
                    Lihat
                </a>
                <button type="button"
                        class="unfavorite-btn"
                        data-image-id="{{ $favorite->id }}"
                        style="flex:1;text-align:center;padding:0.5rem;background:#dc3545;color:#fff;
                               border:none;border-radius:4px;cursor:pointer;font-size:0.85rem;"
                        onclick="unfavoriteImage({{ $favorite->id }})">
                    Hapus dari Favorit
                </button>
            </div>
        </div>
    @endforeach
    </div>

    <div style="margin-bottom:2rem;text-align:center;">
        <p style="color:#666;font-size:0.9rem;">
            Total favorit: <strong>{{ $myFavorites->count() }}</strong> gambar
        </p>
    </div>
@endif

{{-- ================= MY CONTENT (PRIVATE - HANYA MILIK USER) ================= --}}
<h2 style="font-size:1.5rem;font-weight:600;margin-bottom:1rem;display:flex;align-items:center;gap:0.5rem;">
    My Content
    <span style="background:#28a745;color:#fff;font-size:0.7rem;padding:2px 8px;border-radius:12px;">
        Private
    </span>
</h2>

@if($myUploads->isEmpty())
    <div style="background:#f8f9fa;padding:2rem;border-radius:8px;text-align:center;">
        <p style="color:#888;font-size:1rem;margin-bottom:1rem;">
            Anda belum memiliki konten yang diupload.
        </p>
        <a href="{{ route('dashboard.create') }}" 
           style="display:inline-block;background:#007bff;color:#fff;padding:0.5rem 1.5rem;
                  border-radius:6px;text-decoration:none;">
            Upload File Baru
        </a>
    </div>
@else

<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:1.5rem;">
@foreach($myUploads as $upload)

    <div style="background:#fff;padding:1rem;border-radius:8px;box-shadow:0 2px 6px rgba(0,0,0,0.1);
                border:2px solid #28a745;" id="upload-card-{{ $upload->id }}">

        <div style="position:relative;margin-bottom:0.5rem;">
            {{-- Menggunakan accessor image_url dari model --}}
            <img
                src="{{ $upload->image_url }}"
                alt="{{ $upload->title }}"
                style="width:100%;height:160px;object-fit:cover;border-radius:6px;background:#f0f0f0;"
                onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%22100%22%3E%3Crect width=%22100%22 height=%22100%22 fill=%22%23ddd%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dy=%22.3em%22 fill=%22%23999%22 font-size=%2214%22%3ENo Image%3C/text%3E%3C/svg%3E';"
            >

            {{-- Badge "My Content" --}}
            <div style="position:absolute;top:6px;left:6px;
                        background:#28a745;color:#fff;
                        font-size:0.65rem;padding:3px 8px;border-radius:4px;font-weight:600;">
                MY CONTENT
            </div>

            {{-- Watermark dengan nama user --}}
            <div style="position:absolute;bottom:6px;right:6px;
                        background:rgba(0,0,0,0.7);color:#fff;
                        font-size:0.65rem;padding:3px 8px;border-radius:4px;
                        display:flex;align-items:center;gap:4px;">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <span>© {{ $upload->user->name ?? 'You' }}</span>
            </div>
        </div>

        <h3 style="text-align:center;font-weight:600;font-size:1rem;margin:0.5rem 0;">
            {{ $upload->title }}
        </h3>

        <p style="text-align:center;font-size:0.8rem;color:#555;margin:0.25rem 0;">
            {{ ucfirst($upload->topic) }}
        </p>

        <p style="text-align:center;font-size:0.75rem;color:#888;margin:0.25rem 0;">
            {{ $upload->created_at->format('d M Y H:i') }}
        </p>

        <div style="display:flex;gap:0.5rem;margin-top:0.75rem;">
            <a href="{{ $upload->image_url }}" target="_blank"
               style="flex:1;text-align:center;padding:0.5rem;background:#007bff;color:#fff;
                      border-radius:4px;text-decoration:none;font-size:0.85rem;">
                Lihat
            </a>
            <button type="button"
                    class="delete-btn"
                    data-upload-id="{{ $upload->id }}"
                    style="flex:1;text-align:center;padding:0.5rem;background:#dc3545;color:#fff;
                           border:none;border-radius:4px;cursor:pointer;font-size:0.85rem;"
                    onclick="deleteUpload({{ $upload->id }})">
                Hapus
            </button>
        </div>

        {{-- Debug info --}}
        @if(config('app.debug'))
        <details style="margin-top:0.5rem;font-size:0.7rem;color:#666;">
            <summary style="cursor:pointer;">Debug Info</summary>
            <div style="margin-top:0.25rem;padding:0.5rem;background:#f5f5f5;border-radius:4px;">
                <div><strong>Upload ID:</strong> {{ $upload->id }}</div>
                <div><strong>User ID:</strong> {{ $upload->user_id }}</div>
                <div><strong>Topic:</strong> {{ $upload->topic }}</div>
                <div><strong>File Path:</strong> {{ $upload->file_path }}</div>
                <div><strong>URL:</strong> {{ $upload->image_url }}</div>
            </div>
        </details>
        @endif
    </div>

@endforeach
</div>

<div style="margin-top:2rem;text-align:center;">
    <p style="color:#666;font-size:0.9rem;">
        Total konten Anda: <strong>{{ $myUploads->count() }}</strong> gambar
    </p>
</div>

@endif

{{-- CSRF Token untuk AJAX --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- JavaScript untuk unfavorite dan delete --}}
<script>
// Fungsi untuk unfavorite gambar
async function unfavoriteImage(imageId) {
    if (!confirm('Hapus dari favorit?')) return;

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    try {
        const response = await fetch(`/dashboard/favorites/${imageId}/toggle`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            // Reload halaman untuk update tampilan
            location.reload();
        } else {
            alert('Gagal menghapus dari favorit. Silakan coba lagi.');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    }
}

// Fungsi untuk menghapus upload gambar
async function deleteUpload(uploadId) {
    if (!confirm('Apakah Anda yakin ingin menghapus gambar ini? Tindakan ini tidak dapat dibatalkan.')) {
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const deleteBtn = document.querySelector(`button[data-upload-id="${uploadId}"]`);
    
    // Disable button dan ubah text
    if (deleteBtn) {
        deleteBtn.disabled = true;
        deleteBtn.textContent = 'Menghapus...';
        deleteBtn.style.opacity = '0.6';
        deleteBtn.style.cursor = 'not-allowed';
    }
    
    try {
        const response = await fetch(`/dashboard/uploads/${uploadId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            // Tampilkan notifikasi sukses
            showNotification('success', data.message || 'Gambar berhasil dihapus!');
            
            // Hapus card dari DOM dengan animasi
            const card = document.getElementById(`upload-card-${uploadId}`);
            if (card) {
                card.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                card.style.opacity = '0';
                card.style.transform = 'scale(0.9)';
                
                setTimeout(() => {
                    card.remove();
                    
                    // Update counter
                    updateUploadCounter();
                    
                    // Reload halaman setelah 1 detik untuk sync dengan database
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }, 300);
            }
        } else {
            // Tampilkan error
            showNotification('error', data.message || 'Gagal menghapus gambar. Silakan coba lagi.');
            
            // Re-enable button
            if (deleteBtn) {
                deleteBtn.disabled = false;
                deleteBtn.textContent = 'Hapus';
                deleteBtn.style.opacity = '1';
                deleteBtn.style.cursor = 'pointer';
            }
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('error', 'Terjadi kesalahan saat menghapus gambar. Silakan coba lagi.');
        
        // Re-enable button
        if (deleteBtn) {
            deleteBtn.disabled = false;
            deleteBtn.textContent = 'Hapus';
            deleteBtn.style.opacity = '1';
            deleteBtn.style.cursor = 'pointer';
        }
    }
}

// Fungsi untuk menampilkan notifikasi
function showNotification(type, message) {
    const notification = document.createElement('div');
    const bgColor = type === 'success' ? '#d4edda' : '#f8d7da';
    const borderColor = type === 'success' ? '#c3e6cb' : '#f5c6cb';
    const textColor = type === 'success' ? '#155724' : '#721c24';
    
    notification.style.cssText = `
        background: ${bgColor};
        border: 1px solid ${borderColor};
        color: ${textColor};
        padding: 0.75rem 1rem;
        border-radius: 6px;
        margin-bottom: 1.5rem;
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        animation: slideIn 0.3s ease;
    `;
    
    notification.textContent = message;
    document.body.appendChild(notification);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Fungsi untuk update counter
function updateUploadCounter() {
    const cards = document.querySelectorAll('[id^="upload-card-"]');
    const counterElement = document.querySelector('div[style*="margin-top:2rem"] strong');
    if (counterElement) {
        counterElement.textContent = cards.length;
    }
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
</script>

@endsection