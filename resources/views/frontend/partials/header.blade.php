<header>
    <nav class="navbar navbar-expand-lg bg-transparent fixed-top">        
        <div class="container-fluid">
            <a class="navbar-brand fw-bold fs-4 text-primary" href="">E-commerce</a>

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="btn me-3 fw-semibold text-dark text-uppercase" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="btn me-3 fw-semibold text-dark text-uppercase" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="btn me-3 fw-semibold text-dark text-uppercase" href="#">Services</a>
                </li>
                <li class="nav-item">
                    <a class="btn me-3 fw-semibold text-dark text-uppercase" href="#">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a class="btn me-3 fw-semibold text-dark text-uppercase position-relative" href="{{ route('cart.index') }}">
                        Cart
                        @php
                            $cart = session()->get('cart', []);
                            $cartCount = array_sum(array_column($cart, 'quantity'));
                        @endphp
                        @if($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $cartCount }}
                                <span class="visually-hidden">cart items</span>
                            </span>
                        @endif
                    </a>
                </li>
            </ul>
           @if (Route::has('login'))
    <div class="d-flex justify-content-end align-items-center gap-3 ms-auto">
        @auth
            <!-- Profile Dropdown -->
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                    <img 
                        src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}" 
                        alt="Profile" 
                        width="32" 
                        height="32" 
                        class="rounded-circle"
                    >
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            Profile
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                Log Out
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <a href="{{ route('login') }}" class="btn btn-success me-3 fw-bold text-uppercase">Log in</a>
        @endauth
    </div>
@endif
        </div>
    </nav>
</header>
