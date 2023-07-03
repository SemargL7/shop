<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg border-bottom">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Zalupa shop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav w-100 d-flex justify-content-end">

                @auth
                    <li class="dropdown">
                        <button class="btn btn-outline-dark me-2 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{auth()->user()->username}}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/profile">Profile</a></li>
                            <li><a href="/logout" class="dropdown-item btn btn-outline-dark me-2">Logout</a></li>
                        </ul>
                    </li>

                @endauth

                @guest
                    <li class="nav-item">
                        <a href="/login" class="btn btn-outline-dark me-2">Login</a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

@yield('main_content')

<footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top bottom-0">
    <div class="col-md-4 d-flex align-items-center">
        <a href="/" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
            <svg class="bi" width="30" height="24"><use xlink:href="#bootstrap"></use></svg>
        </a>
        <span class="mb-3 mb-md-0">© 2022 Company, Inc</span>
    </div>

    <ul class="nav col-md-4 justify-content-center list-unstyled d-flex">
        <li >
            <p>
                <a class="text-muted" href="/privacyPolicy">Privacy Policy</a>
            </p>
            <p>
                <a class="text-muted" href="/termsOfUse">Terms of use</a>
            </p>
        </li>
    </ul>

    <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
        <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#twitter"></use></svg></a></li>
        <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#instagram"></use></svg></a></li>
        <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#facebook"></use></svg></a></li>
    </ul>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
