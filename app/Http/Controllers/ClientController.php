<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:2048',
        ]);

        if (!$request->name && !$request->hasFile('logo')) {
            return back()->withErrors(['name' => 'Isi nama atau upload logo.']);
        }

        $path = null;
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('clients', 'public');
        }

        Client::create([
            'name'      => $request->name,
            'logo_path' => $path,
        ]);

        return back()->with('success', 'Client berhasil ditambahkan.');
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:2048',
        ]);

        $data = ['name' => $request->name];

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('clients', 'public');
        }

        $client->update($data);

        return back()->with('success', 'Client berhasil diperbarui.');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return back()->with('success', 'Client berhasil dihapus.');
    }
}
