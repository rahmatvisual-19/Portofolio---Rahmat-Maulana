<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'nullable|string|max:255',
            'content' => 'required|string',
            'photo'   => 'required|image|max:2048',
        ]);

        $path = $request->file('photo')->store('stories', 'public');

        Story::create([
            'title'      => $request->title,
            'content'    => $request->content,
            'image_path' => $path,
            'order'      => Story::max('order') + 1,
        ]);

        return back()->with('success', 'Story block berhasil ditambahkan.');
    }

    public function update(Request $request, Story $story)
    {
        $request->validate([
            'title'   => 'nullable|string|max:255',
            'content' => 'required|string',
            'photo'   => 'nullable|image|max:2048',
        ]);

        $data = [
            'title'   => $request->title,
            'content' => $request->content,
        ];

        if ($request->hasFile('photo')) {
            $data['image_path'] = $request->file('photo')->store('stories', 'public');
        }

        $story->update($data);

        return back()->with('success', 'Story block berhasil diperbarui.');
    }

    public function destroy(Story $story)
    {
        $story->delete();
        return back()->with('success', 'Story block berhasil dihapus.');
    }
}
