@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')

{{-- CSRF Token untuk AJAX --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

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

{{-- ================= SEARCH BAR (full width) ================= --}}
<div style="width:100%;margin-bottom:1.5rem;">
    <div style="background:#fff;border-radius:30px;
                box-shadow:0 2px 10px rgba(0,0,0,0.12);
                display:flex;align-items:center;">

        <div style="padding:0 1rem 0 1.2rem;display:flex;align-items:center;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                <path fill="#999" d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.39ZM11 18a7 7 0 1 1 7-7a7 7 0 0 1-7 7Z"/>
            </svg>
        </div>

        <input type="text"
               id="searchInput"
               placeholder="Cari... (aesthetic / sport)"
               autocomplete="off"
               style="flex:1;padding:0.9rem 0;border:none;outline:none;font-size:1rem;color:#333;background:transparent;"
               oninput="onSearch()">

        <button id="clearBtn"
                onclick="clearSearch()"
                style="display:none;background:none;border:none;cursor:pointer;
                       padding:0 1.2rem 0 0.4rem;color:#999;font-size:1.1rem;line-height:1;"
                title="Hapus">✕</button>
    </div>
</div>

@if($uploads->isEmpty())
    <div style="text-align:center;padding:4rem 0;">
        <p style="color:#999;font-size:1rem;">Belum ada gambar yang diupload.</p>
    </div>
@else

{{-- ================= EXPAND VIEW ================= --}}
<div id="expandView"
     style="display:none;gap:16px;margin-bottom:16px;
            animation:fadeSlideIn 0.3s ease;">

    {{-- KIRI: Gambar besar --}}
    <div style="flex-shrink:0;width:420px;max-width:55vw;">
        <div style="position:relative;border-radius:14px;overflow:hidden;
                    box-shadow:0 6px 24px rgba(0,0,0,0.16);background:#1a1a1a;">

            <img id="expandImg" src="" alt=""
                 style="width:100%;display:block;border-radius:14px;">

            {{-- Watermark copyright --}}
            <div style="position:absolute;bottom:10px;left:12px;
                        background:rgba(0,0,0,0.75);color:#fff;
                        font-size:0.7rem;padding:4px 10px;border-radius:14px;
                        display:flex;align-items:center;gap:5px;pointer-events:none;
                        backdrop-filter:blur(4px);">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <span id="expandUploader" style="font-weight:600;letter-spacing:0.3px;"></span>
            </div>

            {{-- Tombol close --}}
            <button onclick="closeExpand()"
                    style="position:absolute;top:10px;right:10px;
                           background:rgba(255,255,255,0.95);border:none;
                           border-radius:50%;width:32px;height:32px;
                           display:flex;align-items:center;justify-content:center;
                           cursor:pointer;box-shadow:0 2px 6px rgba(0,0,0,0.2);
                           transition:background 0.2s;"
                    onmouseenter="this.style.background='#fff'"
                    onmouseleave="this.style.background='rgba(255,255,255,0.95)'"
                    title="Tutup">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="2.5">
                    <path d="M18 6L6 18M6 6l12 12"/>
                </svg>
            </button>

            {{-- ================= 4 ICON ACTIONS (EXPAND VIEW) ================= --}}
            <div id="expandIconActions"
                 style="position:absolute;bottom:10px;right:12px;
                        display:flex;align-items:center;gap:8px;z-index:10;
                        animation:slideInIcons 0.4s ease;">

                {{-- Suka / Favorit --}}
                <button class="icon-btn like-btn-expand"
                        id="expandLikeBtn"
                        onclick="event.stopPropagation(); toggleLikeExpand()"
                        title="Suka"
                        style="background:rgba(255,255,255,0.95);border:none;border-radius:50%;
                               width:40px;height:40px;display:flex;align-items:center;justify-content:center;
                               cursor:pointer;transition:all 0.2s;box-shadow:0 2px 10px rgba(0,0,0,0.2);"
                        onmouseenter="this.style.transform='scale(1.1)'"
                        onmouseleave="this.style.transform='scale(1)'">
                    <svg class="like-icon-expand" width="20" height="20" viewBox="0 0 24 24">
                        <path fill="#000" d="M12 20.325q-.35 0-.713-.125t-.637-.4l-1.725-1.575q-2.65-2.425-4.788-4.813T2 8.15Q2 5.8 3.575 4.225T7.5 2.65q1.325 0 2.5.562t2 1.538q.825-.975 2-1.538t2.5-.562q2.35 0 3.925 1.575T22 8.15q0 2.875-2.125 5.275T15.05 18.25l-1.7 1.55q-.275.275-.637.4t-.713.125ZM11.05 6.75q-.725-1.025-1.55-1.562t-2-.538q-1.5 0-2.5 1t-1 2.5q0 1.3.925 2.763t2.213 2.837q1.287 1.375 2.65 2.575T12 18.3q.85-.775 2.213-1.975t2.65-2.575q1.287-1.375 2.212-2.837T20 8.15q0-1.5-1-2.5t-2.5-1q-1.175 0-2 .537T12.95 6.75q-.175.25-.425.375T12 7.25q-.275 0-.525-.125t-.425-.375Zm.95 4.725Z"/>
                    </svg>
                </button>

                {{-- Unduh / Download --}}
                <button onclick="event.stopPropagation(); downloadImageExpand()"
                        title="Unduh"
                        style="background:rgba(255,255,255,0.95);border:none;border-radius:50%;
                               width:40px;height:40px;display:flex;align-items:center;justify-content:center;
                               cursor:pointer;transition:all 0.2s;box-shadow:0 2px 10px rgba(0,0,0,0.2);"
                        onmouseenter="this.style.transform='scale(1.1)'"
                        onmouseleave="this.style.transform='scale(1)'">
                    <svg width="20" height="20" viewBox="0 0 20 20">
                        <path fill="#000" d="M19.31 12.051c.381 0 .69.314.69.7v4.918c-.006.67-.127 1.2-.399 1.594c-.328.476-.908.692-1.747.737l-15.903-.002c-.646-.046-1.168-.302-1.507-.777c-.302-.423-.446-.95-.444-1.558V12.75c0-.386.309-.7.69-.7c.38 0 .688.314.688.7v4.913c0 .333.065.572.182.736c.081.114.224.184.44.201l15.817.001c.42-.023.627-.1.655-.14c.084-.123.146-.393.15-.8V12.75c0-.386.308-.7.689-.7ZM9.99 0c.38 0 .69.313.69.7l-.001 10.869l3.062-3.079a.682.682 0 0 1 .975.004a.707.707 0 0 1-.004.99l-4.356 4.38a.682.682 0 0 1-.973-.003l-4.296-4.38a.707.707 0 0 1 .002-.99a.682.682 0 0 1 .975.002L9.3 11.794V.699C9.3.313 9.61 0 9.99 0Z"/>
                    </svg>
                </button>

                {{-- Fullscreen --}}
                <button onclick="event.stopPropagation(); openFullscreenFromExpand()"
                        title="Layar penuh"
                        style="background:rgba(255,255,255,0.95);border:none;border-radius:50%;
                               width:40px;height:40px;display:flex;align-items:center;justify-content:center;
                               cursor:pointer;transition:all 0.2s;box-shadow:0 2px 10px rgba(0,0,0,0.2);"
                        onmouseenter="this.style.transform='scale(1.1)'"
                        onmouseleave="this.style.transform='scale(1)'">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="#000">
                        <g fill="none">
                            <path d="M24 0v24H0V0h24ZM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018Zm.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01l-.184-.092Z"/>
                            <path fill="#000" d="M9.793 12.793a1 1 0 0 1 1.497 1.32l-.083.094L6.414 19H9a1 1 0 0 1 .117 1.993L9 21H4a1 1 0 0 1-.993-.883L3 20v-5a1 1 0 0 1 1.993-.117L5 15v2.586l4.793-4.793ZM20 3a1 1 0 0 1 .993.883L21 4v5a1 1 0 0 1-1.993.117L19 9V6.414l-4.793 4.793a1 1 0 0 1-1.497-1.32l.083-.094L17.586 5H15a1 1 0 0 1-.117-1.993L15 3h5Z"/>
                        </g>
                    </svg>
                </button>

                {{-- Comment --}}
                <button onclick="event.stopPropagation(); openCommentExpand()"
                        title="Komentar"
                        style="background:rgba(255,255,255,0.95);border:none;border-radius:50%;
                               width:40px;height:40px;display:flex;align-items:center;justify-content:center;
                               cursor:pointer;transition:all 0.2s;box-shadow:0 2px 10px rgba(0,0,0,0.2);"
                        onmouseenter="this.style.transform='scale(1.1)'"
                        onmouseleave="this.style.transform='scale(1)'">
                    <svg width="20" height="20" viewBox="0 0 24 24">
                        <path fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7.09 2.75a4 4 0 0 0-4 4v6.208a4 4 0 0 0 4 4h.093v3.792a.5.5 0 0 0 .839.368l4.52-4.16h4.369a4 4 0 0 0 4-4V6.75a4 4 0 0 0-4-4z"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Info di bawah gambar besar --}}
        <div style="margin-top:12px;padding:0 2px;">
            <p id="expandTitle" style="font-size:0.95rem;font-weight:600;color:#222;margin:0 0 4px 0;"></p>
            <p style="font-size:0.8rem;color:#888;margin:0;">
                Kategori: <span id="expandTopic" style="text-transform:capitalize;"></span>
            </p>
        </div>
    </div>

    {{-- KANAN: Masonry grid sisa gambar --}}
    <div id="expandRight"
         style="flex:1;min-width:0;
                column-count:3;column-gap:10px;">
    </div>
</div>

{{-- ================= TRUE MASONRY GRID (PINTEREST STYLE) ================= --}}
<div id="masonryGrid" style="column-count:5;column-gap:14px;">

    @foreach($uploads as $upload)
    <div class="masonry-item"
         data-topic="{{ $upload->topic }}"
         data-title="{{ strtolower($upload->title) }}"
         data-url="{{ $upload->image_url }}"
         data-uploader="{{ $upload->user->name ?? 'Unknown' }}"
         data-id="{{ $upload->id }}"
         data-is-liked="{{ $upload->is_liked_by_current_user ? 'true' : 'false' }}"
         onclick="openExpand(this)"
         style="break-inside:avoid;margin-bottom:14px;position:relative;
                border-radius:16px;overflow:hidden;cursor:pointer;
                background:#f0f0f0;transition:all 0.3s ease;
                box-shadow:0 1px 3px rgba(0,0,0,0.12);">

        {{-- Gambar --}}
        <img src="{{ $upload->image_url }}"
             alt="{{ $upload->title }}"
             style="width:100%;height:auto;display:block;border-radius:16px;"
             onerror="this.onerror=null;this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%22160%22%3E%3Crect width=%22100%22 height=%22160%22 fill=%22%23ddd%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dy=%22.3em%22 fill=%22%23999%22 font-size=%2214%22%3ENo Image%3C/text%3E%3C/svg%3E';this.parentElement.style.background='transparent';"
             onload="this.parentElement.style.background='transparent'">

        {{-- Overlay hover --}}
        <div class="masonry-overlay"
             style="position:absolute;inset:0;
                    background:linear-gradient(to top, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.3) 40%, transparent 65%);
                    opacity:0;transition:opacity 0.3s ease;border-radius:16px;
                    display:flex;flex-direction:column;justify-content:flex-end;padding:14px;">

            <div style="display:flex;align-items:center;gap:6px;margin-bottom:4px;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <span style="color:#fff;font-size:0.78rem;font-weight:600;letter-spacing:0.2px;">
                    {{ $upload->user->name ?? 'Unknown' }}
                </span>
            </div>
            <span style="color:#fff;font-size:0.85rem;font-weight:500;line-height:1.3;">
                {{ $upload->title }}
            </span>
        </div>

        {{-- Watermark copyright - DESIGN BARU --}}
        <div class="copyright-badge"
             style="position:absolute;bottom:8px;left:8px;
                    background:rgba(0,0,0,0.75);color:#fff;
                    font-size:0.65rem;padding:4px 9px;border-radius:14px;
                    display:flex;align-items:center;gap:4px;
                    pointer-events:none;z-index:2;
                    backdrop-filter:blur(4px);
                    font-weight:600;letter-spacing:0.3px;">
            <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            © {{ $upload->user->name ?? 'Unknown' }}
        </div>
    </div>
    @endforeach
</div>

{{-- Pesan kosong --}}
<div id="noResultMsg"
     style="display:none;text-align:center;padding:3rem 0;color:#999;font-size:1rem;">
    Tidak ditemukan gambar yang sesuai.
</div>

@endif

{{-- ================= FULLSCREEN OVERLAY ================= --}}
<div id="fullscreenOverlay"
     style="display:none;position:fixed;inset:0;
            background:rgba(0,0,0,0.95);z-index:99999;
            align-items:center;justify-content:center;">

    {{-- Tombol tutup --}}
    <button onclick="closeFullscreen()"
            style="position:absolute;top:18px;right:18px;
                   background:rgba(255,255,255,0.12);border:none;border-radius:50%;
                   width:40px;height:40px;display:flex;align-items:center;justify-content:center;
                   cursor:pointer;z-index:100000;transition:background 0.2s;"
            onmouseenter="this.style.background='rgba(255,255,255,0.25)'"
            onmouseleave="this.style.background='rgba(255,255,255,0.12)'"
            title="Tutup">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2">
            <path d="M18 6L6 18M6 6l12 12"/>
        </svg>
    </button>

    {{-- Gambar --}}
    <img id="fullscreenImg" src="" alt=""
         style="max-width:92vw;max-height:88vh;object-fit:contain;border-radius:10px;
                box-shadow:0 8px 40px rgba(0,0,0,0.5);">

    {{-- Info + watermark bawah --}}
    <div style="position:absolute;bottom:24px;left:0;right:0;text-align:center;">
        <div style="display:inline-flex;align-items:center;gap:7px;
                    background:rgba(0,0,0,0.7);padding:6px 16px;border-radius:20px;
                    backdrop-filter:blur(8px);">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <span id="fullscreenAuthor" style="color:#fff;font-size:0.85rem;font-weight:600;letter-spacing:0.3px;"></span>
            <span style="color:rgba(255,255,255,0.4);margin:0 4px;">•</span>
            <span id="fullscreenTitle" style="color:#fff;font-size:0.85rem;opacity:0.9;"></span>
        </div>
    </div>
</div>

{{-- ================= STYLES ================= --}}
<style>
    /* Masonry Grid - TRUE PINTEREST STYLE */
    #masonryGrid {
        column-count: 5;
        column-gap: 14px;
    }

    /* Hover masonry item - smooth transition */
    .masonry-item {
        transition: transform 0.3s ease, box-shadow 0.3s ease, filter 0.3s ease;
    }
    
    .masonry-item:hover { 
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 10;
        filter: brightness(1.02);
    }
    
    .masonry-item:hover .masonry-overlay { 
        opacity: 1;
    }

    .masonry-item:hover .copyright-badge {
        background: rgba(0,0,0,0.85);
    }

    /* Mini item di panel kanan expand */
    .mini-item {
        break-inside: avoid;
        margin-bottom: 10px;
        border-radius: 12px;
        overflow: hidden;
        cursor: pointer;
        position: relative;
        background: #f0f0f0;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.12);
    }
    
    .mini-item:hover { 
        transform: scale(1.02); 
        box-shadow: 0 3px 8px rgba(0,0,0,0.15);
        z-index: 2; 
    }
    
    .mini-item img { 
        width: 100%; 
        display: block; 
        border-radius: 12px; 
    }

    .mini-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.25) 40%, transparent 65%);
        opacity: 0;
        transition: opacity 0.25s ease;
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 10px;
    }
    
    .mini-item:hover .mini-overlay { 
        opacity: 1; 
    }

    .mini-copyright {
        position: absolute;
        bottom: 6px;
        left: 6px;
        background: rgba(0,0,0,0.75);
        color: #fff;
        font-size: 0.6rem;
        padding: 3px 7px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 3px;
        pointer-events: none;
        backdrop-filter: blur(4px);
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    /* Like button state - dengan warna merah ketika liked */
    .like-btn-expand.liked {
        background: rgba(255, 71, 87, 0.95) !important;
    }
    
    .like-btn-expand.liked .like-icon-expand path {
        fill: #fff !important;
    }

    /* Animasi */
    @keyframes fadeSlideIn {
        from { 
            opacity: 0; 
            transform: translateY(-10px); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
        }
    }

    @keyframes slideInIcons {
        from { 
            opacity: 0; 
            transform: translateX(20px); 
        }
        to { 
            opacity: 1; 
            transform: translateX(0); 
        }
    }

    /* Responsive – masonry utama */
    @media (max-width: 1400px) { 
        #masonryGrid { 
            column-count: 4;
        } 
    }
    
    @media (max-width: 1100px) { 
        #masonryGrid { 
            column-count: 3;
        } 
    }
    
    @media (max-width: 768px) { 
        #masonryGrid { 
            column-count: 2;
            column-gap: 12px;
        } 
    }
    
    @media (max-width: 480px) { 
        #masonryGrid { 
            column-count: 2;
            column-gap: 10px;
        }
        
        .masonry-item {
            margin-bottom: 10px;
        }
    }

    /* Responsive – expand view */
    @media (max-width: 900px) {
        #expandView { 
            flex-direction: column !important; 
        }
        
        #expandView > div:first-child { 
            width: 100% !important; 
            max-width: 100% !important; 
        }
        
        #expandRight { 
            column-count: 3 !important; 
        }
    }
    
    @media (max-width: 600px) {
        #expandRight { 
            column-count: 2 !important; 
        }
    }
</style>

{{-- ================= SCRIPTS ================= --}}
<script>
(function(){

    const searchInput  = document.getElementById('searchInput');
    const clearBtn     = document.getElementById('clearBtn');
    const grid         = document.getElementById('masonryGrid');
    const expandView   = document.getElementById('expandView');
    const noMsg        = document.getElementById('noResultMsg');

    let currentExpandId = null;
    let currentExpandUrl = null;
    let currentExpandTitle = null;

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    /* ─────────────── SEARCH ─────────────── */
    function onSearch() {
        const q = searchInput.value.trim().toLowerCase();
        clearBtn.style.display = q.length ? 'flex' : 'none';

        if (expandView && expandView.style.display === 'flex') closeExpand();

        if (!grid) return;
        let vis = 0;

        grid.querySelectorAll('.masonry-item').forEach(item => {
            const topic = item.dataset.topic;
            const title = item.dataset.title;
            const match = (q === '') || (topic === q) || title.includes(q);
            item.style.display = match ? 'block' : 'none';
            if (match) vis++;
        });

        if (noMsg) noMsg.style.display = vis === 0 ? 'block' : 'none';
    }

    function clearSearch() {
        searchInput.value = '';
        clearBtn.style.display = 'none';
        onSearch();
    }

    window.onSearch    = onSearch;
    window.clearSearch = clearSearch;

    /* ─────────────── LIKE / FAVORIT ─────────────── */
    window.toggleLikeExpand = async function() {
        const btn = document.getElementById('expandLikeBtn');
        if (!currentExpandId) return;

        try {
            const response = await fetch(`/dashboard/favorites/${currentExpandId}/toggle`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success) {
                if (data.liked) {
                    btn.classList.add('liked');
                } else {
                    btn.classList.remove('liked');
                }

                const masonryItem = document.querySelector(`.masonry-item[data-id="${currentExpandId}"]`);
                if (masonryItem) {
                    masonryItem.dataset.isLiked = data.liked ? 'true' : 'false';
                }

                console.log(data.message);
            } else {
                console.error('Failed to toggle favorite:', data.message);
                alert('Gagal mengubah favorit. Silakan coba lagi.');
            }
        } catch (error) {
            console.error('Error toggling favorite:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        }
    };

    /* ─────────────── DOWNLOAD ─────────────── */
    window.downloadImageExpand = function() {
        if (!currentExpandUrl || !currentExpandId) return;
        
        try {
            // Gunakan backend endpoint untuk download dengan proper headers
            const downloadUrl = `/dashboard/uploads/${currentExpandId}/download`;
            
            const link = document.createElement('a');
            link.href = downloadUrl;
            link.download = '';  // Biarkan server tentukan nama file
            link.setAttribute('target', '_blank');
            document.body.appendChild(link);
            
            link.click();
            
            // Cleanup
            setTimeout(() => {
                document.body.removeChild(link);
            }, 100);
            
        } catch (error) {
            console.error('Error downloading image:', error);
            alert('Gagal mengunduh gambar. Silakan coba lagi.');
        }
    };

    /* ─────────────── FULLSCREEN ─────────────── */
    window.openFullscreenFromExpand = function() {
        if (!currentExpandUrl || !currentExpandTitle) return;
        
        const uploader = document.getElementById('expandUploader').textContent.replace('© ', '');
        document.getElementById('fullscreenImg').src = currentExpandUrl;
        document.getElementById('fullscreenTitle').textContent = currentExpandTitle;
        document.getElementById('fullscreenAuthor').textContent = uploader;
        document.getElementById('fullscreenOverlay').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };

    window.closeFullscreen = function() {
        document.getElementById('fullscreenOverlay').style.display = 'none';
        document.body.style.overflow = 'auto';
    };

    // Klik luar gambar → tutup fullscreen
    document.getElementById('fullscreenOverlay').addEventListener('click', function(e) {
        if (e.target === this || e.target === document.getElementById('fullscreenImg')) {
            closeFullscreen();
        }
    });

    /* ─────────────── COMMENT ─────────────── */
    window.openCommentExpand = function() {
        if (!currentExpandId) return;
        alert('Fitur komentar untuk gambar ID: ' + currentExpandId + ' akan segera hadir!');
    };

    /* ─────────────── EXPAND (click gambar) ─────────────── */
    window.openExpand = function(clickedEl) {
        const url      = clickedEl.dataset.url;
        const uploader = clickedEl.dataset.uploader;
        const title    = clickedEl.querySelector('img').alt;
        const topic    = clickedEl.dataset.topic;
        const clickId  = clickedEl.dataset.id;
        const isLiked  = clickedEl.dataset.isLiked === 'true';

        currentExpandId = clickId;
        currentExpandUrl = url;
        currentExpandTitle = title;

        const likeBtn = document.getElementById('expandLikeBtn');
        if (isLiked) {
            likeBtn.classList.add('liked');
        } else {
            likeBtn.classList.remove('liked');
        }

        document.getElementById('expandImg').src   = url;
        document.getElementById('expandImg').alt   = title;
        document.getElementById('expandUploader').textContent = '© ' + uploader;
        document.getElementById('expandTitle').textContent    = title;
        document.getElementById('expandTopic').textContent    = topic;

        const rightCol = document.getElementById('expandRight');
        rightCol.innerHTML = '';

        grid.querySelectorAll('.masonry-item').forEach(item => {
            if (item.dataset.id === clickId) return;
            if (item.style.display === 'none') return;

            const iUrl      = item.dataset.url;
            const iUploader = item.dataset.uploader;
            const iTitle    = item.querySelector('img').alt;
            const iTopic    = item.dataset.topic;
            const iId       = item.dataset.id;
            const iIsLiked  = item.dataset.isLiked;

            const mini = document.createElement('div');
            mini.className = 'mini-item';
            mini.dataset.url      = iUrl;
            mini.dataset.uploader = iUploader;
            mini.dataset.id       = iId;
            mini.dataset.topic    = iTopic;
            mini.dataset.isLiked  = iIsLiked;

            mini.innerHTML = `
                <img src="${iUrl}" alt="${iTitle}"
                     onerror="this.onerror=null;this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%22120%22%3E%3Crect width=%22100%22 height=%22120%22 fill=%22%23ddd%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dy=%22.3em%22 fill=%22%23999%22 font-size=%2212%22%3ENo Image%3C/text%3E%3C/svg%3E';this.parentElement.style.background='transparent';"
                     onload="this.parentElement.style.background='transparent'">
                <div class="mini-overlay">
                    <div style="display:flex;align-items:center;gap:4px;margin-bottom:2px;">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span style="color:#fff;font-size:0.7rem;font-weight:600;letter-spacing:0.2px;">${iUploader}</span>
                    </div>
                    <span style="color:#fff;font-size:0.72rem;font-weight:500;line-height:1.2;">${iTitle}</span>
                </div>
                <div class="mini-copyright">
                    <svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    © ${iUploader}
                </div>
            `;

            mini.addEventListener('click', function() { swapToBig(this); });
            rightCol.appendChild(mini);
        });

        expandView.style.display = 'flex';
        grid.style.display       = 'none';
        if (noMsg) noMsg.style.display = 'none';
    };

    /* ─────────────── SWAP mini → besar ─────────────── */
    function swapToBig(miniEl) {
        const bigImg     = document.getElementById('expandImg');
        const bigUpLabel = document.getElementById('expandUploader');
        const bigTitle   = document.getElementById('expandTitle');
        const bigTopic   = document.getElementById('expandTopic');

        const oldUrl      = bigImg.src;
        const oldTitle    = bigImg.alt;
        const oldUploader = bigUpLabel.textContent.replace('© ', '');
        const oldTopic    = bigTopic.textContent;
        const oldId       = currentExpandId;

        const newUrl      = miniEl.dataset.url;
        const newUploader = miniEl.dataset.uploader;
        const newTitle    = miniEl.querySelector('img').alt;
        const newTopic    = miniEl.dataset.topic;
        const newId       = miniEl.dataset.id;
        const newIsLiked  = miniEl.dataset.isLiked === 'true';

        currentExpandId = newId;
        currentExpandUrl = newUrl;
        currentExpandTitle = newTitle;

        const likeBtn = document.getElementById('expandLikeBtn');
        if (newIsLiked) {
            likeBtn.classList.add('liked');
        } else {
            likeBtn.classList.remove('liked');
        }

        bigImg.src  = newUrl;
        bigImg.alt  = newTitle;
        bigUpLabel.textContent = '© ' + newUploader;
        bigTitle.textContent   = newTitle;
        bigTopic.textContent   = newTopic;

        miniEl.querySelector('img').src = oldUrl;
        miniEl.querySelector('img').alt = oldTitle;
        miniEl.dataset.url      = oldUrl;
        miniEl.dataset.uploader = oldUploader;
        miniEl.dataset.topic    = oldTopic;
        miniEl.dataset.id       = oldId;

        const overlaySpans = miniEl.querySelectorAll('.mini-overlay span');
        if (overlaySpans[0]) overlaySpans[0].textContent = oldUploader;
        if (overlaySpans[1]) overlaySpans[1].textContent = oldTitle;

        const copyrightDiv = miniEl.querySelector('.mini-copyright');
        if (copyrightDiv) {
            const textNode = Array.from(copyrightDiv.childNodes).find(
                node => node.nodeType === 3 && node.textContent.includes('©')
            );
            if (textNode) {
                textNode.textContent = ' © ' + oldUploader;
            }
        }
    }

    /* ─────────────── TUTUP EXPAND ─────────────── */
    window.closeExpand = function() {
        expandView.style.display = 'none';
        if (grid) grid.style.display = 'block';

        currentExpandId = null;
        currentExpandUrl = null;
        currentExpandTitle = null;

        if (noMsg && grid) {
            let vis = 0;
            grid.querySelectorAll('.masonry-item').forEach(i => {
                if (i.style.display !== 'none') vis++;
            });
            noMsg.style.display = vis === 0 ? 'block' : 'none';
        }
    };

    /* ─────────────── ESC key ─────────────── */
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (document.getElementById('fullscreenOverlay').style.display === 'flex') {
                closeFullscreen();
            } else if (expandView && expandView.style.display === 'flex') {
                closeExpand();
            }
        }
    });

})();
</script>

@endsection
