<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PexesoController extends Controller
{
    public function index()
    {
        return view('pexeso');
    }

    public function showUpdateImageForm()
    {
        return view('update-image');
    }

    public function updateImage(Request $request)
    {
        $request->validate([
            'game_image' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        if ($request->hasFile('game_image')) {
            $image = $request->file('game_image');
            $imageName = 'game-image.png';
            
            // Store in public/storage directory
            $destinationPath = public_path('storage');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $imageName);
            
            return redirect()->route('update.image.form')->with('success', 'Game image updated successfully!');
        }

        return redirect()->route('update.image.form')->with('error', 'Failed to update image. Please try again.');
    }
}