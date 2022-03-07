@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="text-center">Edite sua postagem</h2>
        <hr class="mb-3">
        <div class="row">
            <form action="{{ route('blog.update', $post->slug) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Titulo..." value="{{ $post->titulo }}">
                    <label for="titulo">Titulo...</label>

                    <span class="text-danger">
                        @error('titulo')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="form-floating mb-3">
                    <textarea name="descricao" class="form-control w-100 h-50" id="descricao" placeholder="" style="min-height: 250px;">{{ $post->descricao }}</textarea>
                    <label for="descricao">Conteúdo...</label>

                    <span class="text-danger">
                        @error('descricao')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="form-floating mb-3">
                    <select name="category_id" id="category" class="form-select">
                        <option value="" selected>Selecione</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if($post->category->id == $category->id) selected @endif>{{ $category->titulo }}</option>
                        @endforeach
                    </select>
                    <label for="category">categoria...</label>

                    <span class="text-danger">
                        @error('category_id')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div>
                    <input type="file" name="image" id="" class="form-control w-50">

                    <span class="text-danger">
                        @error('image')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <button type="submit" class="btn btn-success mb-5 mt-4">Enviar Post</button>

            </form>
        </div>
    </div>

    <script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: "#descricao"
        });
    </script>
@endsection