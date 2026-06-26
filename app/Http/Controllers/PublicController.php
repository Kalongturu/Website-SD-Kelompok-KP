<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\Konten;
use App\Models\Mahasiswa;
use App\Models\PesanKontak;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function beranda()
    {
        return view('publik.beranda');
    }

    public function profil()
    {
        return view('publik.profil');
    }

    public function mahasiswa()
    {
        $mahasiswa = Mahasiswa::latest()->get();
        return view('publik.mahasiswa', compact('mahasiswa'));
    }

    public function galeri()
    {
        $galeri = Galeri::latest()->get();
        return view('publik.galeri', compact('galeri'));
    }

    public function kontak()
    {
        return view('publik.kontak');
    }

    public function kirimPesan(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subjek' => ['nullable', 'string', 'max:255'],
            'pesan' => ['required', 'string'],
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'pesan.required' => 'Pesan wajib diisi.',
        ]);

        PesanKontak::create($data);

        return back()->with('sukses', 'Terima kasih! Pesan Anda sudah kami terima.');
    }
}
