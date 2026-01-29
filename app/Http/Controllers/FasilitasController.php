<?php

namespace App\Http\Controllers;

use App\Models\FasilitasCategory;

class FasilitasController extends Controller
{
    public function index()
    {
        $categories = FasilitasCategory::select(
            'id', 
            'icon',
            'title',
            'desc'
        )->get();

        return view('fasilitas', compact('categories'));
    }
}
