@extends('layouts.app')

@section('content')
    <section class="section-header">
        <div>
            <span class="eyebrow">Form Pasien</span>
            <h1>Tambah Pasien</h1>
            <p>Masukkan data pasien baru ke dalam sistem.</p>
        </div>
    </section>

    @include('patients.form', [
        'patient' => $patient,
        'action' => $action,
        'method' => $method,
        'title' => $title,
    ])
@endsection