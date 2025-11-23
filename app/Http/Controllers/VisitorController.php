<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitorController extends Controller
{
    // Halaman home visitor
    public function home()
    {
        return view('visitor.home');
    }

    // List UMKM terdekat
    public function nearby(Request $request)
    {
        $lat = $request->get('lat');
        $lng = $request->get('lng');
        $radius = $request->get('radius_km', 10);

        if (!$lat || !$lng) {
            return view('visitor.nearby', [
                'companies' => collect([]),
                'needLocation' => true,
            ]);
        }

        // Haversine query - FIX BINDING
        $companies = Company::select('companies.*')
            ->selectRaw("
                (6371 * acos(
                    cos(radians(?)) *
                    cos(radians(latitude)) *
                    cos(radians(longitude) - radians(?)) +
                    sin(radians(?)) *
                    sin(radians(latitude))
                )) AS distance_km
            ", [$lat, $lng, $lat])
            ->where('status', 'approved')
            ->havingRaw('distance_km <= ?', [$radius])
            ->orderBy('distance_km', 'asc')
            ->with('user:id,name,avatar')
            ->get();

        return view('visitor.nearby', [
            'companies' => $companies,
            'needLocation' => false,
            'userLat' => $lat,
            'userLng' => $lng,
            'radius' => $radius,
        ]);
    }

    // Detail UMKM
    public function show($slug)
    {
        $company = Company::where('slug', $slug)
            ->where('status', 'approved')
            ->with(['user:id,name,avatar', 'products' => function ($query) {
                $query->where('is_active', true)->with('images');
            }])
            ->firstOrFail();

        return view('visitor.company-detail', compact('company'));
    }
}
