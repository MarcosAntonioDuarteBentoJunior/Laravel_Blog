@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="text-center text-uppercase mb-4">Blog</h2>
        <h4 class="text-center text-uppercase mb-2">Últimas Postagens</h4>
        <hr class="mb-3">

        <div class="row justify-content-center">
            @if ($posts->isEmpty())
            <div class="alert alert-info">
                O blog ainda não tem postagens
            </div>
            @else
                @foreach ($posts as $post)
                    <div class="col-12 col-md-6 col-xl-4 mb-3 mb-xl-5">
                        <div class="card text-center h-100">
                            @if (!$post->image_path)
                                <img src="{{ asset('img/no-photo.jpg') }}" class="card-img-top" alt="...">
                            @else
                                <img src="{{ asset('storage/' . $post->image_path) }}" class="card-img-top" alt="...">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{$post->titulo }}</h5>
                                <div class="d-flex justify-content-between">
                                    <p class="card-text">Por <span class="fst-italic">{{ $post->user->name }}</span> em: {{ date('d/m/Y', strtotime($post->created_at)) }}</p>
                                    <p class="card-text">Em: <span class="fst-italic">{{ $post->category->titulo }}</span></p>
                                </div>                                
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-outline-success">Ver Post</a>
                                    @auth
                                        @if (Auth::user()->can('update', $post))
                                            <a href="{{ route('blog.edit', $post->slug) }}" class="btn btn-outline-primary">Editar Post</a>
                                        @endif
                                        @if (Auth::user()->can('delete', $post))
                                            <form action="{{ route('blog.destroy', $post->slug) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-outline-danger">Excluir Post</button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="d-flex justify-content-center">
                    {!! $posts->links() !!}
                </div>
            @endif
        </div>
    </div>
@endsection