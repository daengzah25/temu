<?php

namespace App\Http\Controllers;

use App\Models\AiPromotion;
use App\Models\Product;
use App\Services\HuggingFaceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AiPromotionController extends Controller
{
    protected $aiService;

    public function __construct(HuggingFaceService $aiService)
    {
        $this->aiService = $aiService;
    }

    // Halaman form AI Promosi
    public function index()
    {
        $company = Auth::user()->company;

        if (!$company || $company->status !== 'approved') {
            return redirect()->route('umkm.dashboard');
        }

        $products = $company->products()->where('is_active', true)->get();
        $promotions = AiPromotion::where('company_id', $company->id)
            ->latest()
            ->take(10)
            ->get();

        return view('umkm.ai-promotion.index', compact('company', 'products', 'promotions'));
    }

    // Generate konten promosi
    public function generate(Request $request)
    {
        $request->validate([
            'product_id' => 'nullable|exists:products,id',
            'product_name' => 'required|string|max:255',
            'price' => 'required|string',
            'description' => 'required|string',
            'target_audience' => 'required|string',
        ]);

        $company = Auth::user()->company;

        // Call AI Service
        $result = $this->aiService->generatePromotion([
            'product_name' => $request->product_name,
            'price' => $request->price,
            'description' => $request->description,
            'target_audience' => $request->target_audience,
        ]);

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'error' => $result['error'] ?? 'Gagal generate konten. Coba lagi nanti.',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'data' => $result['data'],
        ]);
    }

    // Simpan konten promosi
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'nullable|exists:products,id',
            'platform' => 'required|in:instagram,whatsapp,facebook',
            'prompt' => 'required|string',
            'result' => 'required|string',
        ]);

        $company = Auth::user()->company;

        AiPromotion::create([
            'company_id' => $company->id,
            'product_id' => $request->product_id,
            'platform' => $request->platform,
            'prompt' => $request->prompt,
            'result' => $request->result,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Konten berhasil disimpan!',
        ]);
    }

    // Hapus promosi
    public function destroy($id)
    {
        $company = Auth::user()->company;
        $promotion = AiPromotion::where('company_id', $company->id)->findOrFail($id);

        $promotion->delete();

        return redirect()->back()->with('success', 'Promosi berhasil dihapus!');
    }
}
