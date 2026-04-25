<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'company'  => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'desc'     => 'required|string',
            'img'      => 'required|image|max:2048',
        ]);

        $path = $request->file('img')->store('projects', 'public');

        Project::create([
            'title'      => $request->title,
            'company'    => $request->company,
            'category'   => $request->category,
            'description'=> $request->desc,
            'image_path' => $path,
            'order'      => Project::max('order') + 1,
        ]);

        return back()->with('success', 'Project berhasil ditambahkan.');
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'company'  => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'desc'     => 'required|string',
            'img'      => 'nullable|image|max:2048',
        ]);

        $data = [
            'title'       => $request->title,
            'company'     => $request->company,
            'category'    => $request->category,
            'description' => $request->desc,
        ];

        if ($request->hasFile('img')) {
            $data['image_path'] = $request->file('img')->store('projects', 'public');
        }

        $project->update($data);

        return back()->with('success', 'Project berhasil diperbarui.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return back()->with('success', 'Project berhasil dihapus.');
    }
}
