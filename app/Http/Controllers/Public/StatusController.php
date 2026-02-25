<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\View\View;

class StatusController extends Controller
{
    public function show(string $slug): View
    {
        $announcement = Announcement::with([
            'theme',
            'logs' => fn ($q) => $q->with('creator')->latest('created_at'),
        ])
            ->where('slug', $slug)
            ->where('status', '!=', 'archived')
            ->firstOrFail();

        // Fallback ke system-status lama jika theme belum dipilih
        if (! $announcement->theme) {
            return view('themes.system-status.index', compact('announcement'));
        }

        $category = $announcement->theme->category; // 'maintenance' | 'event'
        $folder   = $announcement->theme->folder;   // 'dark' | 'clean' | 'elegant' | 'classic'
        $viewPath = "themes.{$category}.{$folder}.index";

        if (! view()->exists($viewPath)) {
            abort(404, "Theme view tidak ditemukan: {$viewPath}");
        }

        return view($viewPath, compact('announcement'));
    }
}
