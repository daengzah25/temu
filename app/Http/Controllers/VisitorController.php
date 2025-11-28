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
        $radius = $request->get('radius_km', 50); // Default radius 50km (sangat luas)
        $searchQuery = $request->get('q');

        // Jika tidak ada lokasi, tampilkan form request lokasi
        if (!$lat || !$lng) {
            return view('visitor.nearby', [
                'companies' => collect([]),
                'needLocation' => true,
                'searchQuery' => $searchQuery,
            ]);
        }

        // Validasi koordinat
        $lat = (float) $lat;
        $lng = (float) $lng;
        $radius = max(5, min(100, (float) $radius)); // Clamp radius antara 5-100 km

        // Query dasar
        $query = Company::where('status', 'approved');

        // Filter pencarian jika ada
        if ($searchQuery) {
            $query->where(function ($q) use ($searchQuery) {
                // Pencarian di field company
                $q->where('name', 'like', "%{$searchQuery}%")
                  ->orWhere('category', 'like', "%{$searchQuery}%")
                  ->orWhere('description', 'like', "%{$searchQuery}%")
                  ->orWhere('address', 'like', "%{$searchQuery}%")
                  // Pencarian di produk (nama dan deskripsi produk)
                  ->orWhereHas('products', function ($productQuery) use ($searchQuery) {
                      $productQuery->where('is_active', true)
                                   ->where(function ($pq) use ($searchQuery) {
                                       $pq->where('name', 'like', "%{$searchQuery}%")
                                          ->orWhere('description', 'like', "%{$searchQuery}%");
                                   });
                  });
            });
        }

        // Haversine query untuk menghitung jarak
        $companies = $query->select('companies.*')
            ->selectRaw("
                (6371 * acos(
                    GREATEST(-1, LEAST(1,
                        cos(radians(?)) *
                        cos(radians(latitude)) *
                        cos(radians(longitude) - radians(?)) +
                        sin(radians(?)) *
                        sin(radians(latitude))
                    ))
                )) AS distance_km
            ", [$lat, $lng, $lat])
            ->havingRaw('distance_km <= ?', [$radius])
            ->orderBy('distance_km', 'asc')
            ->with(['user:id,name,avatar', 'products' => function ($productQuery) {
                $productQuery->where('is_active', true)->with('images');
            }])
            ->get();

        return view('visitor.nearby', [
            'companies' => $companies,
            'needLocation' => false,
            'userLat' => $lat,
            'userLng' => $lng,
            'radius' => $radius,
            'searchQuery' => $searchQuery,
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
