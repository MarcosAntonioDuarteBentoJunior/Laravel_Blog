@extends('layouts.app')

@section('content')
    <section id="top">
        <div class="container d-flex h-100">
            <div class="row justify-content-center text-center align-items-center">
                <div class="col-12 mx-auto text-white pt-5 text-center">
                    <div class="pt-3 pb-5">
                        <h1 class="text-uppercase mb-3">
                            Quer se tornar um desenvolvedor ?
                        </h1>
                        <a href="#" class="text-center text-uppercase py-1 px-2 btn btn-secondary">
                            Saiba Mais
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="about">
        <div class="container mt-5 mb-3">
            <div class="row">
                <div class="col-12 col-md-4 mb-3 mb-md-0">
                    <img src="https://images.pexels.com/photos/1229861/pexels-photo-1229861.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260" class="img-fluid w-100 h-100" alt="">
                </div>
                <div class="col-12 col-md-8 text-center align-self-center">
                    <form action="{{ route('blog.search') }}" method="POST">
                        @csrf
                        <fieldset>
                            <h2 class="mb-4">Buscando se Tornar um Desenvolvedor Melhor ?</h2>
                            <p class="mb-4">
                                Busque postagens sobre Design, Marketing, Programação e muito mais!
                            </p>
                            <div class="form-floating mb-3">
                                <input type="text" name="search" id="search" class="form-control" placeholder="" style="border-radius: 18px;">
                                <label for="search">Procurar</label>

                                <span class="text-danger">
                                    @error('search')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <button type="submit" class="btn btn-outline-primary">Buscar</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section id="top-posts">
        <div class="container mt-4">
            <h2 class="text-center">Posts em Destaque</h2>
            <hr class="mb-3">
            <div class="row justify-content-center">
                @if ($posts->isEmpty())
                    <div class="alert alert-info">
                        Não há postagens para listar.
                    </div>
                @else
                    @foreach ($posts as $post)
                        <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-3 mb-md-4">
                            <div class="card h-100">
                                @if (!$post->image_path)
                                    <img src="{{ asset('img/no-photo.jpg') }}" class="card-img-top" alt="...">
                                @else
                                    <img src="{{ asset('storage/' . $post->image_path) }}" class="card-img-top" alt="...">
                                @endif                                <div class="card-body">
                                    <h5 class="card-title text-center">{{$post->titulo }}</h5>
                                    <div class="d-flex justify-content-between">
                                        <p class="card-text">Por <span class="fst-italic">{{ $post->user->name }}</span> em: {{ date('d/m/Y', strtotime($post->created_at)) }}</p>
                                        <p class="card-text">Em: <span class="fst-italic">{{ $post->category->titulo }}</span></p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-outline-success">Ler</a>
                                        @auth
                                            @if (Auth::check() && Auth::user()->can('update', $post))
                                                <a href="{{ route('blog.edit', $post->slug) }}" class="btn btn-outline-primary">Editar</a>
                                            @endif
                                            @if (Auth::check() && Auth::user()->can('delete', $post))
                                                <form action="{{ route('blog.destroy', $post->slug) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
    
                                                    <button type="submit" class="btn btn-outline-danger">Excluir</button>
                                                </form>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <section id="expertise">
        <div class="container-fluid bg-dark py-4">
            <div class="row text-center text-white">
                <h3 class="mb-3">Sou especialista em...</h3>
                <span class="fw-bold mb-1">UX/UI</span>
                <span class="fw-bold mb-1">Front-End</span>
                <span class="fw-bold mb-1">Back-End</span>
                <span class="fw-bold">Marketing Digital</span>

            </div>
        </div>
    </section>

    <section id="posts">
        
    </section>
@endsection