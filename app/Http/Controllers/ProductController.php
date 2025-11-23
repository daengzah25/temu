<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // List produk UMKM
    public function index()
    {
        $company = Auth::user()->company;

        if (!$company || $company->status !== 'approved') {
            return redirect()->route('umkm.dashboard');
        }

        $products = $company->products()->with('images')->latest()->get();

        return view('umkm.products.index', compact('products', 'company'));
    }

    // Form tambah produk
    public function create()
    {
        $company = Auth::user()->company;

        if (!$company || $company->status !== 'approved') {
            return redirect()->route('umkm.dashboard');
        }

        return view('umkm.products.create', compact('company'));
    }

    // Simpan produk
    public function store(Request $request)
    {
        $company = Auth::user()->company;

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Buat produk
        $product = Product::create([
            'company_id' => $company->id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'is_active' => true,
        ]);

        // Upload multiple images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('products', $filename, 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'order' => $index,
                ]);
            }
        }

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    // Form edit produk
    public function edit($id)
    {
        $company = Auth::user()->company;
        $product = Product::where('company_id', $company->id)
            ->with('images')
            ->findOrFail($id);

        return view('umkm.products.edit', compact('product', 'company'));
    }

    // Update produk
    public function update(Request $request, $id)
    {
        $company = Auth::user()->company;
        $product = Product::where('company_id', $company->id)->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update data produk
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        // Upload new images jika ada
        if ($request->hasFile('images')) {
            $currentMaxOrder = $product->images()->max('order') ?? -1;

            foreach ($request->file('images') as $index => $image) {
                $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('products', $filename, 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'order' => $currentMaxOrder + $index + 1,
                ]);
            }
        }

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diupdate!');
    }

    // Hapus gambar produk
    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);
        $company = Auth::user()->company;

        // Cek ownership
        if ($image->product->company_id !== $company->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Hapus file
        Storage::disk('public')->delete($image->image_path);

        // Hapus record
        $image->delete();

        return response()->json(['success' => true, 'message' => 'Gambar berhasil dihapus']);
    }

    // Hapus produk
    public function destroy($id)
    {
        $company = Auth::user()->company;
        $product = Product::where('company_id', $company->id)->findOrFail($id);

        // Hapus semua gambar
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        // Hapus produk
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }

    // Toggle active status
    public function toggleActive($id)
    {
        $company = Auth::user()->company;
        $product = Product::where('company_id', $company->id)->findOrFail($id);

        $product->is_active = !$product->is_active;
        $product->save();

        return response()->json([
            'success' => true,
            'is_active' => $product->is_active,
            'message' => $product->is_active ? 'Produk diaktifkan' : 'Produk dinonaktifkan',
        ]);
    }
}
