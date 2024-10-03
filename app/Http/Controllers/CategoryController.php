<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        //
        $title = "Setting";
        session(['halaman' => $title]);
        $categories = Category::all();
        return view('admin.setting', [
            'categories'=>$categories,
            'halaman'=>$title
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category' => 'required|string|max:255',
            'icon' => 'required|image|mimes:png,jpg,jpeg'
        ]);
        DB::beginTransaction();
        try {
            DB::commit();
            if ($request->hasFile('icon')) {
                $iconPath = $request->file('icon')->store('icons', 'public');
                $validatedData['icon'] = $iconPath;
            } else {
                $iconPath = 'images/icon-category-default.png';
            }
            $category = Category::create($validatedData);
            $count = Category::all();
            return response()->json([
                'success' => true,
                'message' => 'Category Berhasil Disimpan!',
                'data' => $category,
                'count' => $count->count()
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {

        try {
            $validated = $request->validate([
                'category' => 'required|string|max:255',
                'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // validasi file
            ]);
            if ($request->hasFile('icon')) {
                $iconPath = $request->file('icon')->store('icons', 'public');
                $category->icon = $iconPath;
            }

            $category->category = $validated['category'];
            $category->save();

            return response()->json(['success' => true, 'message' => 'Category updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
        DB::beginTransaction();
        try {
            if($category->icon){
                Storage::disk('public')->delete($category->icon);
            }
            $category->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Category Berhasil dihapus!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
