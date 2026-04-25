<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Tool::create(['name' => $request->name]);
        return back()->with('success', 'Tool berhasil ditambahkan.');
    }

    public function update(Request $request, Tool $tool)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $tool->update(['name' => $request->name]);
        return back()->with('success', 'Tool berhasil diperbarui.');
    }

    public function destroy(Tool $tool)
    {
        $tool->delete();
        return back()->with('success', 'Tool berhasil dihapus.');
    }
}
