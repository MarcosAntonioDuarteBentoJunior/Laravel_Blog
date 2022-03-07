@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="text-center">Crie uma Categoria</h2>
        <hr class="mb-3">
        <div class="row">
            <form action="{{ route('category.store') }}" method="POST">
                @csrf
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Nome...">
                    <label for="titulo">Nome...</label>

                    <span class="text-danger">
                        @error('titulo')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="form-floating mb-4">
                    <textarea name="descricao" class="form-control w-100 h-50" id="descricao" placeholder="" style="min-height: 250px;"></textarea>
                    <label for="descricao">Conteúdo...</label>

                    <span class="text-danger">
                        @error('descricao')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <button type="submit" class="btn btn-success mb-5">Salvar</button>
            </form>
        </div>
    </div>
@endsection