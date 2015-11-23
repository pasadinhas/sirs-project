<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            @if (Auth::check())
                <a href="{{ route('logout') }}" class="btn btn-primary btn-lg" role="button">Logout</a>
                <p class="navbar-text navbar-right">Hello, <a href="{{route('user.profile')}}" class="navbar-link">{{Auth::user()->name}}</a></p>
            @else
                <a href="{{ route('user.create') }}" class="btn btn-primary btn-lg" role="button">Create User</a>
            @endif
        </div>
    </div>
</nav>