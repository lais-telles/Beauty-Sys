<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'BeautySys')</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('/images/beautysys-logo2.ico') }}">
    <link href="{{ asset('css/bootstrap.min.css') }}" type="text/css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Afacad' rel='stylesheet'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="{{ asset('css/estilos.css') }}" type="text/css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
    <header>
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
            <div class="container">
                <a class="navbar-brand" href="{{ route('paginaInicialProfissional') }}">
                    <img src="{{ asset('images/beautysys-logo2.png') }}" style="width: 150px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar padrão -->
                <div class="collapse navbar-collapse container" id="nav-principal">
                    <ul class="navbar-nav me-auto d-flex flex-nowrap">
                        <li class="nav-item">
                            <a class="nav-link text-nowrap" href="{{ route('exibirAgendamentosProf') }}">Meus agendamentos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-nowrap" href="{{ route('servicosProf') }}">Meus serviços</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-nowrap" href="{{ route('gradeProf') }}">Meus horários</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-nowrap" href="{{ route('vinculoProf') }}">Vínculo</a>
                        </li>
                    </ul>

                    <!-- Barra de Pesquisa -->
                    <div class="container mx-3">
                        <form method="post" action="" class="d-flex">
                            <input class="form-control" type="text" id="pesquisa" name="pesquisa" placeholder="Estou procurando por...">
                            <button class="btn btn-danger" type="submit">
                                <i class='fas fa-search'></i>
                            </button>
                        </form>
                    </div>

                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i id="minhaConta" class='fas fa-user-alt' style="color: white;"></i>

                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admProfissional') }}">Meu perfil</a></li>
                                <li>
                                    <form action="{{ route('logoutProfissional') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Log out</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Offcanvas Navbar -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <form method="post" action="" class="d-flex">
                            <input class="form-control" type="text" id="pesquisa" name="pesquisa" placeholder="Estou procurando por...">
                            <button class="btn btn-danger" type="submit">
                                <i class='fas fa-search'></i>
                            </button>
                        </form>
                    </li>
                    <li class="nav-item"><a class="nav-link text-dark" href="{{ route('admProfissional') }}">Meu perfil</a></li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="{{ route('exibirAgendamentosProf') }}">Meus agendamentos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="{{ route('servicosProf') }}">Meus serviços</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="{{ route('vinculoProf') }}">Meus Horários</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="{{ route('vinculoProf') }}">Vínculo</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logoutProfissional') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link text-dark">Log out</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <main>
    @yield('content')
    </main>

    <footer class="text-white bg-dark pb-5 mt-auto">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <p class="col-md-4 mb-0">&copy; 2024 BeautySys, Inc</p>
                <ul class="nav col-md-4 justify-content-end">
                    <li class="nav-item"><a href="#" class="nav-link px-2 disabled-link">Home</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 disabled-link">Features</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 disabled-link">Pricing</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 disabled-link">FAQs</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 disabled-link">About</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

</body>
</html>
