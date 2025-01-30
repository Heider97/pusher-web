<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * Listar todos los posts.
     */ 
    public function index()
    {
        $posts = Post::all();

        return Inertia::render('Posts/Index', ['posts' => $posts]);
    }

    /**
     * Crear un nuevo post.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => $request->user_id,
        ]);

        return response()->json(['message' => 'Post creado correctamente', 'post' => $post]);
    }

    /**
     * Mostrar un post.
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);

        return response()->json(['post' => $post]);
    }


    /**
     * Actualizar un post.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = Post::findOrFail($id);
        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return response()->json(['message' => 'Post actualizado correctamente', 'post' => $post]);
    }

    /**
     * Eliminar un post.
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json(['message' => 'Post eliminado correctamente']);
    }
}
