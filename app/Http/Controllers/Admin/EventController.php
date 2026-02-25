<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $query = Event::with(['user', 'package', 'template'])->latest();

        if ($request->filled('status')) {
            match ($request->status) {
                'draft'   => $query->where('is_published', false),
                'aktif'   => $query->where('is_published', true)
                                   ->where(fn ($q) => $q->whereNull('expired_at')->orWhere('expired_at', '>', now())),
                'expired' => $query->where('is_published', true)->where('expired_at', '<=', now()),
                default   => null,
            };
        }

        $events = $query->paginate(15)->withQueryString();

        return view('admin.events.index', compact('events'));
    }

    public function show(Event $event): View
    {
        $event->load(['user', 'package', 'template', 'guests', 'wishes']);

        return view('admin.events.show', compact('event'));
    }

    public function unpublish(Event $event): RedirectResponse
    {
        $event->update([
            'is_published' => false,
            'expired_at'   => null,
        ]);

        return redirect()->route('admin.events.show', $event)
            ->with('success', 'Undangan berhasil di-unpublish.');
    }
}
