<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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

        if ($request->hasFile('avatar')) {
            if ($user->avatar && ! str_starts_with($user->avatar, 'http')) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatar', 'public');
        } else {
            unset($data['avatar']);
        }

        $user->update($data);

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
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

        if ($user->avatar) {
            if (! str_starts_with($user->avatar, 'http')) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->update(['avatar' => null]);
        }

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Avatar berhasil dihapus.');
    }
}
