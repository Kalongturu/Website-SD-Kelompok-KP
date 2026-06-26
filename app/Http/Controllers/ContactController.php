<?php

namespace App\Http\Controllers;

use App\Models\Pesan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $sukses = 'Pesan Anda telah terkirim. Terima kasih, kami akan segera menindaklanjuti.';

        // Honeypot: field tersembunyi yang hanya diisi bot — diam-diam abaikan.
        if (filled($request->input('website'))) {
            return back()->with('kontak_success', $sukses)->withFragment('kontak');
        }

        $validator = Validator::make($request->all(), [
            'nama'   => 'required|string|max:150',
            'email'  => 'required|email|max:191',
            'subjek' => 'nullable|string|max:200',
            'pesan'  => 'required|string|max:5000',
        ], [
            'nama.required'  => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'pesan.required' => 'Pesan tidak boleh kosong.',
        ]);

        // Kembalikan ke bagian #kontak agar pengunjung tidak mendarat di atas halaman.
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->withFragment('kontak');
        }

        Pesan::create($validator->validated());

        return back()->with('kontak_success', $sukses)->withFragment('kontak');
    }
}
