<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoPembelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoPembelajaranController extends Controller
{
    public function index()
    {
        $items = VideoPembelajaran::orderBy('urutan')->orderBy('id')->paginate(20);
        return view('admin.video_pembelajaran.index', compact('items'));
    }

    public function create()
    {
        return view('admin.video_pembelajaran.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'          => 'required|string|max:255',
            'mata_pelajaran' => 'nullable|string|max:100',
            'kelas'          => 'nullable|string|max:50',
            'deskripsi'      => 'nullable|string|max:2000',
            'url_video'      => 'required|url|max:500',
            'thumbnail'      => 'nullable|image|max:2048',
            'urutan'         => 'integer|min:0',
            'is_active'      => 'boolean',
        ]);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('video/thumbnail', 'public');
        }

        $data['urutan']    = $request->input('urutan', 0);
        $data['is_active'] = $request->boolean('is_active');

        VideoPembelajaran::create($data);

        return redirect()->route('admin.video.index')
            ->with('success', 'Video pembelajaran berhasil ditambahkan.');
    }

    public function edit(VideoPembelajaran $video)
    {
        return view('admin.video_pembelajaran.form', ['item' => $video]);
    }

    public function update(Request $request, VideoPembelajaran $video)
    {
        $data = $request->validate([
            'judul'          => 'required|string|max:255',
            'mata_pelajaran' => 'nullable|string|max:100',
            'kelas'          => 'nullable|string|max:50',
            'deskripsi'      => 'nullable|string|max:2000',
            'url_video'      => 'required|url|max:500',
            'thumbnail'      => 'nullable|image|max:2048',
            'urutan'         => 'integer|min:0',
            'is_active'      => 'boolean',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($video->thumbnail) Storage::disk('public')->delete($video->thumbnail);
            $data['thumbnail'] = $request->file('thumbnail')->store('video/thumbnail', 'public');
        } else {
            unset($data['thumbnail']);
        }

        $data['urutan']    = $request->input('urutan', 0);
        $data['is_active'] = $request->boolean('is_active');

        $video->update($data);

        return redirect()->route('admin.video.index')
            ->with('success', 'Video pembelajaran berhasil diperbarui.');
    }

    public function destroy(VideoPembelajaran $video)
    {
        if ($video->thumbnail) Storage::disk('public')->delete($video->thumbnail);
        $video->delete();

        return back()->with('success', 'Video pembelajaran berhasil dihapus.');
    }

    public function toggle(VideoPembelajaran $video)
    {
        $video->update(['is_active' => ! $video->is_active]);
        return back()->with('success', 'Status video diperbarui.');
    }
}
