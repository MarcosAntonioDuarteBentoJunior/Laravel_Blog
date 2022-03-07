<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Requests\SearchRequest;
use App\Models\Post;
use App\Models\User;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $posts = Post::orderBy('updated_at', 'DESC')->paginate(9);

        return view('blog.index', compact('categories', 'posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('blog.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $image = $request->file('image');

        Post::create([
            'titulo' => $request->input('titulo'),
            'descricao' => $request->input('descricao'),
            'slug' => SlugService::createSlug(Post::class, 'slug', $request->input('titulo')),
            'image_path' => is_null($image) ? null : $image->store('images', 'public'),
            'category_id' => $request->input('category_id'),
            'user_id' => Auth::id()
        ]);

        return redirect()->route('blog.myPosts')->with('success', 'Post enviado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->first();
        $categories = Category::all();

        if(!$post){
            abort('404');
        }

        return view('blog.show', compact('post', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $post =  Post::whereSlug($slug)->first();
        $user = User::find(Auth::user())->first();
        $categories = Category::all();

        if(!$post){
            abort('404');
        }
        
        if($user->cannot('update', $post)){
            abort('403');
        }

        return view('blog.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PostRequest  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $slug)
    {
        $post =  Post::whereSlug($slug)->first();
        $user = User::find(Auth::user())->first();

        if(!$post){
            abort('404');
        }

        if($user->cannot('update', $post)){
            abort('403');
        }

        $image = $request->file('image');

        if($image){
            $urlImage = $image->store('images', 'public');
        } else {
            $urlImage = $post->image_path;
        }


        $post->update([
            'titulo' => $request->input('titulo'),
            'descricao' => $request->input('descricao'),
            'slug' => $slug,
            'image_path' => $urlImage,
            'category_id' => $request->input('category_id'),
            'user_id' => Auth::id()
        ]);

        return redirect()->route('blog.index')->with('success', 'Post atualizado com sucesso!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $post = Post::whereSlug($slug)->first();
        $user = User::find(Auth::user())->first();

        if(!$post){
            abort('404');
        }

        if($user->cannot('delete', $post)){
            abort('403');
        }

        $post->delete();

        return redirect()->route('blog.index')->with('success', 'Post removido com sucesso!');
    }

    public function myPosts()
    {
        $user = auth()->user();
        $posts = Post::where('user_id', $user->id)->orderBy('id', 'DESC')->paginate(9);
        $categories = Category::all();

        return view('blog.my-posts', compact('posts', 'categories'));
    }

    public function search(SearchRequest $request)
    {
        $search = implode($request->only('search'));

        $posts = Post::query()->where('titulo', 'like', "%$search%")->paginate(9);

        return view('index', compact('posts'));
    }
}
