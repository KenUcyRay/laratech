<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = [
            [
                'id' => 1,
                'title' => 'Laravel Best Practices',
                'slug' => 'laravel-best-practices',
                'content' => 'Content here...',
                'status' => 'published',
                'author' => 'Admin',
                'created_at' => now()
            ],
            [
                'id' => 2,
                'title' => 'PHP 8 Features',
                'slug' => 'php-8-features',
                'content' => 'Content here...',
                'status' => 'draft',
                'author' => 'Admin',
                'created_at' => now()
            ]
        ];

        return response()->json([
            'status' => 'success',
            'data' => $posts
        ]);
        
        // Blade View (commented)
        // return view('admin.posts.index', compact('posts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:posts',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'status' => 'in:draft,published,archived',
            'category_id' => 'nullable|integer',
            'featured_image' => 'nullable|string'
        ]);

        $post = array_merge($validated, [
            'id' => rand(1, 1000),
            'author' => 'Admin',
            'created_at' => now()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Post berhasil ditambahkan',
            'data' => $post
        ], 201);
        
        // Blade View (commented)
        // return redirect()->route('admin.posts.index')->with('success', 'Post berhasil ditambahkan');
    }

    public function show($id)
    {
        $post = [
            'id' => $id,
            'title' => 'Sample Post',
            'slug' => 'sample-post',
            'content' => 'Sample content here...',
            'excerpt' => 'Sample excerpt',
            'status' => 'published',
            'category_id' => 1,
            'author' => 'Admin',
            'created_at' => now()
        ];

        return response()->json([
            'status' => 'success',
            'data' => $post
        ]);
        
        // Blade View (commented)
        // return view('admin.posts.show', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'status' => 'in:draft,published,archived',
            'category_id' => 'nullable|integer',
            'featured_image' => 'nullable|string'
        ]);

        $post = array_merge($validated, [
            'id' => $id,
            'updated_at' => now()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Post berhasil diupdate',
            'data' => $post
        ]);
        
        // Blade View (commented)
        // return redirect()->route('admin.posts.index')->with('success', 'Post berhasil diupdate');
    }

    public function destroy($id)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Post berhasil dihapus'
        ]);
        
        // Blade View (commented)
        // return redirect()->route('admin.posts.index')->with('success', 'Post berhasil dihapus');
    }

    public function publish($id)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Post berhasil dipublish'
        ]);
        
        // Blade View (commented)
        // return redirect()->route('admin.posts.index')->with('success', 'Post berhasil dipublish');
    }

    public function unpublish($id)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Post berhasil di-unpublish'
        ]);
        
        // Blade View (commented)
        // return redirect()->route('admin.posts.index')->with('success', 'Post berhasil di-unpublish');
    }

    // Blade View Methods (commented)
    // public function create()
    // {
    //     return view('admin.posts.create');
    // }
    //
    // public function edit($id)
    // {
    //     $post = [
    //         'id' => $id,
    //         'title' => 'Sample Post',
    //         'slug' => 'sample-post',
    //         'content' => 'Sample content here...',
    //         'excerpt' => 'Sample excerpt',
    //         'status' => 'published',
    //         'category_id' => 1,
    //         'author' => 'Admin',
    //         'created_at' => now()
    //     ];
    //     return view('admin.posts.edit', compact('post'));
    // }
}