<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\ApprovalLog;
use App\Models\User;
use App\Notifications\CompanyApprovedNotification;
use App\Notifications\CompanyRejectedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Dashboard Admin
    public function dashboard()
    {
        $stats = [
            'pending' => Company::where('status', 'pending')->count(),
            'approved' => Company::where('status', 'approved')->count(),
            'rejected' => Company::where('status', 'rejected')->whereDate('updated_at', today())->count(),
            'total_users' => User::count(),
        ];

        $pendingCompanies = Company::where('status', 'pending')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'pendingCompanies'));
    }

    // List semua UMKM
    public function companies(Request $request)
    {
        $status = $request->get('status', 'pending');

        $companies = Company::with('user')
            ->when($status !== 'all', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.companies', compact('companies', 'status'));
    }

    // Detail UMKM untuk review
    public function showCompany($id)
    {
        $company = Company::with('user')->findOrFail($id);
        return view('admin.company-detail', compact('company'));
    }

    // Approve UMKM
    public function approve($id)
    {
        $company = Company::with('user')->findOrFail($id);

        $company->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
            'rejection_reason' => null,
        ]);

        // Log activity
        ApprovalLog::create([
            'company_id' => $company->id,
            'admin_id' => Auth::id(),
            'action' => 'approved',
        ]);

        // Kirim email notifikasi
        try {
            $company->user->notify(new CompanyApprovedNotification($company));
        } catch (\Exception $e) {
            // Jika email gagal, tetap lanjut (log error jika perlu)
        }

        return redirect()->back()->with('success', 'UMKM "' . $company->name . '" berhasil disetujui! Email notifikasi telah dikirim.');
    }

    // Reject UMKM
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|min:10',
        ]);

        $company = Company::with('user')->findOrFail($id);

        $company->update([
            'status' => 'rejected',
            'rejection_reason' => $request->reason,
        ]);

        // Log activity
        ApprovalLog::create([
            'company_id' => $company->id,
            'admin_id' => Auth::id(),
            'action' => 'rejected',
            'reason' => $request->reason,
        ]);

        // Kirim email notifikasi
        try {
            $company->user->notify(new CompanyRejectedNotification($company));
        } catch (\Exception $e) {
            // Jika email gagal, tetap lanjut
        }

        return redirect()->back()->with('success', 'UMKM "' . $company->name . '" ditolak. Email notifikasi telah dikirim.');
    }
}
