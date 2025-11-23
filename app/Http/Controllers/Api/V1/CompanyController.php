<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    /**
     * Get nearby companies using Haversine formula
     */
    public function nearby(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
            'radius_km' => 'nullable|numeric|min:1|max:50',
        ]);

        $lat = $request->lat;
        $lng = $request->lng;
        $radius = $request->radius_km ?? 10;

        // Haversine formula - FIX BINDING
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
            ->get()
            ->map(function ($company) {
                return [
                    'id' => $company->id,
                    'name' => $company->name,
                    'slug' => $company->slug,
                    'logo' => $company->logo ? asset('storage/' . $company->logo) : null,
                    'category' => $company->category,
                    'description' => $company->description,
                    'address' => $company->address,
                    'whatsapp' => $company->whatsapp,
                    'operating_hours' => $company->operating_hours,
                    'latitude' => (float) $company->latitude,
                    'longitude' => (float) $company->longitude,
                    'distance_km' => round($company->distance_km, 2),
                    'owner' => [
                        'name' => $company->user->name,
                        'avatar' => $company->user->avatar,
                    ],
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $companies,
            'meta' => [
                'total' => $companies->count(),
                'radius_km' => $radius,
                'center' => [
                    'lat' => (float) $lat,
                    'lng' => (float) $lng,
                ],
            ],
        ]);
    }

    /**
     * Get company detail by slug
     */
    public function show($slug)
    {
        $company = Company::where('slug', $slug)
            ->where('status', 'approved')
            ->with(['user:id,name,avatar', 'products' => function ($query) {
                $query->where('is_active', true)->with('images');
            }])
            ->first();

        if (!$company) {
            return response()->json([
                'success' => false,
                'message' => 'UMKM tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $company->id,
                'name' => $company->name,
                'slug' => $company->slug,
                'logo' => $company->logo ? asset('storage/' . $company->logo) : null,
                'category' => $company->category,
                'description' => $company->description,
                'address' => $company->address,
                'whatsapp' => $company->whatsapp,
                'operating_hours' => $company->operating_hours,
                'latitude' => (float) $company->latitude,
                'longitude' => (float) $company->longitude,
                'owner' => [
                    'name' => $company->user->name,
                    'avatar' => $company->user->avatar,
                ],
                'products' => $company->products->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'description' => $product->description,
                        'price' => (float) $product->price,
                        'stock' => $product->stock,
                        'images' => $product->images->map(function ($image) {
                            return asset('storage/' . $image->image_path);
                        }),
                    ];
                }),
            ],
        ]);
    }
}
