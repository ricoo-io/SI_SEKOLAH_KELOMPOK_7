<!-- filepath: c:\laragon\www\SI_SEKOLAH_Kelompok_7\resources\views\dashboard_admin.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard Admin - SI Sekolah</title>
    
    <style>
        [x-cloak] { display: none !important; }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    
    @fluxAppearance
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800 antialiased">

    <flux:sidebar sticky stashable class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
        {{-- Header Logo --}}
        <div class ="pt-7" >
            <flux:sidebar.header class=" justify-start pb-0">
                <div class="flex aspect-square size-10 items-center justify-center rounded-md bg-zinc-100 dark:bg-zinc-800 overflow-hidden">
                    <img src="{{ asset('image/Logo_Jaya_Ikan.png') }}" class="h-8 object-cover scale-125" alt="Logo SI-Sekolah">
                </div>
                <div class="flex flex-col">
                    <span class="truncate leading-tight font-bold text-lg text-zinc-900 dark:text-white">SMP JAYA IKAN</span>
                    <span class="truncate text-xs text-zinc-600 dark:text-zinc-400">Sistem Informasi</span>
                </div>
            </flux:sidebar.header>
        </div>
        <flux:separator variant="subtle" class="my-3" />

        {{-- Navigation Menu --}}
        <flux:sidebar.nav class="space-y-1">
            {{-- Dashboard --}}
            <flux:sidebar.item icon="home" href="{{ route('dashboard.admin') }}" current>
                Dashboard
            </flux:sidebar.item>
            
            {{-- Manajemen Data --}}
            <flux:sidebar.group expandable icon="document" heading="Manajemen Data" class="grid gap-1">
                <flux:sidebar.item href="#">Data Guru</flux:sidebar.item>
                <flux:sidebar.item href="#">Data Siswa</flux:sidebar.item>
                <flux:sidebar.item href="#">Data Kelas</flux:sidebar.item>
                <flux:sidebar.item href="#">Data Mata Pelajaran</flux:sidebar.item>
            </flux:sidebar.group> 

            {{-- Manajemen Akademik --}}
            <flux:sidebar.group expandable icon="calendar" heading="Manajemen Akademik" class="grid gap-1">
                <flux:sidebar.item href="#">Jadwal Mengajar</flux:sidebar.item>
                <flux:sidebar.item href="#">Plotting Guru</flux:sidebar.item>
                <flux:sidebar.item href="#">Tahun Ajaran</flux:sidebar.item>
            </flux:sidebar.group>
            
            {{-- Laporan --}}
            <flux:sidebar.group expandable icon="document-text" heading="Laporan" class="grid gap-1">
                <flux:sidebar.item href="#">Laporan Siswa</flux:sidebar.item>
                <flux:sidebar.item href="#">Laporan Guru</flux:sidebar.item>
                <flux:sidebar.item href="#">Laporan Kelas</flux:sidebar.item>
            </flux:sidebar.group>
        </flux:sidebar.nav>
        
        <flux:sidebar.spacer />
        
        {{-- Settings & Help --}}
        <flux:sidebar.nav class="border-t border-zinc-200 dark:border-zinc-700 pt-2">
            <flux:sidebar.item icon="cog-6-tooth" href="{{ route('profile.edit') }}">Settings</flux:sidebar.item>
            <flux:sidebar.item icon="information-circle" href="#">Help</flux:sidebar.item>
        </flux:sidebar.nav>
        
        {{-- Desktop User Profile --}}
        <flux:dropdown position="top" align="start" class="max-lg:hidden mt-2">
            <flux:sidebar.profile avatar="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=3b82f6&color=fff" name="{{ auth()->user()->name }}" />
            <flux:menu class="w-[240px]">
                <flux:menu.radio.group>
                    <div class="p-3 text-sm font-normal border-b border-zinc-200 dark:border-zinc-700">
                        <div class="flex items-center gap-3">
                            <span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full">
                                <span class="flex h-full w-full items-center justify-center rounded-full bg-blue-500 text-white font-semibold text-sm">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start leading-tight">
                                <span class="truncate font-semibold text-zinc-900 dark:text-white">{{ auth()->user()->name }}</span>
                                {{-- <span class="truncate text-xs text-zinc-600 dark:text-zinc-400">{{ auth()->user()->username }}</span> --}}
                                <span class="mt-1 inline-flex items-center rounded-sm bg-blue-100 dark:bg-blue-900/30 px-2 py-0.5 text-xs font-medium text-blue-700 dark:text-blue-400">
                                    Administrator
                                </span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full text-red-600 dark:text-red-400">
                        Log Out
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    {{-- Mobile Header --}}
    <flux:header class="lg:hidden border-b border-zinc-200 dark:border-zinc-700">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
        
        <div class="flex items-center gap-2">
            <img src="{{ asset('image/Logo_Jaya_Ikan.png') }}" class="h-8 w-8 object-cover" alt="Logo">
            <span class="font-bold text-zinc-900 dark:text-white">SI-Sekolah</span>
        </div>
        
        <flux:spacer />
        
        <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth()->user()->initials()" />
            <flux:menu class="w-[240px]">
                <flux:menu.radio.group>
                    <div class="p-3 text-sm font-normal border-b border-zinc-200 dark:border-zinc-700">
                        <div class="flex items-center gap-3">
                            <span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full">
                                <span class="flex h-full w-full items-center justify-center rounded-full bg-blue-500 text-white font-semibold text-sm">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start leading-tight">
                                <span class="truncate font-semibold text-zinc-900 dark:text-white">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs text-zinc-600 dark:text-zinc-400">@{{ auth()->user()->nip }}</span>
                                <span class="mt-1 inline-flex items-center rounded-full bg-blue-100 dark:bg-blue-900/30 px-2 py-0.5 text-xs font-medium text-blue-700 dark:text-blue-400">
                                    Administrator
                                </span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full text-red-600 dark:text-red-400">
                        Log Out
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{-- Main Content --}}
    <flux:main class="p-6">
        <div class="mb-6">
            <flux:heading size="xl" level="1" class="text-zinc-900 dark:text-white">
                Dashboard Admin
            </flux:heading>
            <flux:text class="mt-2 text-zinc-600 dark:text-zinc-400">
                Selamat datang kembali, {{ auth()->user()->name }}
            </flux:text>
        </div>
        
        <flux:separator variant="subtle" class="mb-6" />

        {{-- Content area untuk statistik, grafik, dll --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Card Total Guru --}}
            <div class="p-6 bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Total Guru</p>
                        <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">0</p>
                    </div>
                    <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Card Total Siswa --}}
            <div class="p-6 bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Total Siswa</p>
                        <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">0</p>
                    </div>
                    <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-full">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Card Total Kelas --}}
            <div class="p-6 bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Total Kelas</p>
                        <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">0</p>
                    </div>
                    <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-full">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Card Lulusan --}}
            <div class="p-6 bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Lulusan 2024</p>
                        <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">0</p>
                    </div>
                    <div class="p-3 bg-yellow-100 dark:bg-yellow-900/30 rounded-full">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </flux:main>

    {{-- Floating Theme Toggle Button --}}
    <div 
        x-data="{ 
            theme: localStorage.getItem('theme') || 'light',
            toggleTheme() {
                this.theme = this.theme === 'light' ? 'dark' : 'light';
                localStorage.setItem('theme', this.theme);
                document.documentElement.classList.toggle('dark', this.theme === 'dark');
            }
        }"
        class="fixed bottom-6 right-6 z-50"
    >
        <button 
            @click="toggleTheme()"
            class="flex items-center justify-center w-12 h-12 rounded-full bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 shadow-lg hover:shadow-xl transition-all hover:scale-110"
            :aria-label="theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'"
        >
            <svg x-show="theme === 'light'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
            <svg x-show="theme === 'dark'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        </button>
    </div>
    
    @fluxScripts
</body>
</html>