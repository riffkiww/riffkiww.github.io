@extends('layouts.app')

@section('content')
    <section class="section-header">
        <div>
            <span class="eyebrow">Detail Pasien</span>
            <h1>{{ $patient->full_name }}</h1>
            <p>No. RM {{ $patient->medical_record_number }}</p>
        </div>
        <div class="hero-actions">
            <a href="{{ route('patients.edit', $patient) }}" class="button button-primary">Edit</a>
            <a href="{{ route('patients.index') }}" class="button button-ghost">Kembali</a>
        </div>
    </section>

    <section class="content-card detail-grid">
        <div class="detail-item">
            <span>No. Rekam Medis</span>
            <strong>{{ $patient->medical_record_number }}</strong>
        </div>
        <div class="detail-item">
            <span>Nama Lengkap</span>
            <strong>{{ $patient->full_name }}</strong>
        </div>
        <div class="detail-item">
            <span>Jenis Kelamin</span>
            <strong>{{ $patient->gender }}</strong>
        </div>
        <div class="detail-item">
            <span>Umur</span>
            <strong>{{ $patient->age ?? '-' }}</strong>
        </div>
        <div class="detail-item">
            <span>Telepon</span>
            <strong>{{ $patient->phone ?? '-' }}</strong>
        </div>
        <div class="detail-item">
            <span>Status</span>
            <strong><span class="status-badge status-{{ strtolower($patient->status) }}">{{ $patient->status }}</span></strong>
        </div>
        <div class="detail-item detail-wide">
            <span>Alamat</span>
            <strong>{{ $patient->address ?? '-' }}</strong>
        </div>
        <div class="detail-item detail-wide">
            <span>Keluhan</span>
            <strong>{{ $patient->complaint }}</strong>
        </div>
        <div class="detail-item detail-wide">
            <span>Catatan</span>
            <strong>{{ $patient->notes ?? '-' }}</strong>
        </div>
    </section>
@endsection