<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    // Toggle bookmark (add/remove)
    public function toggle($companyId)
    {
        $user = Auth::user();

        $bookmark = Bookmark::where('user_id', $user->id)
            ->where('company_id', $companyId)
            ->first();

        if ($bookmark) {
            // Remove bookmark
            $bookmark->delete();
            return response()->json([
                'success' => true,
                'bookmarked' => false,
                'message' => 'Dihapus dari favorit',
            ]);
        } else {
            // Add bookmark
            Bookmark::create([
                'user_id' => $user->id,
                'company_id' => $companyId,
            ]);
            return response()->json([
                'success' => true,
                'bookmarked' => true,
                'message' => 'Ditambahkan ke favorit',
            ]);
        }
    }

    // List semua bookmark user
    public function index()
    {
        $user = Auth::user();

        $bookmarks = Bookmark::where('user_id', $user->id)
            ->with(['company' => function ($query) {
                $query->where('status', 'approved')->with('user:id,name,avatar');
            }])
            ->latest()
            ->get()
            ->filter(function ($bookmark) {
                return $bookmark->company !== null; // Filter yang company-nya masih ada
            });

        return view('visitor.bookmarks', compact('bookmarks'));
    }
}
