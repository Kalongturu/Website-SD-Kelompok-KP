# Deploy ke Vercel

Panduan deploy website sekolah ini ke Vercel. **Pengembangan lokal tetap berjalan
seperti biasa** (`php artisan serve` / XAMPP) — konfigurasi di sini hanya aktif
saat berjalan di Vercel.

---

## 1. Cara kerjanya

| Berkas | Fungsi |
|---|---|
| `api/index.php` | Entry point khusus Vercel. Mengarahkan storage ke `/tmp`, lalu memanggil `public/index.php`. |
| `vercel.json` | Runtime PHP, routing, dan env var yang tidak rahasia. |
| `.vercelignore` | Menahan `.env`, `node_modules`, dan `tests` agar tidak ikut terupload. |

Lokal memakai `public/index.php` seperti biasa dan **tidak menyentuh** `api/index.php`.

**Kenapa storage diarahkan ke `/tmp`?** Filesystem Vercel bersifat *read-only*
kecuali `/tmp`, sedangkan Laravel perlu menulis cache view Blade. Karena Laravel 12
mendukung `LARAVEL_STORAGE_PATH`, seluruh `storage_path()` dialihkan ke `/tmp`.

Aset CSS/JS di proyek ini adalah file statis biasa di `public/`, **bukan** Vite —
jadi tidak ada langkah `npm run build` saat deploy.

---

## 2. Pengaturan proyek di Vercel

Saat import repo dari GitHub:

| Pengaturan | Nilai |
|---|---|
| **Root Directory** | **`web-sekolah`** ← WAJIB, karena aplikasi Laravel ada di subfolder |
| Framework Preset | **Other** |
| Build / Output / Install Command | kosongkan semua |

Kalau Root Directory tidak diisi `web-sekolah`, Vercel tidak akan menemukan
`vercel.json` dan deploy-nya gagal.

---

## 3. Environment Variables

Isi di **Project → Settings → Environment Variables**. Yang tidak rahasia
(`APP_ENV`, `SESSION_DRIVER`, dll.) sudah diatur di `vercel.json`.

| Variabel | Nilai | Keterangan |
|---|---|---|
| `APP_KEY` | `base64:...` | **Salin dari `.env` lokal Anda.** Tanpa ini aplikasi error. |
| `APP_URL` | `https://<proyek>.vercel.app` | Lihat catatan di bawah. |
| `DB_HOST` | `ep-...aws.neon.tech` | Dari `.env` lokal |
| `DB_PORT` | `5432` | |
| `DB_DATABASE` | `neondb` | |
| `DB_USERNAME` | `neondb_owner` | |
| `DB_PASSWORD` | `npg_...` | Rahasia |
| `DB_SSLMODE` | `require` | Wajib untuk Neon |
| `DB_PGSQL_OPTIONS` | — | **JANGAN diisi di Vercel.** Lihat peringatan di bawah. |

> **PENTING — `DB_PGSQL_OPTIONS` JANGAN diisi di Vercel.**
> Variabel ini bersifat *environment-specific* dan kebutuhannya **berlawanan**:
>
> | | libpq | Butuh `DB_PGSQL_OPTIONS`? |
> |---|---|---|
> | **Lokal (XAMPP)** | tua, tanpa dukungan SNI | **YA** — tanpa ini: `Endpoint ID is not specified` |
> | **Vercel (PHP 8.3)** | baru, mendukung SNI | **TIDAK** — bila diisi: `Inconsistent project name inferred from SNI` |
>
> Neon mengenali project dari SNI. Bila `options='endpoint=...'` juga dikirim dan
> namanya berbeda (`-pooler` vs tanpa `-pooler`), Neon menolak koneksinya.
>
> Jadi: **biarkan tetap ada di `.env` lokal, tapi jangan dibuat di Vercel.**

> **PENTING — jangan hanya mengandalkan `DB_URL`.**
> Blok `pgsql` di `config/database.php` **tidak** membaca `DB_URL` (yang ada di
> `.env` hanya terpakai oleh driver lain). Koneksi dibangun dari `DB_HOST` dkk.
> Kalau Anda hanya mengisi `DB_URL`, Laravel diam-diam mencoba `127.0.0.1` dan gagal
> connect.

Nilainya bisa disalin dari `.env` lokal. **Jangan commit `.env`** — sudah ditahan
`.gitignore` dan `.vercelignore`.

### Soal `APP_URL`

`APP_URL` di `.env` lokal Anda (`http://127.0.0.1:8000`) **sudah benar untuk lokal —
biarkan saja**. File `.env` tidak pernah ikut terupload ke Vercel, jadi tidak akan
mengganggu produksi.

Yang perlu dipahami: **saat melayani request HTTP, Laravel memakai host asli dari
request, bukan `APP_URL`.** Jadi di Vercel semua link/gambar otomatis memakai domain
yang sedang dibuka. `APP_URL` hanya dipakai ketika **tidak ada request HTTP** —
mis. perintah `php artisan`, queue, atau email yang dibuat dari CLI.

Tetap isi `APP_URL` di Vercel dengan domain asli agar link dari CLI/email benar,
tapi salah isi tidak akan membuat gambar/CSS rusak.

### HTTPS di balik proxy (sudah ditangani)

Vercel menerminasi HTTPS di edge, lalu meneruskan request ke PHP sebagai HTTP biasa
plus header `X-Forwarded-Proto: https`. Laravel hanya auto-percaya proxy untuk
Laravel Cloud/Forge/Vapor — **Vercel tidak termasuk**. Tanpa penanganan, Laravel
mengira koneksinya `http://` lalu membuat URL `http://` di halaman `https://`;
CSS/JS diblokir browser (*mixed content*) dan situs tampil tanpa gaya.

Karena itu `bootstrap/app.php` sekarang memuat:

```php
$middleware->trustProxies(at: '*');
```

Aman untuk lokal: tanpa header `X-Forwarded-*`, baris ini tidak berefek apa pun.

---

## 4. Deploy

```bash
git add .
git commit -m "Tambah konfigurasi deploy Vercel"
git push
```

Import repo di vercel.com → atur Root Directory = `web-sekolah` → isi env vars → Deploy.

---

## 5. Migrasi database

**Migrasi tidak berjalan otomatis di Vercel** (tidak ada shell saat runtime).
Jalankan dari komputer lokal — databasenya sama (Neon), jadi hasilnya langsung
terpakai oleh Vercel:

```bash
php artisan migrate --force
```

---

## 6. Batasan yang perlu diketahui

### Upload dokumen PDF AKAN RUSAK di Vercel

**Tata Tertib** dan **Kalender Akademik** masih menyimpan dokumen sebagai file di
disk (`storage/app/public`). Di Vercel:

- file tertulis ke `/tmp` yang **terhapus** dan **tidak dibagi** antar-instance;
- dokumen yang baru diupload akan hilang dan tidak bisa diunduh.

Fitur lain aman: **semua gambar** (berita, galeri, guru, ekskul, prestasi, sarpras,
ruang kelas, e-book, siswa, video) sudah tersimpan sebagai biner di database.

Agar dokumen ikut aman, solusinya sama seperti gambar: simpan sebagai biner di
database, atau pakai penyimpanan eksternal (S3/Vercel Blob). Bilang saja kalau mau
saya kerjakan.

### Gambar lama yang file-nya sudah hilang

File upload **tidak pernah ikut di Git** (`storage/app/public/.gitignore` berisi `*`),
jadi gambar yang masih memakai path lama tidak akan tampil di Vercel. Setelah
`php artisan images:to-db`, tersisa 2 record yang file-nya sudah hilang dari disk
(`ekstrakurikuler#1`, `ebooks#1`) — **upload ulang lewat dashboard admin**.

### Lainnya

- **Log** dikirim ke `stderr` → lihat di tab *Runtime Logs* Vercel, bukan file.
- **Session & cache** memakai database (sudah cocok untuk serverless).
- Versi runtime `vercel-php@0.7.4` di `vercel.json` bisa dinaikkan bila ada rilis baru.

---

## 7. Kalau gagal

| Gejala | Kemungkinan penyebab |
|---|---|
| `404: NOT_FOUND` | Root Directory belum diisi `web-sekolah`. |
| `500` + log `BindingResolutionException` / `Target class [...] does not exist` | File aplikasi tidak ikut ter-bundle. Pastikan `includeFiles: ["**"]` masih ada di `vercel.json`. |
| `500` + log `bootstrap/cache ... must be present and writable` | Cache bootstrap belum diarahkan ke `/tmp` — cek `api/index.php`. |
| `500` + log `No application encryption key` | `APP_KEY` belum diisi. |
| `SQLSTATE[08006] ... Inconsistent project name inferred from SNI` | `DB_PGSQL_OPTIONS` terisi di Vercel — **hapus variabelnya**. |
| `SQLSTATE... could not connect / 127.0.0.1` | `DB_HOST` belum diisi (lihat catatan `DB_URL` di atas). |
| CSS/JS tidak muncul / situs tanpa gaya | Cek blok `routes` di `vercel.json`. Bila di console browser muncul *mixed content*, pastikan `trustProxies` masih ada di `bootstrap/app.php`. |
| `Class not found` | Composer gagal install — cek Build Logs. |
