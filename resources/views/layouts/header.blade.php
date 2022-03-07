<nav class="navbar navbar-expand-md navbar-dark bg-dark py-3">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}"><i class="fab fa-blogger-b"></i> Blog</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Blog
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('blog.index') }}">Posts</a></li>
                        @auth
                            <li><a class="dropdown-item" href="{{ route('blog.create') }}">Nova Postagem</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('blog.myPosts') }}">Minhas postagens</a></li>
                        @endauth
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Categorias
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @php
                            $categories = App\Models\Category::all();
                        @endphp

                        @foreach ($categories as $category)
                            <li>
                                <a class="dropdown-item" href="{{ route('category.posts', $category->slug) }}">{{ $category->titulo }}</a>
                            </li>
                        @endforeach

                        @if (Auth::check())
                            @if (Auth::user()->role == 'admin')
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('category.index') }}">Painel Administrativo</a></li>
                            @endif
                        @endif
                    </ul>
                </li>
                @if (Auth::check())
                    @if (Auth::user()->role == 'admin')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-shield align-self-center ms-3 me-2"></i>{{ Auth::user()->name }}
                            </a>

                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <button class="btn">
                                        <form action="{{ route('logout') }}" class="d-flex justify-content-between" method="POST">
                                            @csrf
                                            <div class="align-self-center">
                                                <i class="fas fa-sign-out-alt"></i>
                                            </div>
                                            <div>
                                                <button type="submit" class="btn">
                                                    <span class="me-auto text-center">Sair</span>
                                                </button>
                                            </div>
                                        </form>
                                    </button>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user align-self-center ms-3 me-2"></i>{{ Auth::user()->name }}
                            </a>

                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <button class="btn">
                                        <form action="{{ route('logout') }}" class="d-flex justify-content-between" method="POST">
                                            @csrf
                                            <div class="align-self-center">
                                                <i class="fas fa-sign-out-alt"></i>
                                            </div>
                                            <div>
                                                <button type="submit" class="btn">
                                                    <span class="me-auto text-center">Sair</span>
                                                </button>
                                            </div>
                                        </form>
                                    </button>
                                </li>
                            </ul>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('login') }}">Entrar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('register') }}">Criar uma conta</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>