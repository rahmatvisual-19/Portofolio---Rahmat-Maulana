<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'company'    => 'required|string|max:255',
            'role'       => 'required|string|max:255',
            'start_year' => 'required|string|max:20',
            'end_year'   => 'nullable|string|max:20',
            'description'=> 'nullable|string',
        ]);

        Experience::create([
            'company'     => $request->company,
            'role'        => $request->role,
            'start_year'  => $request->start_year,
            'end_year'    => $request->end_year ?: 'Present',
            'description' => $request->description,
        ]);

        return back()->with('success', 'Experience berhasil ditambahkan.');
    }

    public function update(Request $request, Experience $experience)
    {
        $request->validate([
            'company'    => 'required|string|max:255',
            'role'       => 'required|string|max:255',
            'start_year' => 'required|string|max:20',
            'end_year'   => 'nullable|string|max:20',
            'description'=> 'nullable|string',
        ]);

        $experience->update([
            'company'     => $request->company,
            'role'        => $request->role,
            'start_year'  => $request->start_year,
            'end_year'    => $request->end_year ?: 'Present',
            'description' => $request->description,
        ]);

        return back()->with('success', 'Experience berhasil diperbarui.');
    }

    public function destroy(Experience $experience)
    {
        $experience->delete();
        return back()->with('success', 'Experience berhasil dihapus.');
    }
}
