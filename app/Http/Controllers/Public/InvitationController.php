<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Guest;
use App\Models\NoticeReport;
use App\Models\Wish;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class InvitationController extends Controller
{
    public function show(string $slug): View
    {
        $event = Event::with(['wishes' => fn ($q) => $q->latest(), 'guests', 'theme', 'noticeReports' => fn ($q) => $q->latest()])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->where(fn ($q) => $q->whereNull('expired_at')->orWhere('expired_at', '>', now()))
            ->firstOrFail();

        // Render tema dinamis jika event punya tema aktif dan view-nya tersedia
        if ($event->theme && $event->theme->is_active && $event->theme->viewExists()) {
            return view("themes.{$event->theme->folder}.index", compact('event'));
        }

        // Fallback ke view default
        return view('invitation.show', compact('event'));
    }

    public function calendar(string $slug): Response
    {
        $event = Event::where('slug', $slug)
            ->where('is_published', true)
            ->where(fn ($q) => $q->whereNull('expired_at')->orWhere('expired_at', '>', now()))
            ->firstOrFail();

        if (! $event->event_date) {
            abort(404);
        }

        $escape = fn (string $s): string => str_replace(
            ["\n", ',',  ';',  '\\'],
            ['\\n', '\\,', '\\;', '\\\\'],
            $s
        );

        $start   = $event->event_date->format('Ymd\THis');
        $end     = $event->event_date->copy()->addHours(2)->format('Ymd\THis');
        $now     = now()->setTimezone('UTC')->format('Ymd\THis\Z');
        $summary  = $escape($event->title    ?? '');
        $location = $escape($event->location ?? '');
        $uid      = $event->slug . '@undangandigital';

        $ics = implode("\r\n", [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//Undangan Digital//EN',
            'CALSCALE:GREGORIAN',
            'METHOD:PUBLISH',
            'BEGIN:VEVENT',
            "UID:{$uid}",
            "DTSTAMP:{$now}",
            "DTSTART:{$start}",
            "DTEND:{$end}",
            "SUMMARY:{$summary}",
            "LOCATION:{$location}",
            "DESCRIPTION:Undangan: {$summary}",
            'END:VEVENT',
            'END:VCALENDAR',
        ]);

        $filename = 'undangan-' . $event->slug . '.ics';

        return response($ics, 200, [
            'Content-Type'        => 'text/calendar; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    public function rsvp(Request $request, string $slug): RedirectResponse
    {
        $event = Event::where('slug', $slug)
            ->where('is_published', true)
            ->where(fn ($q) => $q->whereNull('expired_at')->orWhere('expired_at', '>', now()))
            ->firstOrFail();

        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'phone'       => ['nullable', 'string', 'max:20'],
            'rsvp_status' => ['required', 'in:hadir,tidak_hadir,pending'],
        ]);

        $validated['event_id'] = $event->id;

        Guest::create($validated);

        return redirect()->route('invitation.show', $slug)
            ->with('rsvp_success', 'RSVP Anda berhasil dikirim. Terima kasih!');
    }

    public function wish(Request $request, string $slug): RedirectResponse
    {
        $event = Event::where('slug', $slug)
            ->where('is_published', true)
            ->where(fn ($q) => $q->whereNull('expired_at')->orWhere('expired_at', '>', now()))
            ->firstOrFail();

        $validated = $request->validate([
            'guest_name' => ['required', 'string', 'max:255'],
            'message'    => ['required', 'string', 'max:1000'],
        ]);

        $validated['event_id'] = $event->id;

        Wish::create($validated);

        return redirect()->route('invitation.show', $slug)
            ->with('wish_success', 'Ucapan Anda berhasil dikirim. Semoga bahagia selalu!');
    }

    public function report(Request $request, string $slug): RedirectResponse
    {
        $event = Event::where('slug', $slug)
            ->where('is_published', true)
            ->where(fn ($q) => $q->whereNull('expired_at')->orWhere('expired_at', '>', now()))
            ->firstOrFail();

        $validated = $request->validate([
            'nama'       => ['required', 'string', 'max:255'],
            'nip'        => [
                'required', 'string', 'max:30',
                Rule::unique('notice_reports')->where('event_id', $event->id),
            ],
            'unit_kerja' => ['required', 'string', 'max:255'],
        ], [
            'nama.required'       => 'Nama wajib diisi.',
            'nip.required'        => 'NIP wajib diisi.',
            'nip.unique'          => 'NIP ini sudah tercatat melaporkan pada pemberitahuan ini.',
            'unit_kerja.required' => 'Unit kerja wajib diisi.',
        ]);

        $validated['event_id'] = $event->id;

        NoticeReport::create($validated);

        return redirect()->route('invitation.show', $slug)
            ->with('report_success', 'Konfirmasi pelaporan Anda berhasil dicatat. Terima kasih!');
    }
}
