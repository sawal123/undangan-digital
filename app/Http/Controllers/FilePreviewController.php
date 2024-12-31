<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilePreviewController extends Controller
{
    public function show(Request $request, $filename)
    {
        // Pastikan file tersedia di storage
        if (Storage::disk('local')->exists("livewire-tmp/$filename")) {
            return response()->file(storage_path("app/livewire-tmp/$filename"));
        }
        abort(404);
    }
}
