<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesan;

class PesanController extends Controller
{
    public function index()
    {
        $items = Pesan::orderBy('is_read')        // belum dibaca tampil di atas
            ->orderByDesc('created_at')
            ->paginate(15);

        $unread = Pesan::where('is_read', false)->count();

        return view('admin.pesan.index', compact('items', 'unread'));
    }

    public function show(Pesan $pesan)
    {
        if (! $pesan->is_read) {
            $pesan->update(['is_read' => true]);
        }

        return view('admin.pesan.show', compact('pesan'));
    }

    public function toggle(Pesan $pesan)
    {
        $pesan->update(['is_read' => ! $pesan->is_read]);

        return back()->with('success', 'Status pesan diperbarui.');
    }

    public function markAllRead()
    {
        Pesan::where('is_read', false)->update(['is_read' => true]);

        return back()->with('success', 'Semua pesan ditandai sudah dibaca.');
    }

    public function destroy(Pesan $pesan)
    {
        $pesan->delete();

        return back()->with('success', 'Pesan berhasil dihapus.');
    }
}
