<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Galeri;
use App\Models\PpdbSetting;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return redirect()->route('admin.dashboard');
        }

        $berita = Berita::where('is_active', true)
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->limit(3)
            ->get();

        $galeriPreview = Galeri::where('is_active', true)
            ->orderBy('urutan')
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->limit(6)
            ->get();

        $ppdb = PpdbSetting::getData();

        return view('home', compact('berita', 'galeriPreview', 'ppdb'));
    }
}
