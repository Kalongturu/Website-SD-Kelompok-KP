<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    public function index()
    {
        $items = Guru::orderByDesc('is_kepala')->orderBy('urutan')->orderBy('id')->paginate(24);
        return view('admin.guru.index', compact('items'));
    }

    public function create()
    {
        return view('admin.guru.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('guru', 'public');
        }

        $data['is_kepala'] = $request->boolean('is_kepala');
        $data['urutan']    = $request->input('urutan', 0);
        $data['is_active'] = $request->boolean('is_active');

        // Hanya boleh ada satu Kepala Sekolah yang menjadi sorotan utama.
        if ($data['is_kepala']) {
            Guru::where('is_kepala', true)->update(['is_kepala' => false]);
        }

        Guru::create($data);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru / staf berhasil ditambahkan.');
    }

    public function edit(Guru $guru)
    {
        return view('admin.guru.form', ['item' => $guru]);
    }

    public function update(Request $request, Guru $guru)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('foto')) {
            if ($guru->foto) Storage::disk('public')->delete($guru->foto);
            $data['foto'] = $request->file('foto')->store('guru', 'public');
        } else {
            unset($data['foto']);
        }

        $data['is_kepala'] = $request->boolean('is_kepala');
        $data['urutan']    = $request->input('urutan', 0);
        $data['is_active'] = $request->boolean('is_active');

        // Hanya boleh ada satu Kepala Sekolah — turunkan status yang lain.
        if ($data['is_kepala']) {
            Guru::where('is_kepala', true)->where('id', '!=', $guru->id)->update(['is_kepala' => false]);
        }

        $guru->update($data);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru / staf berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        if ($guru->foto) Storage::disk('public')->delete($guru->foto);
        $guru->delete();

        return back()->with('success', 'Data guru / staf berhasil dihapus.');
    }

    public function toggle(Guru $guru)
    {
        $guru->update(['is_active' => ! $guru->is_active]);
        return back()->with('success', 'Status guru / staf diperbarui.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nama'      => 'required|string|max:150',
            'jabatan'   => 'required|string|max:150',
            'nip'       => 'nullable|string|max:50',
            'foto'      => 'nullable|image|max:3072',
            'is_kepala' => 'boolean',
            'urutan'    => 'integer|min:0',
            'is_active' => 'boolean',
        ]);
    }
}
