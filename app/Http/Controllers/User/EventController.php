<?php

namespace App\Http\Controllers\User;

use App\Exports\InvitationGuestExport;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\MusicLibrary;
use App\Models\Package;
use App\Models\Template;
use App\Models\Theme;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class EventController extends Controller
{
    public function index(): View
    {
        $events = Event::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('user.events.index', compact('events'));
    }

    public function create(): View
    {
        $packages = Package::all();
        $themes   = Theme::where('is_active', true)->get();

        return view('user.events.create', compact('packages', 'themes'));
    }

    public function store(Request $request): RedirectResponse
    {
        // Convert empty strings to null for URL fields before validation
        $request->merge([
            'maps_link' => $request->input('maps_link') ?: null,
            'event_data' => array_map(
                fn ($v) => $v === '' ? null : $v,
                (array) $request->input('event_data', [])
            ),
        ]);

        $validated = $request->validate([
            'event_type'   => ['required', 'string', 'in:pernikahan,buka_puasa,workshop,kegiatan_kantor,rapat,pelatihan'],
            'title'        => ['required', 'string', 'max:255'],
            'package_id'   => ['required', 'exists:packages,id'],
            'theme_id'     => ['nullable', 'exists:themes,id'],
            'bride_name'   => ['nullable', 'string', 'max:255'],
            'groom_name'   => ['nullable', 'string', 'max:255'],
            'event_date'   => ['required', 'date'],
            'location'     => ['required', 'string'],
            'maps_link'    => ['nullable', 'sometimes', 'url', 'max:500'],
            'rsvp_enabled' => ['nullable'],
            'banner_image'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'gallery_images'   => ['nullable', 'array', 'max:8'],
            'gallery_images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'event_data'                  => ['nullable', 'array'],
            'event_data.bride_parents'    => ['nullable', 'string', 'max:500'],
            'event_data.groom_parents'    => ['nullable', 'string', 'max:500'],
            'event_data.reception_date'   => ['nullable', 'string', 'max:50'],
            'event_data.description'      => ['nullable', 'string', 'max:2000'],
            'event_data.speaker_title'    => ['nullable', 'string', 'max:255'],
            'event_data.end_date'         => ['nullable', 'string', 'max:50'],
            'event_data.sertifikat'       => ['nullable', 'string', 'in:0,1'],
            'event_data.biaya_sukarela'   => ['nullable', 'string', 'in:0,1'],
            'event_data.livestream_link'  => ['nullable', 'sometimes', 'url', 'max:500'],
            'event_data.peserta_publik'   => ['nullable', 'string', 'in:0,1'],
            'event_data.speaker1_name'    => ['nullable', 'string', 'max:255'],
            'event_data.speaker1_title'   => ['nullable', 'string', 'max:255'],
            'event_data.speaker1_role'    => ['nullable', 'string', 'max:100'],
            'event_data.speaker2_name'    => ['nullable', 'string', 'max:255'],
            'event_data.speaker2_title'   => ['nullable', 'string', 'max:255'],
            'event_data.speaker2_role'    => ['nullable', 'string', 'max:100'],
            'event_data.mc_name'          => ['nullable', 'string', 'max:255'],
            'event_data.mc_title'         => ['nullable', 'string', 'max:255'],
            'speaker1_photo'              => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'speaker2_photo'              => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'mc_photo'                    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'host_photo'                  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'music_id'                    => ['nullable', 'integer', 'exists:music_library,id'],
        ], [
            'maps_link.url'                      => 'Link Google Maps harus berupa URL yang valid (contoh: https://maps.google.com/...).',
            'event_data.livestream_link.url'     => 'Link Live Stream harus berupa URL yang valid (contoh: https://youtube.com/live/...).',
            'event_type.required'                => 'Jenis acara wajib dipilih.',
            'event_type.in'                      => 'Jenis acara tidak valid.',
            'title.required'                     => 'Judul undangan wajib diisi.',
            'package_id.required'                => 'Paket wajib dipilih.',
            'event_date.required'                => 'Tanggal acara wajib diisi.',
            'location.required'                  => 'Lokasi acara wajib diisi.',
            'banner_image.image'        => 'File banner harus berupa gambar.',
            'banner_image.mimes'        => 'Format banner: JPG, JPEG, PNG, atau WEBP.',
            'banner_image.max'          => 'Ukuran banner maksimal 2MB.',
            'gallery_images.max'        => 'Galeri maksimal 8 foto.',
            'gallery_images.*.image'    => 'File galeri harus berupa gambar.',
            'gallery_images.*.mimes'    => 'Format galeri: JPG, JPEG, PNG, atau WEBP.',
            'gallery_images.*.max'      => 'Ukuran setiap foto galeri maksimal 2MB.',
            'music_id.exists'           => 'Pilihan musik tidak valid.',
        ]);

        // Auto-assign Template by event_type (user never selects template manually)
        $template = Template::active()->byEventType($validated['event_type'])->first();
        if (! $template) {
            return back()->withInput()->withErrors([
                'event_type' => 'Tidak ada template aktif untuk jenis acara ini. Hubungi admin.',
            ]);
        }
        $validated['template_id'] = $template->id;

        // Auto-assign Theme by event_type (only if user did not manually choose a theme)
        if (empty($validated['theme_id'])) {
            $themeSlugMap = [
                'pernikahan'      => 'wedding-elegant',
                'buka_puasa'      => 'ramadan-glow',
                'workshop'        => 'workshop-modern',
                'kegiatan_kantor' => 'government-clean',
                'rapat'           => 'corporate-modern',
                'pelatihan'       => 'executive-dark',
            ];
            $autoTheme = Theme::where('slug', $themeSlugMap[$validated['event_type']])
                ->where('is_active', true)
                ->first();
            if ($autoTheme) {
                $validated['theme_id'] = $autoTheme->id;
            }
        }

        $validated['user_id']      = auth()->id();
        $validated['slug']         = Str::slug($validated['title']) . '-' . uniqid();
        $validated['rsvp_enabled'] = $request->input('rsvp_enabled') === '1';
        $validated['groom_name']   = $validated['groom_name'] ?? null;

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')
                ->store('events/banners', 'public');
        }

        // Handle gallery images upload
        if ($request->hasFile('gallery_images')) {
            $galleryPaths = [];
            foreach ($request->file('gallery_images') as $file) {
                $galleryPaths[] = $file->store('events/gallery', 'public');
            }
            $validated['gallery_images'] = $galleryPaths;
        }

        // Handle speaker / MC photo uploads + host photo (buka_puasa)
        foreach (['speaker1_photo', 'speaker2_photo', 'mc_photo', 'host_photo'] as $field) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('events/speakers', 'public');
                $validated['event_data'] = $validated['event_data'] ?? [];
                $validated['event_data'][$field] = $path;
            }
        }

        // Handle music selection (centralized library)
        if ($request->filled('music_id')) {
            $music = MusicLibrary::where('id', $request->music_id)->where('is_active', true)->first();
            $validated['music_id'] = $music?->id;
        } else {
            $validated['music_id'] = null;
        }
        unset($validated['background_music']);

        // Clean up event_data: remove empty values
        if (isset($validated['event_data'])) {
            $validated['event_data'] = array_filter(
                $validated['event_data'],
                fn ($v) => $v !== null && $v !== ''
            );
            if (empty($validated['event_data'])) {
                $validated['event_data'] = null;
            }
        }

        Event::create($validated);

        return redirect()->route('user.events.index')
            ->with('success', 'Undangan berhasil dibuat.');
    }

    public function show(Event $event): View
    {
        $this->authorizeEvent($event);

        return view('user.events.show', compact('event'));
    }

    public function edit(Event $event): View
    {
        $this->authorizeEvent($event);

        $packages = Package::all();
        $themes   = Theme::where('is_active', true)->get();

        return view('user.events.edit', compact('event', 'packages', 'themes'));
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $this->authorizeEvent($event);

        // Normalize empty strings → null for URL/optional fields
        $request->merge([
            'maps_link' => $request->input('maps_link') ?: null,
            'event_data' => array_map(
                fn ($v) => $v === '' ? null : $v,
                (array) $request->input('event_data', [])
            ),
        ]);

        $validated = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'package_id'   => ['required', 'exists:packages,id'],
            'theme_id'     => ['nullable', 'exists:themes,id'],
            'bride_name'   => ['nullable', 'string', 'max:255'],
            'groom_name'   => ['nullable', 'string', 'max:255'],
            'event_date'   => ['required', 'date'],
            'location'     => ['required', 'string'],
            'maps_link'    => ['nullable', 'sometimes', 'url', 'max:500'],
            'rsvp_enabled' => ['nullable'],
            'banner_image'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'gallery_images'   => ['nullable', 'array', 'max:8'],
            'gallery_images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'event_data'                  => ['nullable', 'array'],
            'event_data.bride_parents'    => ['nullable', 'string', 'max:500'],
            'event_data.groom_parents'    => ['nullable', 'string', 'max:500'],
            'event_data.reception_date'   => ['nullable', 'string', 'max:50'],
            'event_data.description'      => ['nullable', 'string', 'max:2000'],
            'event_data.speaker_title'    => ['nullable', 'string', 'max:255'],
            'event_data.end_date'         => ['nullable', 'string', 'max:50'],
            'event_data.sertifikat'       => ['nullable', 'string', 'in:0,1'],
            'event_data.biaya_sukarela'   => ['nullable', 'string', 'in:0,1'],
            'event_data.livestream_link'  => ['nullable', 'sometimes', 'url', 'max:500'],
            'event_data.peserta_publik'   => ['nullable', 'string', 'in:0,1'],
            'event_data.speaker1_name'    => ['nullable', 'string', 'max:255'],
            'event_data.speaker1_title'   => ['nullable', 'string', 'max:255'],
            'event_data.speaker1_role'    => ['nullable', 'string', 'max:100'],
            'event_data.speaker2_name'    => ['nullable', 'string', 'max:255'],
            'event_data.speaker2_title'   => ['nullable', 'string', 'max:255'],
            'event_data.speaker2_role'    => ['nullable', 'string', 'max:100'],
            'event_data.mc_name'          => ['nullable', 'string', 'max:255'],
            'event_data.mc_title'         => ['nullable', 'string', 'max:255'],
            'speaker1_photo'              => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'speaker2_photo'              => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'mc_photo'                    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'host_photo'                  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'music_id'                    => ['nullable', 'integer', 'exists:music_library,id'],
        ], [
            'maps_link.url'                  => 'Link Google Maps harus berupa URL yang valid.',
            'event_data.livestream_link.url' => 'Link Live Stream harus berupa URL yang valid.',
            'banner_image.image'             => 'File banner harus berupa gambar.',
            'banner_image.mimes'             => 'Format banner: JPG, JPEG, PNG, atau WEBP.',
            'banner_image.max'               => 'Ukuran banner maksimal 2MB.',
            'gallery_images.max'             => 'Galeri maksimal 8 foto.',
            'gallery_images.*.image'         => 'File galeri harus berupa gambar.',
            'gallery_images.*.mimes'         => 'Format galeri: JPG, JPEG, PNG, atau WEBP.',
            'gallery_images.*.max'           => 'Ukuran setiap foto galeri maksimal 2MB.',
            'music_id.exists'                => 'Pilihan musik tidak valid.',
        ]);

        // ── BANNER: replace old file if new one uploaded ──────────────────
        if ($request->hasFile('banner_image')) {
            if ($event->banner_image) {
                Storage::disk('public')->delete($event->banner_image);
            }
            $validated['banner_image'] = $request->file('banner_image')
                ->store('events/banners', 'public');
        } else {
            unset($validated['banner_image']);
        }

        // ── GALLERY: replace all if new files uploaded ────────────────────
        if ($request->hasFile('gallery_images')) {
            if (! empty($event->gallery_images)) {
                foreach ($event->gallery_images as $oldPath) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
            $galleryPaths = [];
            foreach ($request->file('gallery_images') as $file) {
                $galleryPaths[] = $file->store('events/gallery', 'public');
            }
            $validated['gallery_images'] = $galleryPaths;
        } else {
            unset($validated['gallery_images']);
        }

        // ── RSVP toggle ───────────────────────────────────────────────────
        $validated['rsvp_enabled'] = $request->input('rsvp_enabled') === '1';

        // ── SPEAKER / MC PHOTOS + HOST PHOTO ─────────────────────────────
        $eventData = $validated['event_data'] ?? ($event->event_data ?? []);
        foreach (['speaker1_photo', 'speaker2_photo', 'mc_photo', 'host_photo'] as $field) {
            if ($request->hasFile($field)) {
                if (! empty($event->event_data[$field])) {
                    Storage::disk('public')->delete($event->event_data[$field]);
                }
                $eventData[$field] = $request->file($field)->store('events/speakers', 'public');
            }
        }

        // ── MUSIC SELECTION (centralized library) ────────────────────────
        if ($request->has('music_id')) {
            if ($request->filled('music_id')) {
                $music = MusicLibrary::where('id', $request->music_id)->where('is_active', true)->first();
                $validated['music_id'] = $music?->id;
            } else {
                $validated['music_id'] = null;
            }
        }
        unset($validated['background_music']);

        // Clean up event_data nulls and set result
        $eventData = array_filter($eventData ?? [], fn ($v) => $v !== null && $v !== '');
        $validated['event_data'] = empty($eventData) ? null : $eventData;

        $event->update($validated);

        return redirect()->route('user.events.index')
            ->with('success', 'Undangan berhasil diperbarui.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $this->authorizeEvent($event);

        $event->delete();

        return redirect()->route('user.events.index')
            ->with('success', 'Undangan berhasil dihapus.');
    }

    public function publish(Event $event): RedirectResponse
    {
        $this->authorizeEvent($event);

        if ($event->is_published) {
            return redirect()->route('user.events.show', $event)
                ->with('error', 'Undangan sudah dipublikasikan sebelumnya.');
        }

        $durationDays = $event->package->duration_days;

        $event->update([
            'is_published' => true,
            'expired_at'   => Carbon::now()->addDays($durationDays),
        ]);

        return redirect()->route('user.events.show', $event)
            ->with('success', "Undangan berhasil dipublikasikan! Aktif selama {$durationDays} hari.");
    }

    public function exportGuests(Event $event): BinaryFileResponse
    {
        $this->authorizeEvent($event);

        $fileName = 'rekap-tamu-' . $event->slug . '.xlsx';

        return Excel::download(new InvitationGuestExport($event), $fileName);
    }

    private function authorizeEvent(Event $event): void
    {
        if (auth()->user()->role === 'admin') {
            return;
        }

        if ($event->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke undangan ini.');
        }
    }
}
