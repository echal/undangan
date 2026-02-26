<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class UserApprovalController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status', 'pending');

        $users = User::where('role', 'user')
            ->withCount('events')
            ->when($status !== 'all', fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(20);

        $counts = [
            'all'      => User::where('role', 'user')->count(),
            'pending'  => User::where('role', 'user')->where('status', 'pending')->count(),
            'approved' => User::where('role', 'user')->where('status', 'approved')->count(),
            'rejected' => User::where('role', 'user')->where('status', 'rejected')->count(),
        ];

        return view('admin.users.index', compact('users', 'status', 'counts'));
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role'     => ['required', 'in:user,admin'],
            'status'   => ['required', 'in:pending,approved,rejected'],
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'status'   => $request->status,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', "User {$request->name} berhasil ditambahkan.");
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->isAdmin() && User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'Tidak dapat menghapus satu-satunya admin.');
        }

        $user->delete();

        return back()->with('success', "User {$user->name} berhasil dihapus.");
    }

    public function approve(Request $request, User $user): RedirectResponse
    {
        $user->update([
            'status'           => 'approved',
            'rejection_reason' => null,
        ]);

        return back()->with('success', "User {$user->name} berhasil disetujui.");
    }

    public function reject(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'rejection_reason' => ['required', 'string', 'max:500'],
        ]);

        $user->update([
            'status'           => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', "User {$user->name} telah ditolak.");
    }
}
