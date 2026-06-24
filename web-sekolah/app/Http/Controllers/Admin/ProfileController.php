<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Tampilkan form edit profil admin yang sedang login.
     */
    public function edit()
    {
        return view('admin.profile', ['user' => Auth::user()]);
    }

    /**
     * Perbarui data profil (nama, email, no. HP, avatar).
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone'  => 'nullable|string|max:30',
            'avatar' => 'nullable|image|max:2048',
        ], [], [
            'name'  => 'nama',
            'email' => 'email',
            'phone' => 'nomor HP',
        ]);

        // Avatar tidak ikut $user->update(); foto disimpan sebagai biner (bytea).
        unset($data['avatar']);

        $user->update($data);

        if ($request->hasFile('avatar')) {
            $file  = $request->file('avatar');
            $bytes = file_get_contents($file->getRealPath());
            $mime  = $file->getMimeType() ?: 'image/jpeg';

            // decode(?, 'base64') -> bytea. Parameter dikirim sebagai teks base64
            // (ASCII penuh) sehingga aman dari masalah encoding koneksi PDO.
            DB::update(
                "UPDATE users SET avatar_data = decode(?, 'base64'), avatar_mime = ?, avatar = NULL, updated_at = ? WHERE id = ?",
                [base64_encode($bytes), $mime, now()->toDateTimeString(), $user->id]
            );
        }

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Menyajikan avatar admin langsung dari kolom biner (bytea) di database.
     * Byte diambil sebagai base64 lalu di-decode agar andal lintas driver PDO.
     */
    public function avatar()
    {
        $user = Auth::user();

        $row = DB::table('users')
            ->where('id', $user->id)
            ->selectRaw("encode(avatar_data, 'base64') as b64, avatar_mime")
            ->first();

        abort_if(! $row || empty($row->b64), 404);

        $bytes = base64_decode($row->b64);

        return response($bytes)
            ->header('Content-Type', $row->avatar_mime ?: 'image/jpeg')
            ->header('Content-Length', (string) strlen($bytes))
            ->header('Cache-Control', 'private, max-age=86400');
    }

    /**
     * Perbarui password admin (memerlukan password saat ini).
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password'         => 'required|string|min:8|confirmed',
        ], [
            'current_password.required'         => 'Password saat ini wajib diisi.',
            'current_password.current_password' => 'Password saat ini salah.',
            'password.required'                 => 'Password baru wajib diisi.',
            'password.min'                      => 'Password baru minimal 8 karakter.',
            'password.confirmed'                => 'Konfirmasi password baru tidak cocok.',
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Password berhasil diperbarui.');
    }

    /**
     * Hapus avatar yang terpasang.
     */
    public function deleteAvatar()
    {
        $user = Auth::user();

        DB::update(
            'UPDATE users SET avatar_data = NULL, avatar_mime = NULL, avatar = NULL, updated_at = ? WHERE id = ?',
            [now()->toDateTimeString(), $user->id]
        );

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Avatar berhasil dihapus.');
    }
}
