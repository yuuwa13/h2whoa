<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\UploadedImage;
use Illuminate\Support\Facades\Log;
use App\Models\GcashDetail;

class ImageUploadController extends Controller
{
    // Handle image upload
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        $file = $request->file('image');
        $path = $file->store('image_uploads', 'public');
        Log::info('File stored at: ' . $path);

        UploadedImage::create([
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
        ]);
        Log::info('Uploading file: ' . $file->getClientOriginalName());
        Log::info('File path: ' . $path);
        return redirect()->back()->with('success', 'Image uploaded successfully!');
    }

    // Display all uploaded images
    public function index()
    {
        $images = UploadedImage::all()->map(function ($image) {
            $url = asset('storage/' . str_replace('public/', '', $image->file_path));
            Log::info('Corrected image URL: ' . $url);
            return [
                'id' => $image->id,
                'url' => $url,
                'file_name' => $image->file_name, // Include file_name key
            ];
        });

        $gcashImages = GcashDetail::whereNotNull('image')->get();

        return view('upload_image.upload_image', compact('images', 'gcashImages'));
    }

    // Delete an uploaded image
    public function delete($id)
    {
        $image = UploadedImage::findOrFail($id);
        Storage::delete($image->file_path);
        $image->delete();

        return redirect()->back()->with('success', 'Image deleted successfully!');
    }
}