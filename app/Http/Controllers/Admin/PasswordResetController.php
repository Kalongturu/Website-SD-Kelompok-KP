<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;

class PasswordResetController extends Controller
{
    /**
     * LANGKAH 1 — Tampilkan form "masukkan email Anda".
     */
    public function showRequest()
    {
        return view('admin.auth.forgot_password');
    }

    /**
     * LANGKAH 2 — Proses email: buat token & kirim tautan reset.
     *
     * Password::sendResetLink() melakukan semuanya:
     *  - cari user berdasarkan email,
     *  - buat token acak lalu simpan versi hash-nya di tabel password_reset_tokens,
     *  - kirim notifikasi email berisi tautan ke route bernama 'password.reset'.
     */
    public function sendLink(Request $request)
    {
        $request->validate(
            ['email' => 'required|email'],
            [
                'email.required' => 'Email wajib diisi.',
                'email.email'    => 'Format email tidak valid.',
            ]
        );

        Password::sendResetLink($request->only('email'));

        // Pesan netral & selalu sama — supaya orang luar tidak bisa menebak
        // email mana yang terdaftar (mencegah enumerasi akun).
        return back()->with('status',
            'Jika email tersebut terdaftar, kami telah mengirimkan tautan reset password. Silakan periksa kotak masuk Anda.');
    }

    /**
     * LANGKAH 3 — Tampilkan form "password baru".
     * Dibuka dari tautan di email: /admin/reset-password/{token}?email=...
     */
    public function showReset(Request $request, string $token)
    {
        return view('admin.auth.reset_password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    /**
     * LANGKAH 4 — Simpan password baru.
     *
     * Password::reset() memverifikasi token + email, lalu menjalankan callback
     * untuk benar-benar mengganti password. Token dihapus otomatis setelah sukses.
     */
    public function reset(Request $request)
    {
        $request->validate(
            [
                'token'    => 'required',
                'email'    => 'required|email',
                'password' => ['required', 'confirmed', PasswordRule::min(8)],
            ],
            [
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'password.min'       => 'Password minimal 8 karakter.',
            ]
        );

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('admin.login')
                ->with('status', 'Password berhasil diperbarui. Silakan masuk dengan password baru Anda.');
        }

        // Gagal: token kedaluwarsa/invalid atau email tidak cocok.
        return back()
            ->withErrors(['email' => 'Tautan reset tidak valid atau sudah kedaluwarsa. Silakan minta tautan baru.'])
            ->onlyInput('email');
    }
}
