<!-- Side Navbar -->
<nav class="side-navbar">
  <div class="side-navbar-wrapper">
    <!-- Sidebar Header    -->
    <div class="sidenav-header d-flex align-items-center justify-content-center">
      <!-- User Info-->
      <div class="sidenav-header-inner text-center"><img src="/storage/user_images/{{Auth::user()->image}}" alt="person" class="img-fluid rounded-circle">
        <h2 class="h5">{{ Auth::user()->name }}</h2><span>{{ Auth::user()->email }}</span>
      </div>
      <!-- Small Brand information, appears on minimized sidebar-->
      <div class="sidenav-header-logo">
        <a href="{{ route('admin.index') }}" class="brand-small text-center">
          <strong>A</strong>
          <strong class="text-primary">N</strong>
        </a>
      </div>
    </div>
    <!-- Sidebar Navigation Menus-->
    <div class="main-menu">
      {{--
      <h5 class="sidenav-heading"><span>Users</span></h5> --}}
      <ul id="side-main-menu" class="side-menu list-unstyled">
        <li><a href="{{ route('admin.index') }}"> <i class="icon-home"></i>Home</a></li>
        <li>
          <a href="#carsDropdown" aria-expanded="false" data-toggle="collapse"><i class="icon-grid"></i>Cars</a>
          <ul id="carsDropdown" class="collapse list-unstyled ">
            <li><a href="#">Car list</a></li>
            <li><a href="#">Add car</a></li>
            <li><a href="#">Active cars</a></li>
          </ul>
        </li>
        <li>
          <a href="#usersDropdown" aria-expanded="false" data-toggle="collapse"><i class="icon-check"></i>Users</a>
          <ul id="usersDropdown" class="collapse list-unstyled ">
            <li><a href="{{route('admin.userDetails')}}">Users details</a></li>
            <li><a href="{{route('admin.addUser')}}">Add user</a></li>
          </ul>
        </li>
        <li>
          <a href="#blogsDropdown" aria-expanded="false" data-toggle="collapse"><i class="icon-check"></i>Blogs</a>
          <ul id="blogsDropdown" class="collapse list-unstyled ">
            <li><a href="{{route('admin.blogDetails')}}">Blog list</a></li>
            <li><a href="{{route('blog.create')}}">Add blog</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>