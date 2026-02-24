<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard') - Gallery PWL</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- External CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    {{-- Sidebar --}}
    <aside class="sidebar">
        <div class="logo">Gallery PWL</div>
        <nav>
            {{-- Dashboard / Home --}}
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024">
                    <path d="M1016.7 513.36L536.331 10.192a31.924 31.924 0 0 0-23.088-9.84a32.038 32.038 0 0 0-23.088 9.84L7.307 513.344c-12.24 12.752-11.808 32.992.944 45.248c12.752 12.224 32.992 11.872 45.248-.944l43.007-44.832v478.832c0 17.68 14.336 32 32 32h223.552c17.632 0 31.936-14.256 32-31.905l1.008-319.664h254.992v319.568c0 17.68 14.32 32 32 32H895.53c17.68 0 32-14.32 32-32V512.655l42.992 45.04a31.997 31.997 0 0 0 23.09 9.84c7.967 0 15.967-2.944 22.16-8.944c12.736-12.224 13.152-32.48.928-45.232zm-153.165-58.544v504.831H704.063V640.095c0-17.68-14.32-32-32-32h-318.88c-17.632 0-31.936 14.256-32 31.904l-1.008 319.664H160.511V454.815c0-2.64-.416-5.168-1.008-7.632L513.263 78.56l351.424 368.208c-.688 2.592-1.152 5.264-1.152 8.048z"/>
                </svg>
                <span>Home</span>
            </a>

            {{-- Create --}}
            <a href="{{ route('dashboard.create') }}" class="{{ request()->routeIs('dashboard.create') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="-2 -2 24 24">
                    <path d="M4 2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H4zm0-2h12a4 4 0 0 1 4 4v12a4 4 0 0 1-4 4H4a4 4 0 0 1-4-4V4a4 4 0 0 1 4-4zm7 11v4a1 1 0 0 1-2 0v-4H5a1 1 0 0 1 0-2h4V5a1 1 0 1 1 2 0v4h4a1 1 0 0 1 0 2h-4z"/>
                </svg>
                <span>Create</span>
            </a>

            {{-- Collection --}}
            <a href="{{ route('dashboard.collection') }}" class="{{ request()->routeIs('dashboard.collection') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="m11.066 8.004l.184-.005h7.5a3.25 3.25 0 0 1 3.245 3.065l.005.185v7.5a3.25 3.25 0 0 1-3.066 3.245l-.184.005h-7.5a3.25 3.25 0 0 1-3.245-3.066L8 18.75v-7.5a3.25 3.25 0 0 1 3.066-3.245Zm7.684 1.495h-7.5a1.75 1.75 0 0 0-1.744 1.606l-.006.144v7.5a1.75 1.75 0 0 0 1.607 1.744l.143.006h7.5a1.75 1.75 0 0 0 1.744-1.607l.006-.143v-7.5a1.75 1.75 0 0 0-1.75-1.75ZM15 11a.75.75 0 0 1 .75.75v2.498h2.5a.75.75 0 0 1 0 1.5h-2.5v2.502a.75.75 0 0 1-1.5 0v-2.502h-2.5a.75.75 0 1 1 0-1.5h2.5V11.75A.75.75 0 0 1 15 11Zm.582-6.767l.052.177l.693 2.588h-1.553l-.588-2.2a1.75 1.75 0 0 0-2.144-1.238L4.798 5.502a1.75 1.75 0 0 0-1.27 1.995l.032.148l1.942 7.244A1.75 1.75 0 0 0 7 16.176v1.506a3.252 3.252 0 0 1-2.895-2.228l-.052-.176l-1.941-7.245a3.25 3.25 0 0 1 2.12-3.928l.178-.052l7.244-1.941a3.25 3.25 0 0 1 3.928 2.12Z"/>
                </svg>
                <span>Collection</span>
            </a>

            {{-- Settings --}}
            <a href="{{ route('dashboard.settings') }}" class="{{ request()->routeIs('dashboard.settings') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                    <path d="M21 16a5 5 0 1 1-10 0a5 5 0 0 1 10 0m-1 0a4 4 0 1 0-8 0a4 4 0 0 0 8 0M5.9 6.304a.96.96 0 0 1 1.095-.193l1.8.83a2 2 0 0 0 2.82-1.546l.297-2.176a.96.96 0 0 1 .71-.809A14 14 0 0 1 15.999 2c1.165 0 2.296.142 3.378.41a.96.96 0 0 1 .71.809l.297 2.176a2 2 0 0 0 2.819 1.546l1.8-.83a.96.96 0 0 1 1.095.193a14 14 0 0 1 3.35 5.795a.96.96 0 0 1-.382 1.045l-1.736 1.22a2 2 0 0 0 0 3.273l1.736 1.22a.96.96 0 0 1 .382 1.044a14 14 0 0 1-3.35 5.795a.96.96 0 0 1-1.094.193l-1.802-.83a2 2 0 0 0-2.818 1.546l-.297 2.176a.96.96 0 0 1-.71.809a14 14 0 0 1-3.378.41a14 14 0 0 1-3.378-.41a.96.96 0 0 1-.71-.809l-.296-2.176a2 2 0 0 0-2.82-1.546l-1.8.83a.96.96 0 0 1-1.095-.193A14 14 0 0 1 2.55 19.9a.96.96 0 0 1 .382-1.045l1.737-1.22a2 2 0 0 0 0-3.273l-1.737-1.22a.96.96 0 0 1-.382-1.045A14 14 0 0 1 5.9 6.305m-2.378 6.032l1.721 1.209c1.701 1.195 1.701 3.715 0 4.91l-1.72 1.209a13 13 0 0 0 3.07 5.31l1.784-.823a3 3 0 0 1 4.228 2.318l.295 2.16c.992.242 2.03.371 3.1.371a13 13 0 0 0 3.098-.371l.295-2.16a3 3 0 0 1 4.228-2.318l1.785.822a13 13 0 0 0 3.07-5.31l-1.72-1.208a3 3 0 0 1 0-4.91l1.72-1.209a13 13 0 0 0-3.07-5.31l-1.785.823a3 3 0 0 1-4.228-2.318l-.295-2.16A13 13 0 0 0 15.999 3c-1.069 0-2.107.129-3.099.371l-.295 2.16a3 3 0 0 1-4.228 2.318l-1.784-.822a13 13 0 0 0-3.07 5.31"/>
                </svg>
                <span>Settings</span>
            </a>
        </nav>

        {{-- Logout Section --}}
        <div class="logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </aside>

    {{-- Main Content Area --}}
    <div class="main">
        {{-- Header --}}
        <div class="header">
            <h1>
                @hasSection('header')
                    @yield('header')
                @elseif(View::hasSection('title'))
                    @yield('title')
                @else
                    Dashboard
                @endif
            </h1>
            <div class="user-info">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <span>{{ auth()->user()->name ?? 'Guest' }}</span>
            </div>
        </div>

        {{-- Page Content --}}
        <div class="content">
            @yield('content')
        </div>
    </div>
</body>
</html>