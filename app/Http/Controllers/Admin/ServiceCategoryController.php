<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    public function index()
    {
        $categories = ServiceCategory::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.services.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255'
        ]);

        ServiceCategory::create($validated);

        return redirect()->route('admin.services.categories.index')
            ->with('success', 'Service category created successfully');
    }
}