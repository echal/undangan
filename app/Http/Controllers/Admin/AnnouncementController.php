<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\AnnouncementLog;
use App\Models\Theme;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function index(): View
    {
        $announcements = Announcement::with(['creator', 'theme'])
            ->latest()
            ->paginate(15);

        return view('admin.announcements.index', compact('announcements'));
    }

    public function create(): View
    {
        [$maintenanceThemes, $eventThemes] = $this->getThemeGroups();

        return view('admin.announcements.create', compact('maintenanceThemes', 'eventThemes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'                             => ['required', 'string', 'max:255'],
            'body'                              => ['required', 'string'],
            'severity'                          => ['required', 'in:info,warning,critical'],
            'starts_at'                         => ['nullable', 'date'],
            'ends_at'                           => ['nullable', 'date', 'after:starts_at'],
            'is_global_banner'                  => ['boolean'],
            'theme_id'                          => ['nullable', 'exists:themes,id'],
            'design_settings.primary_color'     => ['nullable', 'string', 'max:20'],
            'design_settings.background_color'  => ['nullable', 'string', 'max:20'],
            'design_settings.text_color'        => ['nullable', 'string', 'max:20'],
            'design_settings.end_time'          => ['nullable', 'date'],
            'design_settings.show_countdown'    => ['nullable', 'boolean'],
            'design_settings.show_timeline'     => ['nullable', 'boolean'],
            'design_settings.contact'           => ['nullable', 'string', 'max:255'],
            'design_settings.heading'           => ['nullable', 'string', 'max:255'],
        ]);

        $validated['design_settings'] = $request->input('design_settings') ?: null;

        $announcement = Announcement::create($validated + [
            'status'     => 'draft',
            'created_by' => auth()->id(),
        ]);

        AnnouncementLog::create([
            'announcement_id' => $announcement->id,
            'message'         => 'Pengumuman dibuat.',
            'created_by'      => auth()->id(),
        ]);

        return redirect()
            ->route('admin.announcements.edit', $announcement)
            ->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function edit(Announcement $announcement): View
    {
        $logs = $announcement->logs()->with('creator')->latest('created_at')->get();
        [$maintenanceThemes, $eventThemes] = $this->getThemeGroups();

        return view('admin.announcements.edit', compact('announcement', 'logs', 'maintenanceThemes', 'eventThemes'));
    }

    public function update(Request $request, Announcement $announcement): RedirectResponse
    {
        $validated = $request->validate([
            'title'                             => ['required', 'string', 'max:255'],
            'body'                              => ['required', 'string'],
            'severity'                          => ['required', 'in:info,warning,critical'],
            'starts_at'                         => ['nullable', 'date'],
            'ends_at'                           => ['nullable', 'date', 'after:starts_at'],
            'is_global_banner'                  => ['boolean'],
            'theme_id'                          => ['nullable', 'exists:themes,id'],
            'design_settings.primary_color'     => ['nullable', 'string', 'max:20'],
            'design_settings.background_color'  => ['nullable', 'string', 'max:20'],
            'design_settings.text_color'        => ['nullable', 'string', 'max:20'],
            'design_settings.end_time'          => ['nullable', 'date'],
            'design_settings.show_countdown'    => ['nullable', 'boolean'],
            'design_settings.show_timeline'     => ['nullable', 'boolean'],
            'design_settings.contact'           => ['nullable', 'string', 'max:255'],
            'design_settings.heading'           => ['nullable', 'string', 'max:255'],
        ]);

        $validated['design_settings'] = $request->input('design_settings') ?: null;

        $announcement->update($validated);

        AnnouncementLog::create([
            'announcement_id' => $announcement->id,
            'message'         => 'Pengumuman diperbarui.',
            'created_by'      => auth()->id(),
        ]);

        return redirect()
            ->route('admin.announcements.edit', $announcement)
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement): RedirectResponse
    {
        $announcement->delete();

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function publish(Announcement $announcement): RedirectResponse
    {
        $announcement->update(['status' => 'published']);

        AnnouncementLog::create([
            'announcement_id' => $announcement->id,
            'message'         => 'Pengumuman dipublikasikan.',
            'created_by'      => auth()->id(),
        ]);

        return redirect()
            ->route('admin.announcements.edit', $announcement)
            ->with('success', 'Pengumuman berhasil dipublikasikan.');
    }

    public function archive(Announcement $announcement): RedirectResponse
    {
        $announcement->update(['status' => 'archived']);

        AnnouncementLog::create([
            'announcement_id' => $announcement->id,
            'message'         => 'Pengumuman diarsipkan.',
            'created_by'      => auth()->id(),
        ]);

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil diarsipkan.');
    }

    public function addLog(Request $request, Announcement $announcement): RedirectResponse
    {
        $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        AnnouncementLog::create([
            'announcement_id' => $announcement->id,
            'message'         => $request->input('message'),
            'created_by'      => auth()->id(),
        ]);

        return redirect()
            ->route('admin.announcements.edit', $announcement)
            ->with('success', 'Log berhasil ditambahkan.');
    }

    /** @return array{\Illuminate\Support\Collection, \Illuminate\Support\Collection} */
    private function getThemeGroups(): array
    {
        $maintenanceThemes = Theme::where('category', 'maintenance')->where('is_active', true)->get();
        $eventThemes       = Theme::where('category', 'event')->where('is_active', true)->get();

        return [$maintenanceThemes, $eventThemes];
    }
}
