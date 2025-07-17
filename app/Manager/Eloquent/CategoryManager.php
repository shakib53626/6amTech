<?php

namespace App\Manager\Eloquent;

use App\Models\Category;
use Illuminate\Support\Str;
use App\Manager\CategoryManagerInterface;
use Illuminate\Support\Facades\Storage;

class CategoryManager implements CategoryManagerInterface
{
    public function index($request)
    {
        $paginateSize = $request->input('paginate_size') ?? 50;

        $query = Category::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $categories = $query->orderBy('created_at', 'desc')->paginate($paginateSize);

        return [
            'categories' => $categories,
        ];
    }

    public function store($request)
    {
        $category = new Category();
        $category->name   = $request->name;
        $category->slug   = Str::slug($request->name);
        $category->status = $request->status ?? 'Active';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('categories')) {
                Storage::disk('public')->makeDirectory('categories');
            }

            $image->storeAs('categories', $filename, 'public');
            $category->image = '/storage/categories/' . $filename;
        }

        $category->save();

        return $category;
    }

    public function update($id, $request)
    {
        $category = Category::findOrFail($id);
        $category->name   = $request->name;
        $category->slug   = Str::slug($request->name);
        $category->status = $request->status ?? $category->status;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('categories')) {
                Storage::disk('public')->makeDirectory('categories');
            }

            if ($category->image && Storage::disk('public')->exists(str_replace('/storage/', '', $category->image))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $category->image));
            }

            $image->storeAs('categories', $filename, 'public');
            $category->image = '/storage/categories/' . $filename;
        }

        $category->save();

        return $category;
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->image && Storage::disk('public')->exists(str_replace('/storage/', '', $category->image))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $category->image));
        }

        $category->delete();

        return $category;
    }
}
