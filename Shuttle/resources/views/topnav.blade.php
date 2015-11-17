<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            @if (Auth::check())
                <a href="{{ route('logout') }}" class="btn btn-primary btn-lg" role="button">Logout</a>
            @else
                <a href="{{ route('user.create') }}" class="btn btn-primary btn-lg" role="button">Create User</a>
            @endif
        </div>
    </div>
</nav>