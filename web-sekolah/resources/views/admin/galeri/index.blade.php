@extends('layouts.admin')

@section('title', 'Kelola Galeri Foto')
@section('page-title', 'Galeri Foto')

@section('styles')
    <style>
        .galeri-admin-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 1rem;
            padding: 1.25rem;
        }

        .galeri-admin-item {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            transition: box-shadow .2s ease;
        }

        .galeri-admin-item:hover {
            box-shadow: 0 6px 20px rgba(0, 43, 91, .12);
        }

        .galeri-admin-thumb {
            aspect-ratio: 4 / 3;
            width: 100%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            display: grid;
            place-items: center;
            font-size: 2.5rem;
            position: relative;
            overflow: hidden;
        }

        .galeri-admin-thumb img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .galeri-admin-status {
            position: absolute;
            top: .5rem;
            right: .5rem;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            border: 2px solid #fff;
        }

        .galeri-admin-body {
            padding: .75rem;
        }

        .galeri-admin-title {
            font-size: .8rem;
            font-weight: 600;
            color: var(--primary-dark);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: .25rem;
        }

        .galeri-admin-actions {
            display: flex;
            gap: .35rem;
            margin-top: .5rem;
        }
    </style>
@endsection

@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" style="font-size:.85rem;">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="section-card">
        <div class="section-header">
            <h6><i class="bi bi-images me-2 text-info"></i>Daftar Foto ({{ $galeri->total() }})</h6>
            <a href="{{ route('admin.galeri.create') }}" class="btn btn-sm"
                style="background:var(--primary);color:#fff;border-radius:8px;font-size:.8rem;">
                <i class="bi bi-plus-lg me-1"></i> Upload Foto
            </a>
        </div>

        @if ($galeri->isEmpty())
            <div class="p-5 text-center text-muted">
                <i class="bi bi-images" style="font-size:2.5rem;opacity:.3;"></i>
                <p class="mt-2 mb-0" style="font-size:.9rem;">Belum ada foto. Klik "Upload Foto" untuk mulai.</p>
            </div>
        @else
            <div class="galeri-admin-grid">
                @foreach ($galeri as $item)
                    <div class="galeri-admin-item">
                        <div class="galeri-admin-thumb">
                            @if ($item->gambarUrl())
                                <img src="{{ $item->gambarUrl() }}" alt="{{ $item->judul }}">
                            @else
                                <span>📷</span>
                            @endif
                            <div class="galeri-admin-status"
                                style="background:{{ $item->is_active ? '#22c55e' : '#ef4444' }};"></div>
                        </div>
                        <div class="galeri-admin-body">
                            <div class="galeri-admin-title" title="{{ $item->judul }}">{{ $item->judul }}</div>
                            @if ($item->kategori)
                                <span
                                    style="font-size:.7rem;color:var(--primary);background:var(--accent-soft);
                                padding:.1rem .5rem;border-radius:50px;">{{ $item->kategori }}</span>
                            @endif
                            <div class="galeri-admin-actions">
                                <a href="{{ route('admin.galeri.edit', $item) }}"
                                    class="btn btn-sm btn-light flex-fill text-center"
                                    style="font-size:.72rem;border-radius:6px;padding:.25rem;">
                                    <i class="bi bi-pencil-fill"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('admin.galeri.toggle', $item) }}" class="flex-fill">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-light w-100"
                                        style="font-size:.72rem;border-radius:6px;padding:.25rem;
                                        color:{{ $item->is_active ? '#ca8a04' : '#15803d' }};">
                                        <i class="bi bi-{{ $item->is_active ? 'eye-slash' : 'eye' }}-fill"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.galeri.destroy', $item) }}"
                                    onsubmit="return confirm('Hapus foto ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light"
                                        style="font-size:.72rem;border-radius:6px;padding:.25rem;color:#dc2626;">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if ($galeri->hasPages())
                <div class="p-3">{{ $galeri->links() }}</div>
            @endif
        @endif
    </div>

@endsection
