<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TemplateController extends Controller
{
    public function index(): View
    {
        $templates = Template::latest()->paginate(10);

        return view('admin.templates.index', compact('templates'));
    }

    public function create(): View
    {
        return view('admin.templates.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'event_type'    => ['required', 'string', 'in:pernikahan,buka_puasa,workshop'],
            'preview_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status'        => ['boolean'],
        ]);

        $validated['slug']   = Str::slug($validated['name']) . '-' . uniqid();
        $validated['status'] = $request->boolean('status');

        if ($request->hasFile('preview_image')) {
            $validated['preview_image'] = $request->file('preview_image')
                ->store('templates', 'public');
        }

        Template::create($validated);

        return redirect()->route('admin.templates.index')
            ->with('success', 'Template berhasil ditambahkan.');
    }

    public function edit(Template $template): View
    {
        return view('admin.templates.edit', compact('template'));
    }

    public function update(Request $request, Template $template): RedirectResponse
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'event_type'    => ['required', 'string', 'in:pernikahan,buka_puasa,workshop'],
            'preview_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status'        => ['boolean'],
        ]);

        $validated['status'] = $request->boolean('status');

        if ($request->hasFile('preview_image')) {
            $validated['preview_image'] = $request->file('preview_image')
                ->store('templates', 'public');
        }

        $template->update($validated);

        return redirect()->route('admin.templates.index')
            ->with('success', 'Template berhasil diperbarui.');
    }

    public function destroy(Template $template): RedirectResponse
    {
        $template->delete();

        return redirect()->route('admin.templates.index')
            ->with('success', 'Template berhasil dihapus.');
    }
}
