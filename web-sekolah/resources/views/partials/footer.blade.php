@php
    $f = \App\Models\FooterSetting::getData();
@endphp

<footer class="footer">
    <div class="footer-grid">
        <div class="footer-col footer-brand">
            <div class="logo">
                <span class="logo-mark">SD</span>
                <span class="logo-text"><strong>{{ $f->nama_sekolah }}</strong></span>
            </div>
            <p>{{ $f->deskripsi }}</p>
        </div>

        <div class="footer-col">
            <h4>Tautan Cepat</h4>
            <ul>
                <li><a href="{{ route('home') }}#profil">Profil Sekolah</a></li>
                <li><a href="{{ route('home') }}#akademik">Akademik</a></li>
                <li><a href="{{ route('informasi.index') }}">Berita &amp; Pengumuman</a></li>
                <li><a href="{{ route('ppdb.index') }}">PPDB</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Kontak</h4>
            <ul>
                @if ($f->alamat)
                    <li>📍 {{ $f->alamat }}</li>
                @endif
                @if ($f->telepon)
                    <li>📞 {{ $f->telepon }}</li>
                @endif
                @if ($f->email)
                    <li>✉️ {{ $f->email }}</li>
                @endif
            </ul>
        </div>

        <div class="footer-col">
            <h4>Jam Operasional</h4>
            <ul>
                @if ($f->jam_weekday)
                    <li>Senin – Jumat: {{ $f->jam_weekday }}</li>
                @endif
                @if ($f->jam_sabtu)
                    <li>Sabtu: {{ $f->jam_sabtu }}</li>
                @endif
                <li>Minggu &amp; Libur: Tutup</li>
            </ul>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} {{ $f->copyright }}</p>
    </div>
</footer>
