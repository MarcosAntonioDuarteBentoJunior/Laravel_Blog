@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="text-center text-uppercase mb-4">Categorias</h2>
        <div class="results">
            @if (Session::get('fail'))
                <div class="alert alert-danger w-100 text-center">
                    {{ Session::get('fail') }}
                </div>
            @endif

            @if (Session::get('success'))
                <div class="alert alert-success w-100 text-center">
                    {{ Session::get('success') }}
                </div>
            @endif
        </div>
        <hr class="mb-3">

        <a href="{{ route('category.create') }}" class="btn btn-success mb-3">Nova Categoria</a>

        @if ($categories->isEmpty())
            <div class="alert alert-info">
                O blog ainda não tem categorias
            </div>
        @else
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <th scope="col">Nome</th>
                            <th scope="col">Posts</th>
                            <th scope="col">Criado(a) em</th>
                            <th scope="col">Opções</th>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->titulo }}</td>
                                    <td>{{ $category->posts->count() }}</td>
                                    <td>{{ date('d/m/Y', strtotime($category->created_at)) }}</td>
                                    <td>
                                        <a href="{{ route('category.edit', $category->slug) }}" class="text-decoration-none">
                                            <i class="fas fa-edit" title="editar"></i>
                                        </a>

                                        <!-- Button trigger modal -->
                                        <a type="button" class="text-decoration-none me-2" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $category->id }}">
                                            <i class="fas fa-trash-alt text-danger"></i>
                                        </a>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal{{ $category->id }}" tabindex="-1" aria-labelledby="exampleModalLabel{{ $category->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel{{ $category->id }}">Confirmar Ação</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Tem certeza que deseja excluir a categoria {{ $category->titulo }} ?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ route('category.destroy', $category->slug) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                                                            <button type="submit" class="btn btn-outline-danger">Confirmar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    {!! $categories->links() !!}
                </div>
            </div>
        @endif
    </div>
@endsection