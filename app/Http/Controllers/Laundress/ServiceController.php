<?php

namespace App\Http\Controllers\Laundress;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    private $predefinedCategories = [
        [
            'id' => 'washing',
            'name' => 'Washing',
            'icon' => 'las la-tshirt',
            'items' => [
                ['item' => 'Suit', 'price' => 5000],
                ['item' => 'Shirt', 'price' => 2000],
                ['item' => 'T-Shirt', 'price' => 1500],
                ['item' => 'Trousers', 'price' => 2500],
                ['item' => 'Jeans', 'price' => 3000],
                ['item' => 'Bed Sheets', 'price' => 4000],
                ['item' => 'Towels', 'price' => 1500],
                ['item' => 'Curtains', 'price' => 6000],
                ['item' => 'Pillow Cases', 'price' => 1000],
                ['item' => 'Blankets', 'price' => 5000],
            ]
        ],
        [
            'id' => 'ironing',
            'name' => 'Ironing',
            'icon' => 'las la-iron',
            'items' => [
                ['item' => 'Shirt', 'price' => 1000],
                ['item' => 'Dress', 'price' => 2000],
                ['item' => 'Suit', 'price' => 3000],
                ['item' => 'Skirt', 'price' => 1500],
                ['item' => 'Jeans', 'price' => 1500],
                ['item' => 'Bedsheet', 'price' => 2500],
                ['item' => 'Pillow Case', 'price' => 500],
                ['item' => 'Uniform', 'price' => 1500],
                ['item' => 'Jacket', 'price' => 2000],
                ['item' => 'Blouse', 'price' => 1500],
            ]
        ],
        [
            'id' => 'dry-cleaning',
            'name' => 'Dry Cleaning',
            'icon' => 'las la-spray-can',
            'items' => [
                ['item' => 'Wedding Dress', 'price' => 15000],
                ['item' => 'Blazer', 'price' => 8000],
                ['item' => 'Suit', 'price' => 10000],
                ['item' => 'Curtains', 'price' => 10000],
                ['item' => 'Carpet', 'price' => 20000],
                ['item' => 'Sofa Cover', 'price' => 12000],
                ['item' => 'Leather Jacket', 'price' => 15000],
                ['item' => 'Gown', 'price' => 12000],
                ['item' => 'Heavy Coat', 'price' => 10000],
                ['item' => 'Blanket', 'price' => 8000],
            ]
        ],
    ];

    public function index()
    {
        $services = Service::where('user_id', Auth::id())->latest()->paginate(10);
        return view('Laundress.services.index', compact('services'));
    }

    public function create()
    {
        $categories = collect($this->predefinedCategories)->toArray();
        return view('Laundress.services.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'category_icon' => 'required|string|max:255', // Add validation for icon
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_structure' => 'required|array',
            'price_structure.*.item' => 'required|string',
            'price_structure.*.price' => 'required|numeric|min:0'
        ]);

        $category = collect($this->predefinedCategories)
            ->firstWhere('id', $request->category_name);

        $service = new Service();
        $service->user_id = Auth::id();
        $service->category_name = $category['name'];
        $service->category_icon = $request->category_icon; // Use the submitted icon
        $service->category_is_active = true;
        $service->name = $validated['name'];
        $service->description = $validated['description'];
        $service->price_structure = $validated['price_structure'];
        $service->is_active = $request->has('is_active');
        $service->save();

        return redirect()->route('laundress.services.index')
            ->with('success', 'Service created successfully.');
    }

    public function edit($id)
    {
        $service = Service::where('user_id', Auth::id())->findOrFail($id);
        return view('Laundress.services.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $service = Service::where('user_id', Auth::id())->findOrFail($id);
        
        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'category_icon' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_structure' => 'required|array',
            'price_structure.*.item' => 'required|string',
            'price_structure.*.price' => 'required|numeric|min:0'
        ]);

        $service->fill($validated);
        $service->category_is_active = $request->has('category_is_active');
        $service->is_active = $request->has('is_active');
        $service->save();

        return redirect()->route('laundress.services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy($id)
    {
        $service = Service::where('user_id', Auth::id())->findOrFail($id);
        $service->delete();

        return redirect()->route('laundress.services.index')
            ->with('success', 'Service deleted successfully.');
    }
}