@extends('layouts.admin')

@section('title', 'Kelola Kurikulum')
@section('page-title', 'Kurikulum')

@section('styles')
<style>
    .form-card { background:#fff; border-radius:16px; box-shadow:0 4px 16px rgba(40,40,40,.06); overflow:hidden; margin-bottom:1.25rem; }
    .form-card-header { display:flex; align-items:center; gap:.75rem; padding:1.1rem 1.5rem; border-bottom:1px solid #f1f5f9; }
    .form-card-header .hico { width:36px; height:36px; border-radius:10px; display:grid; place-items:center; font-size:1rem; flex-shrink:0; }
    .form-card-header h6 { font-size:.9rem; font-weight:600; color:var(--primary-dark); margin:0; }
    .form-card-header p  { font-size:.75rem; color:#756d66; margin:0; }
    .form-card-body { padding:1.5rem; }
    .form-label { font-size:.82rem; font-weight:500; color:#374151; margin-bottom:.35rem; }
    .form-control, .form-select { font-size:.85rem; border-radius:10px; border-color:#e2e8f0; }
    .form-control:focus, .form-select:focus { border-color:var(--accent); box-shadow:none; }

    /* ── BLOCK ROWS ── */
    .blk-row {
        background:#f8fafc;
        border:1px solid #e2e8f0;
        border-radius:12px;
        padding:.9rem 1rem;
        position:relative;
    }
    .blk-row + .blk-row { margin-top:.75rem; }
    .blk-row-head { display:flex; align-items:flex-end; gap:.6rem; flex-wrap:wrap; margin-bottom:.6rem; }
    .blk-row-head .blk-tipe { width:auto; min-width:210px; }
    .blk-start-wrap { width:120px; }
    .blk-start-wrap .form-label { white-space:nowrap; }
    .blk-actions { display:flex; gap:.3rem; margin-left:auto; }
    .blk-btn {
        width:30px; height:30px; border:none; border-radius:8px; cursor:pointer;
        display:grid; place-items:center; font-size:.85rem; background:#e2e8f0; color:#475569;
    }
    .blk-btn:hover { background:#cbd5e1; }
    .blk-btn.danger { background:#fee2e2; color:#dc2626; }
    .blk-btn.danger:hover { background:#fecaca; }
    .blk-hint { font-size:.72rem; color:#756d66; margin-top:.4rem; }

    .add-row-btn {
        margin-top:.85rem;
        background:var(--accent-soft);
        border:1.5px dashed var(--accent);
        color:var(--primary);
        font-size:.82rem; font-weight:600;
        padding:.55rem 1rem; border-radius:10px; cursor:pointer;
        transition:background .2s; width:100%;
    }
    .add-row-btn:hover { background:#d1fae5; }
    .blk-empty { text-align:center; color:#756d66; font-size:.85rem; padding:1.5rem 0; }
</style>
@endsection

@section('content')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" style="font-size:.85rem;">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <p class="text-muted mb-0" style="font-size:.82rem;">
        Atur isi halaman <strong>Akademik &rsaquo; Kurikulum</strong> yang tampil di situs publik.
    </p>
    <a href="{{ route('akademik.kurikulum') }}" target="_blank" class="btn btn-sm btn-light" style="border-radius:8px;font-size:.8rem;">
        <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Halaman
    </a>
</div>

<form method="POST" action="{{ route('admin.kurikulum.update') }}">
    @csrf @method('PUT')

    {{-- Judul --}}
    <div class="form-card">
        <div class="form-card-header">
            <div class="hico" style="background:#dbeafe;color:#1d4ed8;"><i class="bi bi-type-h1"></i></div>
            <div><h6>Judul Kurikulum</h6><p>Tampil sebagai kepala kartu di halaman Kurikulum</p></div>
        </div>
        <div class="form-card-body">
            <input type="text" name="judul"
                   class="form-control @error('judul') is-invalid @enderror"
                   value="{{ old('judul', $setting->judul) }}"
                   maxlength="200" placeholder="KURIKULUM SDN DADAPSARI SEMARANG">
            @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    {{-- Blok Konten --}}
    <div class="form-card">
        <div class="form-card-header">
            <div class="hico" style="background:#dcfce7;color:#16a34a;"><i class="bi bi-layout-text-window-reverse"></i></div>
            <div>
                <h6>Isi Konten</h6>
                <p>Susun konten per blok. Gunakan tombol panah untuk mengubah urutan tampil.</p>
            </div>
        </div>
        <div class="form-card-body">

            @php
                $tipeOptions = [
                    'paragraf' => 'Paragraf',
                    'subjudul' => 'Subjudul',
                    'ol'       => 'Daftar Bernomor (1, 2, 3…)',
                    'ul'       => 'Daftar Poin (•)',
                ];

                // Susun baris dari old() (jika validasi gagal) atau dari data tersimpan.
                if (old('blok_tipe') !== null) {
                    $rows = [];
                    foreach (old('blok_tipe', []) as $i => $t) {
                        $rows[] = [
                            'tipe'  => $t,
                            'isi'   => old('blok_isi')[$i] ?? '',
                            'start' => old('blok_start')[$i] ?? '',
                        ];
                    }
                } else {
                    $rows = [];
                    foreach (($setting->blok ?? []) as $b) {
                        $t = $b['tipe'] ?? 'paragraf';
                        $rows[] = [
                            'tipe'  => $t,
                            'isi'   => in_array($t, ['ol', 'ul']) ? implode("\n", $b['item'] ?? []) : ($b['isi'] ?? ''),
                            'start' => $b['start'] ?? '',
                        ];
                    }
                }
            @endphp

            <div id="blok-list">
                @foreach ($rows as $row)
                    <div class="blk-row">
                        <div class="blk-row-head">
                            <div>
                                <label class="form-label">Jenis Blok</label>
                                <select name="blok_tipe[]" class="form-select form-select-sm blk-tipe" onchange="onTipeChange(this)">
                                    @foreach ($tipeOptions as $val => $lbl)
                                        <option value="{{ $val }}" {{ $row['tipe'] === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="blk-start-wrap" style="{{ $row['tipe'] === 'ol' ? '' : 'display:none;' }}">
                                <label class="form-label">Nomor awal</label>
                                <input type="number" name="blok_start[]" class="form-control form-control-sm"
                                       min="1" value="{{ $row['start'] }}" placeholder="1">
                            </div>
                            <div class="blk-actions">
                                <button type="button" class="blk-btn" onclick="moveBlock(this,-1)" title="Naikkan"><i class="bi bi-arrow-up"></i></button>
                                <button type="button" class="blk-btn" onclick="moveBlock(this,1)" title="Turunkan"><i class="bi bi-arrow-down"></i></button>
                                <button type="button" class="blk-btn danger" onclick="removeBlock(this)" title="Hapus"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                        <textarea name="blok_isi[]" class="form-control blk-isi" rows="3" maxlength="5000">{{ $row['isi'] }}</textarea>
                        <div class="blk-hint"></div>
                    </div>
                @endforeach
            </div>

            <div class="blk-empty" id="blok-empty" style="{{ count($rows) ? 'display:none;' : '' }}">
                Belum ada blok konten. Klik tombol di bawah untuk menambah.
            </div>

            <button type="button" class="add-row-btn" onclick="addBlock()">
                <i class="bi bi-plus-lg me-1"></i> Tambah Blok
            </button>
        </div>
    </div>

    {{-- Save (sticky) --}}
    <div style="position:sticky;bottom:1rem;z-index:10;display:flex;justify-content:flex-end;padding:.75rem 0;">
        <button type="submit" class="btn py-2 px-4"
            style="background:var(--primary);color:#fff;border-radius:12px;font-size:.9rem;font-weight:600;
                   box-shadow:0 4px 16px rgba(40,40,40,.25);">
            <i class="bi bi-floppy-fill me-2"></i>Simpan Perubahan
        </button>
    </div>

</form>

@endsection

@section('scripts')
<script>
    var TIPE_OPTIONS = @json($tipeOptions);

    // Sesuaikan tampilan satu baris berdasarkan jenis blok yang dipilih.
    function updateRowUI(row) {
        var tipe = row.querySelector('.blk-tipe').value;
        var ta = row.querySelector('.blk-isi');
        var startWrap = row.querySelector('.blk-start-wrap');
        var hint = row.querySelector('.blk-hint');

        startWrap.style.display = (tipe === 'ol') ? '' : 'none';

        if (tipe === 'paragraf') {
            ta.placeholder = 'Tulis isi paragraf…';
            ta.rows = 3;
            hint.textContent = 'Tampil sebagai paragraf biasa.';
        } else if (tipe === 'subjudul') {
            ta.placeholder = 'Tulis teks subjudul…';
            ta.rows = 1;
            hint.textContent = 'Tampil sebagai judul bagian (tebal).';
        } else {
            ta.placeholder = 'Tulis satu item per baris…';
            ta.rows = 4;
            hint.textContent = 'Setiap baris menjadi satu item daftar.';
        }
    }

    function onTipeChange(select) {
        updateRowUI(select.closest('.blk-row'));
    }

    function refreshEmptyState() {
        var hasRows = document.querySelectorAll('#blok-list .blk-row').length > 0;
        document.getElementById('blok-empty').style.display = hasRows ? 'none' : '';
    }

    function blockRowHtml() {
        var opts = '';
        for (var val in TIPE_OPTIONS) {
            opts += '<option value="' + val + '">' + TIPE_OPTIONS[val] + '</option>';
        }
        return '<div class="blk-row">' +
            '<div class="blk-row-head">' +
                '<div><label class="form-label">Jenis Blok</label>' +
                '<select name="blok_tipe[]" class="form-select form-select-sm blk-tipe" onchange="onTipeChange(this)">' + opts + '</select></div>' +
                '<div class="blk-start-wrap" style="display:none;"><label class="form-label">Nomor awal</label>' +
                '<input type="number" name="blok_start[]" class="form-control form-control-sm" min="1" placeholder="1"></div>' +
                '<div class="blk-actions">' +
                    '<button type="button" class="blk-btn" onclick="moveBlock(this,-1)" title="Naikkan"><i class="bi bi-arrow-up"></i></button>' +
                    '<button type="button" class="blk-btn" onclick="moveBlock(this,1)" title="Turunkan"><i class="bi bi-arrow-down"></i></button>' +
                    '<button type="button" class="blk-btn danger" onclick="removeBlock(this)" title="Hapus"><i class="bi bi-trash"></i></button>' +
                '</div>' +
            '</div>' +
            '<textarea name="blok_isi[]" class="form-control blk-isi" rows="3" maxlength="5000"></textarea>' +
            '<div class="blk-hint"></div>' +
        '</div>';
    }

    function addBlock() {
        var list = document.getElementById('blok-list');
        list.insertAdjacentHTML('beforeend', blockRowHtml());
        var row = list.lastElementChild;
        updateRowUI(row);
        refreshEmptyState();
        row.querySelector('.blk-isi').focus();
    }

    function removeBlock(btn) {
        btn.closest('.blk-row').remove();
        refreshEmptyState();
    }

    function moveBlock(btn, dir) {
        var row = btn.closest('.blk-row');
        if (dir < 0 && row.previousElementSibling) {
            row.parentNode.insertBefore(row, row.previousElementSibling);
        } else if (dir > 0 && row.nextElementSibling) {
            row.parentNode.insertBefore(row.nextElementSibling, row);
        }
    }

    // Inisialisasi tampilan untuk baris yang sudah dirender server.
    document.querySelectorAll('#blok-list .blk-row').forEach(updateRowUI);
</script>
@endsection
