@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="text-center mb-3">{{ $post->titulo }}</h2>
        <h4 class="text-center">{{ $post->category->titulo }}</h4>
        <hr class="mb-3">
        <div class="row">
            <div class="px-3">
                {!! $post->descricao !!}
            </div>
        </div>
    </div>

@endsection