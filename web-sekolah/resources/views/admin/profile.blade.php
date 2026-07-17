@extends('layouts.admin')

@section('title', 'Edit Profil')
@section('page-title', 'Edit Profil Admin')

@section('styles')
<style>
    .form-card { background:#fff; border-radius:16px; box-shadow:0 4px 16px rgba(40,40,40,.06); overflow:hidden; }
    .form-card-header { display:flex; align-items:center; gap:.75rem; padding:1.1rem 1.5rem; border-bottom:1px solid #f1f5f9; }
    .form-card-header .hico { width:36px; height:36px; border-radius:10px; display:grid; place-items:center; font-size:1rem; flex-shrink:0; }
    .form-card-header h6 { font-size:.9rem; font-weight:600; color:var(--primary-dark); margin:0; }
    .form-card-body { padding:1.5rem; }
    .form-label { font-size:.82rem; font-weight:500; color:#374151; margin-bottom:.35rem; }
    .form-control { font-size:.85rem; border-radius:10px; border-color:#e2e8f0; }
    .form-control:focus { border-color:var(--accent); box-shadow:none; }

    .avatar-preview {
        width: 110px; height: 110px; border-radius: 50%;
        object-fit: cover; border: 3px solid var(--accent-soft);
    }
    .avatar-initials {
        width: 110px; height: 110px; border-radius: 50%;
        background: var(--accent); color:#fff; font-weight:700; font-size:2.4rem;
        display: grid; place-items: center;
    }
    .upload-zone {
        border: 2px dashed #cbd5e1; border-radius: 12px; padding: 1rem;
        text-align: center; cursor: pointer; transition: all .2s ease; background: #f8fafc;
    }
    .upload-zone:hover { border-color: var(--accent); background: var(--accent-soft); }
    .upload-zone input { display: none; }
    .upload-zone p { font-size: .82rem; color: var(--primary); margin: 0; font-weight: 500; }
    .upload-zone small { font-size: .72rem; color: #756d66; }
</style>
@endsection

@section('content')

<div class="mb-3">
    <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-light" style="border-radius:8px;font-size:.82rem;">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" style="font-size:.85rem;">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-4">

    {{-- ── Data Akun ── --}}
    <div class="col-lg-7">
        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-card mb-4">
                <div class="form-card-header">
                    <div class="hico" style="background:#dbeafe;color:#1d4ed8;"><i class="bi bi-person-badge-fill"></i></div>
                    <h6>Data Akun</h6>
                </div>
                <div class="form-card-body">

                    {{-- Avatar --}}
                    <div class="d-flex align-items-center gap-4 mb-4 flex-wrap">
                        @if ($user->avatarUrl())
                            <img id="avatarPreview" src="{{ $user->avatarUrl() }}" alt="Avatar" class="avatar-preview">
                        @else
                            <div id="avatarInitials" class="avatar-initials">{{ $user->initials() }}</div>
                            <img id="avatarPreview" src="" alt="Avatar" class="avatar-preview" style="display:none;">
                        @endif

                        <div class="flex-grow-1" style="min-width:200px;">
                            <label class="upload-zone" for="avatarInput">
                                <input type="file" name="avatar" id="avatarInput" accept="image/*">
                                <i class="bi bi-cloud-upload-fill" style="font-size:1.4rem;color:var(--primary);"></i>
                                <p>Klik untuk mengganti foto</p>
                                <small>JPG / PNG / WEBP — maks. 2 MB</small>
                            </label>
                            @error('avatar') <div class="text-danger mt-1" style="font-size:.8rem;">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    @if ($user->hasAvatar())
                        <div class="mb-3 text-end">
                            <button type="submit" form="formHapusAvatar" class="btn btn-sm btn-outline-danger"
                                style="border-radius:8px;font-size:.78rem;">
                                <i class="bi bi-trash me-1"></i> Hapus Avatar
                            </button>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}" required maxlength="255">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}" required maxlength="255">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="form-label">Nomor HP</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone', $user->phone) }}" maxlength="30" placeholder="08xxxxxxxxxx">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-sm py-2"
                    style="background:var(--primary);color:#fff;border-radius:10px;font-size:.85rem;font-weight:500;">
                    <i class="bi bi-floppy-fill me-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>

        {{-- form tersembunyi untuk hapus avatar --}}
        <form id="formHapusAvatar" method="POST" action="{{ route('admin.profile.avatar.delete') }}" class="d-none">
            @csrf
            @method('DELETE')
        </form>
    </div>

    {{-- ── Ganti Password ── --}}
    <div class="col-lg-5">
        <form method="POST" action="{{ route('admin.profile.password') }}">
            @csrf
            @method('PUT')

            <div class="form-card mb-4">
                <div class="form-card-header">
                    <div class="hico" style="background:#fee2e2;color:#dc2626;"><i class="bi bi-shield-lock-fill"></i></div>
                    <h6>Ganti Password</h6>
                </div>
                <div class="form-card-body">
                    <div class="mb-3">
                        <label class="form-label">Password Saat Ini <span class="text-danger">*</span></label>
                        <input type="password" name="current_password"
                               class="form-control @error('current_password') is-invalid @enderror" required>
                        @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password Baru <span class="text-danger">*</span></label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <small class="text-muted" style="font-size:.72rem;">Minimal 8 karakter.</small>
                    </div>

                    <div>
                        <label class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-sm py-2"
                    style="background:#dc2626;color:#fff;border-radius:10px;font-size:.85rem;font-weight:500;">
                    <i class="bi bi-key-fill me-1"></i> Perbarui Password
                </button>
            </div>
        </form>
    </div>

</div>

@endsection

@section('scripts')
<script>
    document.getElementById('avatarInput')?.addEventListener('change', function () {
        const file = this.files[0];
        const prev = document.getElementById('avatarPreview');
        const initials = document.getElementById('avatarInitials');
        if (file && prev) {
            prev.src = URL.createObjectURL(file);
            prev.style.display = 'block';
            if (initials) initials.style.display = 'none';
        }
    });
</script>
@endsection
