@if (Auth::check())
    {{-- */$user = Auth::user()/* --}}
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <a href="{{ route('logout') }}" class="navbar-btn btn btn-primary" role="button">Book a Trip</a> <!--TODO: Fix route -->
            @if($user->isDriver())
                <a href="{{ route('logout') }}" class="navbar-btn btn btn-primary" role="button">View Schedule</a> <!--TODO: Fix route -->
            @endif
            @if($user->isManager() || $user->isAdmin())
                <div class="btn-group">
                    <button type="button" class="navbar-btn btn btn-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Trips <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('trip.create') }}" role="button">Create Trip</a></li>
                        <li><a href="{{ route('logout') }}" >View Trips</a> <!--TODO: Fix route --></li>
                    </ul>
                </div>

                <div class="btn-group">
                    <button type="button" class="navbar-btn btn btn-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Shuttles <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('shuttle.create') }}" >Register Shuttle</a></li>
                        <li><a href="{{ route('logout') }}" >View Shuttles</a> <!--TODO: Fix route --></li>
                    </ul>
                </div>

                <a href="{{ route('logout') }}" class="navbar-btn btn btn-primary" role="button">Users</a> <!--TODO: Fix route -->

            @endif
            <div class="navbar-right">
                <a href="{{ route('logout') }}" class="navbar-btn btn btn-primary btn-xs" role="button">Logout</a>
                <p class="navbar-text">Hello, <a href="{{route('user.profile')}}" class="navbar-link">{{$user->name}}</a></p>
            </div>
        </div>
    </nav>
@else
    <style>body {padding-top: 0px !important;}</style>
@endif