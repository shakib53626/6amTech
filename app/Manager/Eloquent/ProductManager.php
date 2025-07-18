<?php

namespace App\Manager\Eloquent;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Manager\ProductManagerInterface;

class ProductManager implements ProductManagerInterface
{
    public function index($request)
    {
        $paginateSize = $request->input('paginate_size') ?? 50;

        $query = Product::query()->with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%')
                  ->orWhere('sku', 'like', '%' . $request->input('search') . '%');
        }

        $products = $query->orderBy('created_at', 'desc')->paginate($paginateSize);

        return [
            'products'   => $products,
            'categories' => Category::select('id', 'name')->get(),
        ];
    }

    public function store($request)
    {
        $product = new Product();
        $product->name        = $request->name;
        $product->slug        = Str::slug($request->name);
        $product->sku         = $request->sku;
        $product->stock       = $request->stock ?? 0;
        $product->price       = $request->price ?? 0;
        $product->discount    = $request->discount ?? 0;
        $product->sell_price  = $request->sell_price ?? 0;
        $product->description = $request->description;
        $product->category_id = $request->category_id;
        $product->status      = $request->status;

        if ($request->hasFile('image')) {
            $image    = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('products')) {
                Storage::disk('public')->makeDirectory('products');
            }

            $image->storeAs('products', $filename, 'public');
            $product->image = '/storage/products/' . $filename;
        }

        $product->save();

        return $product;
    }

    public function update($id, $request)
    {
        $product = Product::findOrFail($id);
        $product->name        = $request->name;
        $product->slug        = Str::slug($request->name);
        $product->sku         = $request->sku;
        $product->stock       = $request->stock;
        $product->price       = $request->price;
        $product->discount    = $request->discount;
        $product->sell_price  = $request->sell_price;
        $product->description = $request->description;
        $product->category_id = $request->category_id;
        $product->status      = $request->status;

        if ($request->hasFile('image')) {
            $image    = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('products')) {
                Storage::disk('public')->makeDirectory('products');
            }

            if ($product->image && Storage::disk('public')->exists(str_replace('/storage/', '', $product->image))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $product->image));
            }

            $image->storeAs('products', $filename, 'public');
            $product->image = '/storage/products/' . $filename;
        }

        $product->save();

        return $product;
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image && Storage::disk('public')->exists(str_replace('/storage/', '', $product->image))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $product->image));
        }

        $product->delete();

        return $product;
    }
}
