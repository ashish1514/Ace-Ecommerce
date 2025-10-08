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
                 <li class="nav-item">
                    <a class="btn me-3 fw-semibold text-dark text-uppercase position-relative d-flex align-items-center" href="{{ route('wishlist.index') }}">
                        Wishlist
                        @php
                            $wishlistCount = auth()->check() ? \App\Models\Wishlist::where('user_id', auth()->id())->count() : 0;
                        @endphp
                        <span class="ms-1">
                            @if($wishlistCount > 0)
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#e74c3c" viewBox="0 0 24 24" style="vertical-align: middle;">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="#e74c3c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart" viewBox="0 0 24 24" style="vertical-align: middle;">
                                    <path d="M20.8 4.6c-1.5-1.4-3.9-1.4-5.4 0l-.4.4-.4-.4c-1.5-1.4-3.9-1.4-5.4 0-1.6 1.5-1.6 4 0 5.5l5.8 5.7 5.8-5.7c1.6-1.5 1.6-4 0-5.5z"/>
                                </svg>
                            @endif
                        </span>
                        @if($wishlistCount > 0) 
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $wishlistCount }}
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
