@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&display=swap');

    .ps-wrap {
        width: 100%;
        padding: 2.5rem 2.5rem;
        font-family: 'DM Sans', sans-serif;
        box-sizing: border-box;
    }

    /* Page Title */
    .ps-page-title {
        font-size: 0.75rem;
        font-weight: 600;
        color: #767676;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.4rem;
    }

    .ps-heading {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        margin-bottom: 2rem;
    }

    .ps-pin-dot {
        width: 9px;
        height: 9px;
        background: #E60023;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .ps-heading h2 {
        font-size: 1.4rem;
        font-weight: 600;
        color: #111;
        margin: 0;
        letter-spacing: -0.3px;
    }

    /* Layout: two-column on wide screens */
    .ps-layout {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 1.5rem;
        align-items: start;
    }

    /* Card */
    .ps-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #E8E8E8;
        overflow: hidden;
    }

    .ps-card-header {
        padding: 1.25rem 1.75rem;
        border-bottom: 1px solid #F0F0F0;
    }

    .ps-card-header span {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #999;
    }

    .ps-card-body {
        padding: 1.75rem;
    }

    /* Fields */
    .ps-field {
        margin-bottom: 1.4rem;
    }

    .ps-label {
        display: block;
        font-size: 0.82rem;
        font-weight: 500;
        color: #444;
        margin-bottom: 0.45rem;
    }

    .ps-input {
        width: 100%;
        border: 1px solid #E0E0E0;
        border-radius: 10px;
        padding: 0.72rem 1rem;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.95rem;
        color: #111;
        background: #FAFAFA;
        outline: none;
        transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
        box-sizing: border-box;
    }

    .ps-input:focus {
        border-color: #E60023;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(230, 0, 35, 0.07);
    }

    .ps-input::placeholder { color: #C8C8C8; }

    .ps-error {
        color: #E60023;
        font-size: 0.78rem;
        margin-top: 0.35rem;
    }

    .ps-card-footer {
        padding: 1.25rem 1.75rem;
        border-top: 1px solid #F0F0F0;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.75rem;
    }

    .ps-btn {
        background: #E60023;
        color: #fff;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.88rem;
        font-weight: 600;
        padding: 0.65rem 1.75rem;
        border-radius: 9px;
        border: none;
        cursor: pointer;
        transition: background 0.15s;
        letter-spacing: 0.1px;
    }

    .ps-btn:hover { background: #CC0020; }

    /* Info card (right column) */
    .ps-info-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #E8E8E8;
        padding: 1.5rem;
    }

    .ps-info-card h4 {
        font-size: 0.82rem;
        font-weight: 600;
        color: #111;
        margin: 0 0 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.6px;
    }

    .ps-info-item {
        display: flex;
        align-items: flex-start;
        gap: 0.6rem;
        margin-bottom: 0.85rem;
    }

    .ps-info-item:last-child { margin-bottom: 0; }

    .ps-info-dot {
        width: 6px;
        height: 6px;
        background: #E60023;
        border-radius: 50%;
        margin-top: 5px;
        flex-shrink: 0;
    }

    .ps-info-item p {
        font-size: 0.82rem;
        color: #767676;
        margin: 0;
        line-height: 1.5;
    }

    /* Alert */
    .ps-alert {
        background: #FFF5F5;
        border: 1px solid rgba(230, 0, 35, 0.15);
        border-radius: 10px;
        padding: 0.65rem 1rem;
        font-size: 0.85rem;
        color: #E60023;
        font-weight: 500;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    @media (max-width: 768px) {
        .ps-layout { grid-template-columns: 1fr; }
        .ps-wrap { padding: 1.5rem 1rem; }
    }
</style>

<div class="ps-wrap">

    {{-- Heading --}}
    <div class="ps-heading">
        <div class="ps-pin-dot"></div>
        <h2>Settings</h2>
    </div>

    {{-- Success alert --}}
    @if(session('success'))
        <div class="ps-alert">
            <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="ps-layout">

        {{-- Main Form Card --}}
        <div class="ps-card">
            <div class="ps-card-header">
                <span>General Configuration</span>
            </div>

            <form action="{{ route('dashboard.updateSettings') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="ps-card-body">

                    <div class="ps-field">
                        <label class="ps-label" for="site_name">Site Name</label>
                        <input
                            type="text"
                            id="site_name"
                            name="site_name"
                            class="ps-input"
                            value="{{ old('site_name', 'Gallery PWL') }}"
                            placeholder="Enter your site name"
                        >
                        @error('site_name')
                            <p class="ps-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="ps-field">
                        <label class="ps-label" for="admin_email">Admin Email</label>
                        <input
                            type="email"
                            id="admin_email"
                            name="admin_email"
                            class="ps-input"
                            value="{{ old('admin_email', 'admin@example.com') }}"
                            placeholder="admin@example.com"
                        >
                        @error('admin_email')
                            <p class="ps-error">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="ps-card-footer">
                    <button type="submit" class="ps-btn">Save Settings</button>
                </div>

            </form>
        </div>

        {{-- Right Info Card --}}
        <div class="ps-info-card">
            <h4>About Settings</h4>

            <div class="ps-info-item">
                <div class="ps-info-dot"></div>
                <p><strong>Site Name</strong> is displayed on the browser tab and email headers.</p>
            </div>
            <div class="ps-info-item">
                <div class="ps-info-dot"></div>
                <p><strong>Admin Email</strong> receives all system notifications and alerts.</p>
            </div>
            <div class="ps-info-item">
                <div class="ps-info-dot"></div>
                <p>Changes take effect immediately after saving.</p>
            </div>
        </div>

    </div>
</div>

@endsection