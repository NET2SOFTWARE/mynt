<nav class="navbar fixed-top navbar-toggleable-md navbar-inverse bg-inverse">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navToggle" aria-controls="navToggle" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="{{ url('/') }}"><strong>{{ strtoupper(Auth::user()->merchants->first()['companies'][0]['name']) }}</strong></a>
    <section class="collapse navbar-collapse" id="navToggle">
        <ul class="navbar-nav ml-auto">
            @if (Auth::guest())
                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('login.merchant') }}">Login</a></li>
            @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</a>
                    <section class="dropdown-menu dropdown-menu-right" aria-labelledby="navDropDown">
                        <a class="dropdown-item" href="{{ route('merchant.profile') }}">Profile</a>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Sign out</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </section>
                </li>
            @endif
        </ul>
    </section>
</nav>