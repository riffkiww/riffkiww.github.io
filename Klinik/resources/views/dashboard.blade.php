@extends('layouts.app')

@section('content')
    <section class="hero-card">
        <div>
            <span class="eyebrow">Website CRUD Data Pasien</span>
            <h1>Kelola data pasien klinik dengan tampilan yang bersih dan cepat dipakai.</h1>
            <p>
                Dashboard ini dibuat untuk tugas website pada konteks keamanan jaringan, dengan alur sederhana:
                akses internal, data pasien terstruktur, dan operasional CRUD yang mudah dipahami.
            </p>

            <div class="hero-actions">
                <a href="{{ route('patients.create') }}" class="button button-primary">Tambah Pasien</a>
                <a href="{{ route('patients.index') }}" class="button button-ghost">Lihat Data</a>
            </div>
        </div>

        <aside class="hero-panel">
            <div class="panel-chip">Status Sistem</div>
            <div class="panel-value">Operasional</div>
            <p>Siap untuk demo CRUD data pasien, cocok untuk presentasi tugas.</p>
        </aside>
    </section>

    <section class="stats-grid">
        <article class="stat-card">
            <span>Total Pasien</span>
            <strong>{{ $totalPatients }}</strong>
        </article>
        <article class="stat-card">
            <span>Pasien Aktif</span>
            <strong>{{ $activePatients }}</strong>
        </article>
        <article class="stat-card">
            <span>Baru Bulan Ini</span>
            <strong>{{ $newThisMonth }}</strong>
        </article>
    </section>

    <section class="content-card">
        <div class="section-head">
            <div>
                <span class="eyebrow">Data Terbaru</span>
                <h2>Rekam pasien terakhir</h2>
            </div>
            <a href="{{ route('patients.index') }}" class="text-link">Buka seluruh daftar</a>
        </div>

        @if ($latestPatients->isEmpty())
            <div class="empty-state">
                Belum ada data pasien. Tambahkan data pertama untuk mulai demo.
            </div>
        @else
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No. RM</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($latestPatients as $patient)
                            <tr>
                                <td>{{ $patient->medical_record_number }}</td>
                                <td>{{ $patient->full_name }}</td>
                                <td>{{ $patient->gender }}</td>
                                <td><span class="status-badge status-{{ strtolower($patient->status) }}">{{ $patient->status }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@endsection