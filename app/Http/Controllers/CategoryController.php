<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::user())->first();

        if($user->cannot('viewAny', Category::class)){
            abort('403');
        }

        $categories = Category::paginate(5);

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::find(Auth::user())->first();

        if($user->cannot('create', Category::class)){
            abort('403');
        }

        $categories = Category::all();

        return view('categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required'
        ]);

        $data = $request->only(['titulo', 'descricao']);

        $newCategory = Category::create([
            'titulo' => $data['titulo'],
            'descricao' => $data['descricao'],
            'slug' => SlugService::createSlug(Category::class, 'slug', $data['titulo'])
        ]);

        if($newCategory){
            return redirect()->route('category.index')->with('success', 'Categoria cadastrada com sucesso!');
        } else {
            abort('500');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $user = User::find(Auth::user())->first();

        if($user->cannot('update', Category::class)){
            abort('403');
        }

        $category = Category::whereSlug($slug)->first();
        $categories = Category::all();

        if(!$category){
            abort('404');
        }

        return view('categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $request->validate([
            'titulo' => 'required'
        ]);

        $category = Category::whereSlug($slug)->first();

        if(!$category){
            abort('404');
        }

        $data = $request->only(['titulo', 'descricao']);

        if(!strcmp($category->titulo, $data['titulo'])){
            $data['slug'] = $category->slug;
        } else {
            $data['slug'] = SlugService::createSlug(Category::class, 'slug', $data['titulo']);
        }

        $category->update($data);
        return redirect()->route('category.index')->with('success', 'Categoria atualizada com sucesso!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $user = User::find(Auth::user())->first();

        if($user->cannot('delete', Category::class)){
            abort('403');
        }

        $category = Category::whereSlug($slug)->first();

        if(!$category){
            abort('404');
        }

        $posts = $category->posts->count();

        if($posts){
            return redirect()->route('category.index')->with('fail', 'Esta categoria não pode ser removida pois existem ' . $posts . ' post(s) vinculado(s) a ela');
        }

        if(DB::table('categories')->count() == 1){
            return redirect()->route('category.index')->with('fail', 'Deve existir na base de dados pelo menos uma categoria!');
        }

        $category->delete();
        return redirect()->route('category.index')->with('success', 'Categoria removida com sucesso!');
    }

    public function posts($slug)
    {
        $category = Category::whereSlug($slug)->first();
        $posts = Post::where('category_id', $category->id)->orderBy('id', 'DESC')->paginate(9);
        $categories = Category::all();

        if(!$category){
            abort('500');
        }

        return view('categories.posts', compact('posts', 'category', 'categories'));
    }
}
