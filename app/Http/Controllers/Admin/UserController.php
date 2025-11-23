<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // List semua user
    public function index(Request $request)
    {
        $role = $request->get('role', 'all');

        $users = User::when($role !== 'all', function ($query) use ($role) {
                $query->where('role', $role);
            })
            ->with('company')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.users.index', compact('users', 'role'));
    }

    // Detail user
    public function show($id)
    {
        $user = User::with('company', 'bookmarks')->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    // Update role user
    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,umkm,visitor',
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return redirect()->back()->with('success', 'Role user berhasil diubah!');
    }

    // Ban/Unban user
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        $user->status = $user->status === 'active' ? 'banned' : 'active';
        $user->save();

        $message = $user->status === 'banned' ? 'User berhasil dinonaktifkan!' : 'User berhasil diaktifkan!';

        return redirect()->back()->with('success', $message);
    }

    // Hapus user
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Jangan bisa hapus diri sendiri
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus akun sendiri!');
        }

        // Hapus company jika ada
        if ($user->company) {
            $user->company->delete();
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }
}
