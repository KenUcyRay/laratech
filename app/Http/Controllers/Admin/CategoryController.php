<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Dummy data untuk testing
        $categories = [
            ['id' => 1, 'name' => 'Technology', 'slug' => 'technology', 'status' => 'active'],
            ['id' => 2, 'name' => 'Business', 'slug' => 'business', 'status' => 'active'],
            ['id' => 3, 'name' => 'Health', 'slug' => 'health', 'status' => 'inactive']
        ];

        return response()->json([
            'status' => 'success',
            'data' => $categories
        ]);
        
        // Blade View (commented)
        // return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories',
            'description' => 'nullable|string',
            'status' => 'in:active,inactive'
        ]);

        // Simulasi create
        $category = array_merge($validated, ['id' => rand(1, 1000)]);

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori berhasil ditambahkan',
            'data' => $category
        ], 201);
        
        // Blade View (commented)
        // return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function show($id)
    {
        $category = [
            'id' => $id,
            'name' => 'Sample Category',
            'slug' => 'sample-category',
            'description' => 'Sample description',
            'status' => 'active'
        ];

        return response()->json([
            'status' => 'success',
            'data' => $category
        ]);
        
        // Blade View (commented)
        // return view('admin.categories.show', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'in:active,inactive'
        ]);

        $category = array_merge($validated, ['id' => $id]);

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori berhasil diupdate',
            'data' => $category
        ]);
        
        // Blade View (commented)
        // return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy($id)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Kategori berhasil dihapus'
        ]);
        
        // Blade View (commented)
        // return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus');
    }

    // Blade View Methods (commented)
    // public function create()
    // {
    //     return view('admin.categories.create');
    // }
    //
    // public function edit($id)
    // {
    //     $category = [
    //         'id' => $id,
    //         'name' => 'Sample Category',
    //         'slug' => 'sample-category',
    //         'description' => 'Sample description',
    //         'status' => 'active'
    //     ];
    //     return view('admin.categories.edit', compact('category'));
    // }
}