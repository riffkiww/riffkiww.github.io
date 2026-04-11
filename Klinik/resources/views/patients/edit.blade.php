@extends('layouts.app')

@section('content')
    <section class="section-header">
        <div>
            <span class="eyebrow">Form Pasien</span>
            <h1>Edit Pasien</h1>
            <p>Perbarui data pasien yang sudah ada.</p>
        </div>
    </section>

    @include('patients.form', [
        'patient' => $patient,
        'action' => $action,
        'method' => $method,
        'title' => $title,
    ])
@endsection