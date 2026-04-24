<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Client;
use App\Models\Story;
use App\Models\Experience;
use App\Models\Tool;
use App\Models\Gallery;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        // Ambil data dari database
        $projects = Project::orderBy('order', 'asc')->get();
        $clients = Client::all();
        
        // Kirim data ke view portofolio.blade.php
        return view('portofolio', compact('projects', 'clients'));
    }

    public function info()
    {
        $stories = Story::orderBy('order', 'asc')->get();
        $experiences = Experience::orderBy('start_year', 'desc')->get();
        $tools = Tool::all();

        return view('info', compact('stories', 'experiences', 'tools'));
    }

    public function gallery()
    {
        $images = Gallery::latest()->get();
        return view('gallery', compact('images'));
    }
}