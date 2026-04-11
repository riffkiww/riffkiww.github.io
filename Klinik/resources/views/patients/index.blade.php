@extends('layouts.app')

@section('content')
    <section class="section-header">
        <div>
            <span class="eyebrow">Manajemen Pasien</span>
            <h1>Data Pasien</h1>
            <p>Tambah, ubah, lihat, dan hapus data pasien dari satu halaman.</p>
        </div>
        <a href="{{ route('patients.create') }}" class="button button-primary">Tambah Pasien</a>
    </section>

    <section class="content-card">
        <form method="GET" action="{{ route('patients.index') }}" class="search-bar">
            <input type="search" name="search" value="{{ $search }}" placeholder="Cari nomor RM, nama, atau telepon">
            <button type="submit" class="button button-secondary">Cari</button>
        </form>

        @if ($patients->count() === 0)
            <div class="empty-state">
                Tidak ada data pasien yang cocok.
            </div>
        @else
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No. RM</th>
                            <th>Nama Pasien</th>
                            <th>Gender</th>
                            <th>Umur</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patients as $patient)
                            <tr>
                                <td>{{ $patient->medical_record_number }}</td>
                                <td>
                                    <strong>{{ $patient->full_name }}</strong>
                                    <div class="muted-text">{{ $patient->phone ?? '-' }}</div>
                                </td>
                                <td>{{ $patient->gender }}</td>
                                <td>{{ $patient->age ?? '-' }}</td>
                                <td><span class="status-badge status-{{ strtolower($patient->status) }}">{{ $patient->status }}</span></td>
                                <td>
                                    <div class="action-group">
                                        <a href="{{ route('patients.show', $patient) }}" class="text-link">Detail</a>
                                        <a href="{{ route('patients.edit', $patient) }}" class="text-link">Edit</a>
                                        <form method="POST" action="{{ route('patients.destroy', $patient) }}" onsubmit="return confirm('Hapus data pasien ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-link danger-link">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pager">
                <span>Halaman {{ $patients->currentPage() }} dari {{ $patients->lastPage() }}</span>
                <div class="pager-actions">
                    @if ($patients->onFirstPage())
                        <span class="pager-link disabled">Sebelumnya</span>
                    @else
                        <a href="{{ $patients->previousPageUrl() }}" class="pager-link">Sebelumnya</a>
                    @endif

                    @if ($patients->hasMorePages())
                        <a href="{{ $patients->nextPageUrl() }}" class="pager-link">Berikutnya</a>
                    @else
                        <span class="pager-link disabled">Berikutnya</span>
                    @endif
                </div>
            </div>
        @endif
    </section>
@endsection