<?php

use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\SystemSettingController;
use App\Http\Controllers\Admin\TemplateController;
use App\Http\Controllers\Admin\MusicLibraryController;
use App\Http\Controllers\Admin\UserApprovalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\InvitationController;
use App\Http\Controllers\Public\StatusController;
use App\Http\Controllers\User\EventController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
})->name('landing');

// ── Halaman Maintenance (public, tidak butuh auth) ──
Route::get('/maintenance', function () {
    $settings = \App\Models\SystemSetting::current();
    return view('maintenance.index', [
        'maintenanceEndAt' => $settings->maintenance_end_at,
        'settings'         => $settings,
    ]);
})->name('maintenance');

// ── Public Status Page per Announcement ──
Route::get('/status/{slug}', [StatusController::class, 'show'])->name('status.show');

// ── Status Akun (public — tidak butuh auth untuk rejected) ──
Route::get('/account/pending', function () {
    return view('account.pending');
})->name('account.pending');

Route::get('/account/rejected', function () {
    return view('account.rejected');
})->name('account.rejected');

// Redirect /dashboard ke dashboard sesuai role
Route::get('/dashboard', function () {
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified', 'approved'])->name('dashboard');

// Dashboard Admin + Management
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('packages', PackageController::class)->except(['show']);
    Route::resource('templates', TemplateController::class)->except(['show']);

    Route::get('/events', [AdminEventController::class, 'index'])->name('events.index');
    Route::get('/events/{event}', [AdminEventController::class, 'show'])->name('events.show');
    Route::put('/events/{event}/unpublish', [AdminEventController::class, 'unpublish'])->name('events.unpublish');

    // Music Library Management
    Route::resource('music', MusicLibraryController::class)->except(['show', 'edit', 'update']);
    Route::patch('/music/{music}/toggle', [MusicLibraryController::class, 'toggleActive'])->name('music.toggle');

    // User Approval Management
    Route::get('/users', [UserApprovalController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserApprovalController::class, 'create'])->name('users.create');
    Route::post('/users', [UserApprovalController::class, 'store'])->name('users.store');
    Route::put('/users/{user}/approve', [UserApprovalController::class, 'approve'])->name('users.approve');
    Route::put('/users/{user}/reject', [UserApprovalController::class, 'reject'])->name('users.reject');
    Route::delete('/users/{user}', [UserApprovalController::class, 'destroy'])->name('users.destroy');

    // System Settings (Maintenance Mode)
    Route::get('/system', [SystemSettingController::class, 'edit'])->name('system.edit');
    Route::put('/system', [SystemSettingController::class, 'update'])->name('system.update');

    // Announcements
    Route::resource('announcements', AnnouncementController::class)->except(['show']);
    Route::put('announcements/{announcement}/publish', [AnnouncementController::class, 'publish'])->name('announcements.publish');
    Route::put('announcements/{announcement}/archive', [AnnouncementController::class, 'archive'])->name('announcements.archive');
    Route::post('announcements/{announcement}/log', [AnnouncementController::class, 'addLog'])->name('announcements.log');
});

// Dashboard User + CRUD Event
Route::middleware(['auth', 'verified', 'approved', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');

    Route::resource('events', EventController::class);
    Route::put('events/{event}/publish', [EventController::class, 'publish'])->name('events.publish');
    Route::get('events/{event}/export-guests', [EventController::class, 'exportGuests'])->name('events.export-guests');
});

Route::middleware(['auth', 'approved'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Halaman Undangan Publik
Route::get('/invitation/{slug}', [InvitationController::class, 'show'])->name('invitation.show');
Route::post('/invitation/{slug}/rsvp', [InvitationController::class, 'rsvp'])->name('invitation.rsvp');
Route::post('/invitation/{slug}/wish', [InvitationController::class, 'wish'])->name('invitation.wish');
Route::get('/invitation/{slug}/ics', [InvitationController::class, 'calendar'])->name('invitation.ics');

require __DIR__.'/auth.php';
