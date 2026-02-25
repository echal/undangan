<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SystemSettingController extends Controller
{
    public function edit(): View
    {
        $settings = SystemSetting::current();

        return view('admin.system.edit', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'maintenance_type'     => ['required', 'in:disabled,manual,scheduled'],
            'maintenance_start_at' => ['nullable', 'date', 'required_if:maintenance_type,scheduled'],
            'maintenance_end_at'   => ['nullable', 'date', 'after:maintenance_start_at'],
            'maintenance_title'    => ['required', 'string', 'max:255'],
            'maintenance_message'  => ['required', 'string'],
            'contact_email'        => ['nullable', 'email', 'max:255'],
        ]);

        SystemSetting::current()->update($validated + ['updated_at' => now()]);

        return redirect()
            ->route('admin.system.edit')
            ->with('success', 'Pengaturan sistem berhasil disimpan.');
    }
}
