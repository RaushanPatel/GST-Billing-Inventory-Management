<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill & Inventory Management Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
        }

        .navbar-custom {
            background-color: #007bff;
            padding: 1rem 2rem;
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: white !important;
        }

        .main-content {
            padding: 3rem 1rem;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.15);
        }

        .hero {
            background: #007bff;
            color: white;
            padding: 4rem 1rem;
            border-radius: 8px;
        }

        .footer-custom {
            background-color: #f1f1f1;
            padding: 1.5rem;
            font-size: 0.9rem;
            color: #333;
        }

        .footer-custom a {
            color: #007bff;
        }

        .footer-custom a:hover {
            color: #0056b3;
        }

        .icon-box {
            font-size: 2rem;
            color: #007bff;
        }

        .feature-box {
            background: #fff;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
    </style>
</head>

<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-custom navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/">GST-BILLING-INVENTORY-MANAGEMENT</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('applications.create') }}">Create Application</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('bills.create', ['application' => 1]) }}">Create Bill</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('bills.index') }}">Bills History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('inventory.index') }}">Inventory</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('sales') }}">Sales</a>
                    </li>
                    @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero text-center">
        <h1>Welcome to Bill & Inventory Management</h1>
        <p class="lead">Effortlessly manage applications, bills, inventory, and sales in one place.</p>
        <a href="{{ route('applications.create') }}" class="btn btn-light btn-lg me-2">Create Application</a>
        <a href="{{ route('inventory.index') }}" class="btn btn-outline-light btn-lg">Manage Inventory</a>
    </section>

    <!-- Main Content -->
    <div class="container my-5">
    <div class="row text-center">
        <!-- Features Overview -->
        <div class="col-md-3 mb-4">
            <a href="{{ route('applications.create') }}" class="text-decoration-none text-dark">
                <div class="feature-box p-4">
                    <div class="icon-box mb-3"><i class="bi bi-file-earmark-plus"></i></div>
                    <h5>Create Applications</h5>
                    <p>Manage customer billing applications efficiently with our easy-to-use interface.</p>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="{{ route('bills.create', ['application' => 1]) }}" class="text-decoration-none text-dark">
                <div class="feature-box p-4">
                    <div class="icon-box mb-3"><i class="bi bi-receipt"></i></div>
                    <h5>Generate Bills</h5>
                    <p>Quickly generate and organize bills, with history available at your fingertips.</p>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="{{ route('inventory.index') }}" class="text-decoration-none text-dark">
                <div class="feature-box p-4">
                    <div class="icon-box mb-3"><i class="bi bi-box-seam"></i></div>
                    <h5>Manage Inventory</h5>
                    <p>Track product availability, quantities, and prices in the inventory system.</p>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="{{ route('sales') }}" class="text-decoration-none text-dark">
                <div class="feature-box p-4">
                    <div class="icon-box mb-3"><i class="bi bi-graph-up-arrow"></i></div>
                    <h5>Track Sales</h5>
                    <p>Monitor sales performance and billing trends to make informed decisions.</p>
                </div>
            </a>
        </div>
    </div>
</div>


    <!-- Footer -->
    <footer class="footer-custom text-center">
        <p>
            Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }}) &mdash; Developed by <a href="https://github.com/RaushanPatel">Raushan Patel</a>
        </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
