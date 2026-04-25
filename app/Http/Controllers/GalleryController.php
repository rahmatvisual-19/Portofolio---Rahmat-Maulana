<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'photo'       => 'required|image|max:5120',
        ]);

        Gallery::create([
            'title'       => $request->title,
            'description' => $request->description,
            'image_path'  => $request->file('photo')->store('gallery', 'public'),
        ]);

        return back()->with('success', 'Foto berhasil ditambahkan.');
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'photo'       => 'nullable|image|max:5120',
        ]);

        $data = [
            'title'       => $request->title,
            'description' => $request->description,
        ];

        if ($request->hasFile('photo')) {
            $data['image_path'] = $request->file('photo')->store('gallery', 'public');
        }

        $gallery->update($data);

        return back()->with('success', 'Foto berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return back()->with('success', 'Foto berhasil dihapus.');
    }
}
