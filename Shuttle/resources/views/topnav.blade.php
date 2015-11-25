@if (Auth::check())
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
                {{-- */$user = Auth::user()/* --}}
                 <a href="{{ route('logout') }}" class="btn btn-primary btn-lg" role="button">Logout</a>
                 <p class="navbar-text navbar-right">Hello, <a href="{{route('user.profile')}}" class="navbar-link">{{$user->name}}</a></p>
    </div>
</nav>
@else
    <style>body {padding-top: 0px !important;}</style>
@endif