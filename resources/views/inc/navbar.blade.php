<!-- menu -->
<div id="main-nav" class="fixed-top container-fluid no-gutter bg-dark">
  <div class="container no-gutter">
    <nav class="navbar navbar-expand-md navbar-dark">
      <a class="navbar-brand" href="{{route('home.index')}}"><img class="img-fluid" id="dnh-logo"
          src="{{ url('imgs/logo.png') }}" alt=""></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        {{-- left navbar menu --}}
        <ul class="navbar-nav mr-auto">
          @if (Auth::check() && Auth::user()->type == 'admin')
          <li class="nav-item">
            <a class="nav-link text-info" href="{{route('admin.index')}}">Switch to ADMIN</a>
          </li>
          @endif
        </ul>
        {{-- rigth navbar menu --}}
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="{{route('home.index')}}">Home</a>
          </li>
          <!-- campaign -->
          <li class="nav-item dropdown">
            <div class="btn-group">
              <a href="{{route('campaign.index')}}" class="nav-link text-warning">Donate here!!</a> @if (Auth::check())
              <a href="" class="nav-link dropdown-toggle dropdown-toggle-split" id="carMenu" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false" data-reference="parent">
                <span class="sr-only">Toggle Dropdown</span>
              </a>
              <div class="dropdown-menu  custom-dropdown" aria-labelledby="carMenu">
                <a class="dropdown-item" href="{{route('campaign.create')}}">Create campaign</a>
              </div>
              @endif
            </div>
          </li>
          <!-- campaign ends-->
          <!-- blogs -->
          <li class="nav-item dropdown">
            <div class="btn-group">
              <a href="{{route('blog.index')}}" class="nav-link">Blogs</a> @if (Auth::check())
              <a href="#" class="nav-link dropdown-toggle dropdown-toggle-split" id="blogmenu" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false" data-reference="parent">
                <span class="sr-only">Toggle Dropdown</span>
              </a>
              <div class="dropdown-menu  custom-dropdown" aria-labelledby="blogmenu">
                <a class="dropdown-item" href="{{route('blog.create')}}">Add new blog!!</a>
                <a class="dropdown-item" href="{{route('blogs.userBlogs')}}">My blogs</a>
              </div>
              @endif
            </div>
          </li>
          <!-- blogs ends-->
          <!-- Authentication Links -->
          @guest
          <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
          </li>
          @if (Route::has('register'))
          <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
          </li>
          @endif @else
          <!-- my account -->
          <li class="nav-item dropdown">
            <div class="btn-group">
              <a href="{{Auth::user()->url}}" class="nav-link">{{ Auth::user()->name }}</a>
              <a href="#" class="nav-link dropdown-toggle dropdown-toggle-split" id="usermenu" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false" data-reference="parent">
                <span class="sr-only">Toggle Dropdown</span>
              </a>
              <div class="dropdown-menu  custom-dropdown" aria-labelledby="usermenu">
                <a class="dropdown-item" href="{{route('dashboard.recharge')}}">Recharge</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{route('home.about')}}">About Us</a>
                <a class="dropdown-item" href="">Contact US</a>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">{{ __('Logout') }}<i
                    class="fas fa-sign-out-alt ml-5"></i></a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
              </div>
            </div>
          </li>
          <!-- my account ends-->
          @endguest

        </ul>
        <form class="form-inline my-2 my-lg-0 mx10">
          <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-warning my-2 my-sm-0" type="submit">Search</button>
        </form>
      </div>
    </nav>
  </div>
</div>