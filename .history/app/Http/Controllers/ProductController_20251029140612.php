<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)->get();
        // Add image_url to each product for JavaScript
        $products->each(function ($product) {
            $product->image_url = $product->image ? asset($product->image) : null;
        });
        return view('katalog', compact('products'));
    }

    public function adminIndex()
    {
        $products = Product::all();
        $admin = auth('admin')->user();
        return view('admin.products.index', compact('products', 'admin'));
    }

    public function store(Request $request)
    {
        // Debug: Check if file is uploaded
        if ($request->hasFile('image')) {
            Log::info('File uploaded: ' . $request->file('image')->getClientOriginalName());
        } else {
            Log::info('No file uploaded');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed: ' . json_encode($validator->errors()));

            // Check if request is AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            // Store in public/img/baju-img directory
            $image->move(public_path('img/baju-img'), $imageName);
            $data['image'] = 'img/baju-img/' . $imageName;
            Log::info('Image stored at: public/img/baju-img/' . $imageName);
        }

        // Calculate discount percentage if original_price is provided
        if ($data['original_price'] && $data['original_price'] > $data['price']) {
            $data['discount_percentage'] = round((($data['original_price'] - $data['price']) / $data['original_price']) * 100, 2);
        }

        // Set default values
        $data['is_active'] = true;

        $product = Product::create($data);
        Log::info('Product created with ID: ' . $product->id);

        // Check if request is AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan!',
                'product' => $product
            ]);
        }

        return redirect()->route('admin.dashboard')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $admin = auth('admin')->user();
        return view('admin.products.edit', compact('product', 'admin'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            // Store in public/img/baju-img directory
            $image->move(public_path('img/baju-img'), $imageName);
            $data['image'] = 'img/baju-img/' . $imageName;
        }

        // Calculate discount percentage if original_price is provided
        if ($data['original_price'] && $data['original_price'] > $data['price']) {
            $data['discount_percentage'] = round((($data['original_price'] - $data['price']) / $data['original_price']) * 100, 2);
        } else {
            $data['discount_percentage'] = null;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    public function show($id)
{
    $product = Product::findOrFail($id);

    // Pastikan ada URL gambar untuk ditampilkan
    $product->image_url = $product->image ? asset($product->image) : asset('img/default.jpg');

    return view('detail_product', compact('product'));
}

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete image if exists
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
