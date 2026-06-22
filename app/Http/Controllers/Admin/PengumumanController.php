<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::orderByDesc('tanggal')->orderByDesc('id')->paginate(15);
        return view('admin.pengumuman.index', compact('pengumuman'));
    }

    public function create()
    {
        return view('admin.pengumuman.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'     => 'required|string|max:255',
            'ringkasan' => 'nullable|string|max:500',
            'isi'       => 'required|string',
            'lampiran'  => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'penting'   => 'boolean',
            'tanggal'   => 'required|date',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('lampiran')) {
            $data['lampiran'] = $request->file('lampiran')->store('lampiran', 'public');
        }

        $data['penting']   = $request->boolean('penting');
        $data['is_active'] = $request->boolean('is_active');

        Pengumuman::create($data);

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.form', ['item' => $pengumuman]);
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $data = $request->validate([
            'judul'     => 'required|string|max:255',
            'ringkasan' => 'nullable|string|max:500',
            'isi'       => 'required|string',
            'lampiran'  => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'penting'   => 'boolean',
            'tanggal'   => 'required|date',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('lampiran')) {
            if ($pengumuman->lampiran) Storage::disk('public')->delete($pengumuman->lampiran);
            $data['lampiran'] = $request->file('lampiran')->store('lampiran', 'public');
        } else {
            unset($data['lampiran']);
        }

        $data['penting']   = $request->boolean('penting');
        $data['is_active'] = $request->boolean('is_active');

        $pengumuman->update($data);

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        if ($pengumuman->lampiran) Storage::disk('public')->delete($pengumuman->lampiran);
        $pengumuman->delete();

        return back()->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function toggle(Pengumuman $pengumuman)
    {
        $pengumuman->update(['is_active' => ! $pengumuman->is_active]);
        return back()->with('success', 'Status pengumuman diperbarui.');
    }
}
