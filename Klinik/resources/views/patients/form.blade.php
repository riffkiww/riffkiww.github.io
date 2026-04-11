<section class="content-card">
    <form method="POST" action="{{ $action }}" class="form-grid">
        @csrf
        @if ($method !== 'POST')
            @method($method)
        @endif

        <div class="field">
            <label for="medical_record_number">Nomor RM</label>
            <input id="medical_record_number" type="text" name="medical_record_number" value="{{ old('medical_record_number', $patient->medical_record_number) }}" placeholder="RM-000001">
        </div>

        <div class="field">
            <label for="full_name">Nama Lengkap</label>
            <input id="full_name" type="text" name="full_name" value="{{ old('full_name', $patient->full_name) }}" placeholder="Nama pasien">
        </div>

        <div class="field">
            <label for="gender">Jenis Kelamin</label>
            <select id="gender" name="gender">
                <option value="">Pilih gender</option>
                @foreach (['Laki-laki', 'Perempuan'] as $gender)
                    <option value="{{ $gender }}" @selected(old('gender', $patient->gender) === $gender)>{{ $gender }}</option>
                @endforeach
            </select>
        </div>

        <div class="field">
            <label for="age">Umur</label>
            <input id="age" type="number" name="age" min="0" max="120" value="{{ old('age', $patient->age) }}" placeholder="Contoh: 30">
        </div>

        <div class="field">
            <label for="phone">Telepon</label>
            <input id="phone" type="text" name="phone" value="{{ old('phone', $patient->phone) }}" placeholder="08xxxxxxxxxx">
        </div>

        <div class="field">
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="">Pilih status</option>
                @foreach (['Aktif', 'Selesai', 'Rujuk'] as $status)
                    <option value="{{ $status }}" @selected(old('status', $patient->status ?: 'Aktif') === $status)>{{ $status }}</option>
                @endforeach
            </select>
        </div>

        <div class="field field-wide">
            <label for="address">Alamat</label>
            <textarea id="address" name="address" rows="3" placeholder="Alamat pasien">{{ old('address', $patient->address) }}</textarea>
        </div>

        <div class="field field-wide">
            <label for="complaint">Keluhan</label>
            <textarea id="complaint" name="complaint" rows="4" placeholder="Keluhan utama pasien">{{ old('complaint', $patient->complaint) }}</textarea>
        </div>

        <div class="field field-wide">
            <label for="notes">Catatan</label>
            <textarea id="notes" name="notes" rows="3" placeholder="Catatan tambahan">{{ old('notes', $patient->notes) }}</textarea>
        </div>

        <div class="form-actions field-wide">
            <a href="{{ route('patients.index') }}" class="button button-ghost">Batal</a>
            <button type="submit" class="button button-primary">Simpan Data</button>
        </div>
    </form>
</section>