<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Models\Mahasiswa;
use App\Models\PesanKontak;

class DashboardController extends Controller
{
    public function index()
    {
        $statistik = [
            'galeri' => Galeri::count(),
            'mahasiswa' => Mahasiswa::count(),
            'pesan' => PesanKontak::count(),
            'pesan_baru' => PesanKontak::where('dibaca', false)->count(),
        ];

        $pesanTerbaru = PesanKontak::latest()->take(5)->get();

        return view('admin.dashboard', compact('statistik', 'pesanTerbaru'));
    }
}
