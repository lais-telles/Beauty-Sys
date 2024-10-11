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
            <a class="navbar-brand" href="{{ route('Index') }}"><img src="{{ asset('images/beautysys-logo2.png') }}" style="width: 150px;"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav-principal">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="nav-principal">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="">Estabelecimentos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">Profissionais</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">Ajuda</a>
                        </li>
                    </ul> 
                </div>

                <div class="container mx-5">
                    <form method="post" action="area_pesquisa.php">
                        <div class="input-group">
                            <input class="form-control" type="text" id="pesquisa" name="pesquisa" placeholder="Pesquisar produtos"><br>
                            <button class="btn btn-danger" type="submit"><i class='fas fa-search'></i></button> 
                        </div>
                    </form>
                </div>

                <div  class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"><i id="minhaConta" class='fas fa-user-alt' style="color: white;"></i></a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admCliente') }}">Minha conta</a></li>
                                <li><a class="dropdown-item" href="{{ route('visAgdCliente') }}">Meus agendamentos</a></li>
                                <li><a class="dropdown-item" href="">Endereços</a></li>
                                <li>
                                <form action="{{ route('logoutCliente') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Log out</button>
                                </form>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="carrinho.php"><i id="carrinho" class="fas fa-cart-plus" style="color: white;"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
    @yield('content')
    </main>

    <footer class="text-white bg-dark pb-5 mt-auto">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <p class="col-md-4 mb-0">&copy; 2024 BeautySys, Inc</p>
                <ul class="nav col-md-4 justify-content-end">
                    <li class="nav-item"><a href="#" class="nav-link px-2">Home</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2">Features</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2">Pricing</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2">FAQs</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2">About</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" ></script>

</body>
</html>