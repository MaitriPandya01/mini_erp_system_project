<style>
    .active{
        font-weight: 700;
    }

    h3.erp-heading {
        font-family: cursive;
    }
</style>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="{{asset('images/erp-solutions.png')}}" alt="" width="60px" height="50px"></a>
        <h3 class="erp-heading">ERP</h3> <h5 class="erp-heading"> @if(!isset(auth()->user()->role->name)) @elseif(auth()->user()->role->name == 'admin') - Admin Panel @elseif(auth()->user()->role->name == 'Sales Person') - Sales Person Panel @endif</h5>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{route('dashboard')}}">Dashboard</a>
                    </li>
                    
                    @if(isset(auth()->user()->role->name) && (auth()->user()->role->name == 'admin'))
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{route('products.index')}}">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}" href="{{route('orders.index')}}">Sales Order</a>
                    </li>
                    @elseif(isset(auth()->user()->role->name) && (auth()->user()->role->name == 'sales person'))
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}" href="{{route('orders.index')}}">Sales Order</a>
                    </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="btn btn-link nav-link" type="submit">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth
                @guest
                    @if(request()->routeIs('register'))
                    <li class="nav-item {{ request()->routeIs('login') ? 'active' : '' }}"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    @endif
                    @if(request()->routeIs('login'))
                    <li class="nav-item {{ request()->routeIs('register') ? 'active' : '' }}"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    @endif
                @endguest
            </ul>
        </div>
    </div>
</nav>
