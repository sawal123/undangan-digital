<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        session(['halaman' => 'Theme']);
        $theme = Theme::all();
        $categories = Category::all();
        return view('admin.theme', [
            'themes' => $theme,
            'categories' => $categories
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
        $validasi = $request->validate([
            'nama' => 'required|string|max:255',
            'category_id' => 'required',
            'path' => 'required|string|max:255',
            'demo' => 'nullable|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:1024'
        ]);
        DB::beginTransaction();
        try {
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('thumbnail', 'public');
                $validasi['thumbnail'] = $thumbnailPath;
            }
            $theme = Theme::create($validasi);
            DB::commit();
            $themeWithCategory = Theme::with('category')->find($theme->id);
            return response()->json([
                'success' => true,
                'message' => 'Theme Berhasil Disimpan!',
                'data' => $themeWithCategory,
                'count' => $theme->count(),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => $validasi['demo'],
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Theme $theme)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Theme $theme)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Theme $theme)
    {
        //
        $validasi = $request->validate([
            'nama' => 'required|string|max:255',
            'category_id' => 'required',
            'path' => 'required|string|max:255',
            'demo' => 'nullable|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:1024'
        ]);
        try {
            
            if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail')->store('thumbnail', 'public');
                $theme->thumbnail = $thumbnail;
            }

            $theme->nama = $validasi['nama'];
            $theme->category_id = $validasi['category_id'];
            $theme->path = $validasi['path'];
            $theme->demo = $validasi['demo'];
            $theme->save();

            return response()->json(['success' => true, 'message' => 'Theme updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Theme $theme)
    {
        DB::beginTransaction();
        try {
            if ($theme->thumbnail) {
                Storage::disk('public')->delete($theme->thumbnail);
            }
            $theme->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'theme Berhasil dihapus!',
                'data' => $theme,
                'count' => Theme::count(),
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
