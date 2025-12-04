<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <!-- Floating sidebar styles -->
        <style>
            /* Ensure the layout supports a fixed, floating sidebar */
            html, body { height: 100%; }
            /* Content wrapper push — tune left padding to the sidebar width */
            .content-with-floating-sidebar { padding-left: 280px; }
            @media (max-width: 1024px) { /* lg breakpoint */
                .content-with-floating-sidebar { padding-left: 0; }
            }

            /* Improve scroll behavior inside sidebar */
            .sidebar-scroll { overscroll-behavior: contain; }
        </style>
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <!-- Floating Sidebar -->
        <flux:sidebar
            sticky
            stashable
            class="fixed left-0 top-0 z-40 h-screen w-[280px] overflow-y-auto border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 sidebar-scroll"
            aria-label="Floating navigation sidebar"
        >
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" aria-label="Close sidebar" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse px-4 py-3" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline" class="px-2">
                <flux:navlist.group :heading="__('Dashboard')" class="grid">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                </flux:navlist.group>

                {{-- Role-based menus --}}
                @php
                    $user = auth()->user();
                    $isAdmin = method_exists($user, 'hasRole') ? $user->hasRole('admin') : ($user->role ?? '') === 'admin';
                    $isGuru = method_exists($user, 'hasRole') ? $user->hasRole('guru') : ($user->role ?? '') === 'guru';

                    // Customize these helpers according to your domain logic
                    $guruTeachesMapel = method_exists($user, 'teachesMapel') ? $user->teachesMapel() : (bool)($user->guru_teaches_mapel ?? false);
                    $isWaliKelas = method_exists($user, 'isWaliKelas') ? $user->isWaliKelas() : (bool)($user->is_wali_kelas ?? false);
                @endphp

                {{-- Admin Menus --}}
                @if($isAdmin)
                    {{--<flux:navlist.group :heading="__('Manajemen Data Siswa')" class="grid">
                        <flux:navlist.item icon="user-plus" :href="route('students.create')" :current="request()->routeIs('students.create')" wire:navigate>{{ __('Input Data Siswa') }}</flux:navlist.item>
                        <flux:navlist.item icon="user-pen" :href="route('students.index')" :current="request()->routeIs('students.index')" wire:navigate>{{ __('Update Data Siswa') }}</flux:navlist.item>
                        <flux:navlist.item icon="arrow-up-narrow-wide" :href="route('students.promote')" :current="request()->routeIs('students.promote')" wire:navigate>{{ __('Kenaikan Kelas') }}</flux:navlist.item>
                        <flux:navlist.item icon="archive" :href="route('students.graduation')" :current="request()->routeIs('students.graduation')" wire:navigate>{{ __('Arsip Kelulusan') }}</flux:navlist.item>
                    </flux:navlist.group>

                    <flux:navlist.group :heading="__('Manajemen Kurikulum & Penugasan')" class="grid">
                        <flux:navlist.item icon="book-open" :href="route('subjects.index')" :current="request()->routeIs('subjects.*')" wire:navigate>{{ __('Data Mata Pelajaran & KKM') }}</flux:navlist.item>
                        <flux:navlist.item icon="users" :href="route('teaching.assignments')" :current="request()->routeIs('teaching.assignments')" wire:navigate>{{ __('Plotting Guru Pengampu') }}</flux:navlist.item>
                        <flux:navlist.item icon="shield-check" :href="route('homeroom.assignments')" :current="request()->routeIs('homeroom.assignments')" wire:navigate>{{ __('Plotting Wali Kelas') }}</flux:navlist.item>
                    </flux:navlist.group>

                    <flux:navlist.group :heading="__('Validasi & Monitoring')" class="grid">
                        <flux:navlist.item icon="circle-alert" :href="route('monitoring.missing-scores')" :current="request()->routeIs('monitoring.missing-scores')" wire:navigate>{{ __('Cek Kekosongan Nilai') }}</flux:navlist.item>
                        <flux:navlist.item icon="pencil-square" :href="route('scores.edit')" :current="request()->routeIs('scores.edit')" wire:navigate>{{ __('Koreksi Nilai') }}</flux:navlist.item>
                        <flux:navlist.item icon="chart-bar" :href="route('monitoring.analytics')" :current="request()->routeIs('monitoring.analytics')" wire:navigate>{{ __('Visualisasi Nilai & Absensi') }}</flux:navlist.item>
                    </flux:navlist.group>

                    <flux:navlist.group :heading="__('Laporan')" class="grid">
                        <flux:navlist.item icon="file-text" :href="route('reports.rapor')" :current="request()->routeIs('reports.rapor')" wire:navigate>{{ __('Rapor Siswa (PDF)') }}</flux:navlist.item>
                        <flux:navlist.item icon="table-cells" :href="route('reports.leger')" :current="request()->routeIs('reports.leger')" wire:navigate>{{ __('Leger Kelas') }}</flux:navlist.item>
                        <flux:navlist.item icon="trophy" :href="route('reports.ranking')" :current="request()->routeIs('reports.ranking')" wire:navigate>{{ __('Peringkat Kelas') }}</flux:navlist.item>
                        <flux:navlist.item icon="check-badge" :href="route('reports.kkm')" :current="request()->routeIs('reports.kkm')" wire:navigate>{{ __('Laporan Ketuntasan KKM') }}</flux:navlist.item>
                    </flux:navlist.group>--}}
                @endif

                {{-- Guru Menus --}}
                @if($isGuru)
                    <flux:navlist.group :heading="__('Tugas Guru')" class="grid">
                        @if($guruTeachesMapel)
                            <flux:navlist.item icon="calendar-days" :href="route('guru.classes')" :current="request()->routeIs('guru.classes')" wire:navigate>{{ __('Pilih Kelas Ajar') }}</flux:navlist.item>
                            <flux:navlist.item icon="user-check" :href="route('guru.attendance')" :current="request()->routeIs('guru.attendance')" wire:navigate>{{ __('Absensi Siswa per Pertemuan') }}</flux:navlist.item>
                            <flux:navlist.item icon="calculator" :href="route('guru.scores.input')" :current="request()->routeIs('guru.scores.input')" wire:navigate>{{ __('Input Nilai NH / UTS / UAS') }}</flux:navlist.item>
                        @endif

                        @if($isWaliKelas)
                            <flux:navlist.item icon="clipboard-document-list" :href="route('wali.monitoring')" :current="request()->routeIs('wali.monitoring')" wire:navigate>{{ __('Monitoring Rekap Nilai') }}</flux:navlist.item>
                            <flux:navlist.item icon="chat-bubble-left-right" :href="route('wali.notes')" :current="request()->routeIs('wali.notes')" wire:navigate>{{ __('Catatan Wali (Sikap/Spiritual/Prestasi)') }}</flux:navlist.item>
                            <flux:navlist.item icon="chart-pie" :href="route('wali.attendance')" :current="request()->routeIs('wali.attendance')" wire:navigate>{{ __('Rekap Absensi Akumulatif') }}</flux:navlist.item>
                            <flux:navlist.item icon="cpu-chip" :href="route('wali.calculator')" :current="request()->routeIs('wali.calculator')" wire:navigate>{{ __('Kalkulator Nilai Otomatis') }}</flux:navlist.item>
                            <flux:navlist.item icon="bell-alert" :href="route('wali.validation')" :current="request()->routeIs('wali.validation')" wire:navigate>{{ __('Validasi & Notifikasi Nilai Kosong') }}</flux:navlist.item>
                        @endif
                    </flux:navlist.group>

                    <flux:navlist.group :heading="__('Laporan')" class="grid">
                        @if($guruTeachesMapel)
                            <flux:navlist.item icon="document-text" :href="route('guru.reports.mapel')" :current="request()->routeIs('guru.reports.mapel')" wire:navigate>{{ __('Rekap Nilai per Mapel') }}</flux:navlist.item>
                        @endif
                        @if($isWaliKelas)
                            <flux:navlist.item icon="file-text" :href="route('wali.reports.rapor')" :current="request()->routeIs('wali.reports.rapor')" wire:navigate>{{ __('Rapor Siswa (PDF)') }}</flux:navlist.item>
                            <flux:navlist.item icon="table-cells" :href="route('wali.reports.leger')" :current="request()->routeIs('wali.reports.leger')" wire:navigate>{{ __('Leger Kelas') }}</flux:navlist.item>
                            <flux:navlist.item icon="trophy" :href="route('wali.reports.ranking')" :current="request()->routeIs('wali.reports.ranking')" wire:navigate>{{ __('Peringkat Kelas') }}</flux:navlist.item>
                            <flux:navlist.item icon="check-badge" :href="route('wali.reports.kkm')" :current="request()->routeIs('wali.reports.kkm')" wire:navigate>{{ __('Laporan Ketuntasan KKM') }}</flux:navlist.item>
                        @endif
                    </flux:navlist.group>
                @endif
            </flux:navlist>

            <flux:spacer />

            <flux:navlist variant="outline" class="px-2">
                <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                    {{ __('Repository') }}
                </flux:navlist.item>
                <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                    {{ __('Documentation') }}
                </flux:navlist.item>
            </flux:navlist>

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block px-2 pb-4" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                    data-test="sidebar-menu-button"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>
                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile Header -->
        <flux:header class="lg:hidden fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-zinc-800/80 backdrop-blur">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" aria-label="Open sidebar" />
            <flux:spacer />
            <flux:dropdown position="top" align="end">
                <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />
                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>
                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        <!-- Page content wrapper shifts to the right of floating sidebar on desktop -->
        <div class="content-with-floating-sidebar">
            {{ $slot }}
        </div>

        @fluxScripts
    </body>
</html>