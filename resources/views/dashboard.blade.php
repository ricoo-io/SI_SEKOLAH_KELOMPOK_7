<x-layouts.app :title="__('Dashboard')">
    @php
        // Dummy role detection (sesuaikan dengan implementasi nyata Anda)
        $user = auth()->user();
        $isAdmin = method_exists($user, 'hasRole') ? $user->hasRole('admin') : (($user->role ?? '') === 'admin');
        $isGuru = method_exists($user, 'hasRole') ? $user->hasRole('guru') : (($user->role ?? '') === 'guru');

        // Dummy flags untuk guru (sementara)
        $guruTeachesMapel = method_exists($user, 'teachesMapel') ? $user->teachesMapel() : true; // anggap guru mengajar mapel
        $isWaliKelas = method_exists($user, 'isWaliKelas') ? $user->isWaliKelas() : true; // anggap juga wali kelas

        // Data dummy ringkasan (ganti dengan query nyata nanti)
        $stat = [
            'siswa' => 320,
            'kelas' => 12,
            'mapel' => 15,
            'nilaiBelumLengkap' => 28,
            'absensiHariIni' => 96,
        ];
    @endphp

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Kartu ringkasan -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <!-- Ringkasan 1 -->
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
                <div class="flex h-full w-full items-center justify-between">
                    <div>
                        <div class="text-sm text-neutral-500 dark:text-neutral-400">Siswa Terdaftar</div>
                        <div class="mt-1 text-3xl font-semibold">{{ $stat['siswa'] ?? '—' }}</div>
                    </div>
                    <x-icon name="users" class="size-10 text-neutral-400" />
                </div>
            </div>

            <!-- Ringkasan 2 -->
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
                <div class="flex h-full w-full items-center justify-between">
                    <div>
                        <div class="text-sm text-neutral-500 dark:text-neutral-400">Kelas Aktif</div>
                        <div class="mt-1 text-3xl font-semibold">{{ $stat['kelas'] ?? '—' }}</div>
                    </div>
                    <x-icon name="building-library" class="size-10 text-neutral-400" />
                </div>
            </div>

            <!-- Ringkasan 3 -->
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
                <div class="flex h-full w-full items-center justify-between">
                    <div>
                        <div class="text-sm text-neutral-500 dark:text-neutral-400">Mata Pelajaran</div>
                        <div class="mt-1 text-3xl font-semibold">{{ $stat['mapel'] ?? '—' }}</div>
                    </div>
                    <x-icon name="book-open" class="size-10 text-neutral-400" />
                </div>
            </div>
        </div>

        <!-- Panel utama: berbeda per peran -->
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
            @if($isAdmin)
                <div class="grid gap-4 md:grid-cols-2">
                    <!-- Validasi & Monitoring -->
                    <div class="rounded-lg border border-neutral-200 dark:border-neutral-700 p-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold">Validasi & Monitoring</h3>
                            <x-icon name="chart-bar" class="size-6 text-neutral-400" />
                        </div>
                        <ul class="mt-3 space-y-2 text-sm">
                            <li class="flex items-center justify-between">
                                <span>Nilai belum lengkap</span>
                                <span class="font-semibold">{{ $stat['nilaiBelumLengkap'] ?? '—' }}</span>
                            </li>
                        </ul>
                        <div class="mt-4 flex gap-2">
                            {{-- <a class="btn btn-primary" href="{{ route('monitoring.missing-scores') }}" wire:navigate>Cek Kekosongan</a> --}}
                            {{--<a class="btn btn-outline" href="{{ route('monitoring.analytics') }}" wire:navigate>Visualisasi</a> --}}
                        </div>
                    </div>

                    <!-- Manajemen -->
                    <div class="rounded-lg border border-neutral-200 dark:border-neutral-700 p-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold">Manajemen</h3>
                            <x-icon name="cog-6-tooth" class="size-6 text-neutral-400" />
                        </div>
                        <div class="mt-3 grid gap-2 sm:grid-cols-2">
                            {{-- <a class="btn btn-outline w-full" href="{{ route('students.create') }}" wire:navigate>Input Data Siswa</a> --}}
                            {{--<a class="btn btn-outline w-full" href="{{ route('students.promote') }}" wire:navigate>Kenaikan Kelas</a>--}}
                           {{-- <a class="btn btn-outline w-full" href="{{ route('subjects.index') }}" wire:navigate>Data Mapel & KKM</a>--}}
                           {{-- <a class="btn btn-outline w-full" href="{{ route('homeroom.assignments') }}" wire:navigate>Plot Wali Kelas</a>--}}
                        </div>
                    </div>

                    <!-- Laporan -->
                    <div class="rounded-lg border border-neutral-200 dark:border-neutral-700 p-4 md:col-span-2">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold">Laporan</h3>
                            <x-icon name="document-text" class="size-6 text-neutral-400" />
                        </div>
                        <div class="mt-3 flex flex-wrap gap-2">
                            {{--<a class="btn btn-outline" href="{{ route('reports.rapor') }}" wire:navigate>Rapor (PDF)</a>--}}
                           {{-- <a class="btn btn-outline" href="{{ route('reports.leger') }}" wire:navigate>Leger Kelas</a>--}}
                            {{--<a class="btn btn-outline" href="{{ route('reports.ranking') }}" wire:navigate>Peringkat</a>--}}
                           {{-- <a class="btn btn-outline" href="{{ route('reports.kkm') }}" wire:navigate>Ketuntasan KKM</a>--}}
                        </div>
                    </div>
                </div>
            @elseif($isGuru)
                <div class="grid gap-4 md:grid-cols-2">
                    <!-- Absensi & Nilai untuk Guru Mapel -->
                    @if($guruTeachesMapel)
                        <div class="rounded-lg border border-neutral-200 dark:border-neutral-700 p-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold">Guru Mapel</h3>
                                <x-icon name="calculator" class="size-6 text-neutral-400" />
                            </div>
                            <ul class="mt-3 space-y-2 text-sm">
                                <li class="flex items-center justify-between">
                                    <span>Absensi hari ini</span>
                                    <span class="font-semibold">{{ $stat['absensiHariIni'] ?? '—' }}</span>
                                </li>
                            </ul>
                            <div class="mt-4 flex flex-wrap gap-2">
                                <a class="btn btn-primary" href="{{ route('guru.classes') }}" wire:navigate>Pilih Kelas Ajar</a>
                                <a class="btn btn-outline" href="{{ route('guru.attendance') }}" wire:navigate>Absensi Pertemuan</a>
                                <a class="btn btn-outline" href="{{ route('guru.scores.input') }}" wire:navigate>Input NH/UTS/UAS</a>
                                <a class="btn btn-outline" href="{{ route('guru.reports.mapel') }}" wire:navigate>Rekap Nilai Mapel</a>
                            </div>
                        </div>
                    @endif

                    <!-- Panel Wali Kelas -->
                    @if($isWaliKelas)
                        <div class="rounded-lg border border-neutral-200 dark:border-neutral-700 p-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold">Wali Kelas</h3>
                                <x-icon name="clipboard-document-list" class="size-6 text-neutral-400" />
                            </div>
                            <div class="mt-3 grid gap-2 sm:grid-cols-2">
                                <a class="btn btn-outline w-full" href="{{ route('wali.monitoring') }}" wire:navigate>Monitoring Nilai</a>
                                <a class="btn btn-outline w-full" href="{{ route('wali.attendance') }}" wire:navigate>Rekap Absensi</a>
                                <a class="btn btn-outline w-full" href="{{ route('wali.notes') }}" wire:navigate>Catatan Wali</a>
                                <a class="btn btn-outline w-full" href="{{ route('wali.validation') }}" wire:navigate>Validasi Nilai Kosong</a>
                            </div>
                            <div class="mt-4 flex flex-wrap gap-2">
                                <a class="btn btn-outline" href="{{ route('wali.reports.rapor') }}" wire:navigate>Rapor (PDF)</a>
                                <a class="btn btn-outline" href="{{ route('wali.reports.leger') }}" wire:navigate>Leger Kelas</a>
                                <a class="btn btn-outline" href="{{ route('wali.reports.ranking') }}" wire:navigate>Peringkat</a>
                                <a class="btn btn-outline" href="{{ route('wali.reports.kkm') }}" wire:navigate>Ketuntasan KKM</a>
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <div class="h-full grid place-items-center">
                    <p class="text-neutral-600 dark:text-neutral-300 text-sm">Tidak ada peran yang dikenali. Hubungi Administrator.</p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>