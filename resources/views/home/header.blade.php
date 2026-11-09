<!-- header inner -->
<div class="header">
   <div class="container">
      <div class="row">
         <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
            <div class="full">
               <div class="center-desk">
                  <div class="logo">
                     <a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt="logo" /></a>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
            <nav class="navigation navbar navbar-expand-md navbar-dark">
               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse" id="navbarsExample04">
                  <ul class="navbar-nav mr-auto">
                     <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}#about">About</a>
                     </li>
                     <li class="nav-item {{ request()->routeIs('rooms.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('rooms.index') }}">Our Rooms</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}#gallery">Gallery</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}#contact">Contact Us</a>
                     </li>

                     @if (Route::has('login'))
                        @auth
                           @if (auth()->user()->usertype === 'admin')
                              <li class="nav-item">
                                 <a class="nav-link" href="{{ route('home') }}">Admin Dashboard</a>
                              </li>
                           @else
                              <li class="nav-item">
                                 <a class="nav-link" href="{{ route('bookings.index') }}">My Bookings</a>
                              </li>
                           @endif
                           <li class="nav-item">
                              <form method="POST" action="{{ route('logout') }}">
                                 @csrf
                                 <button type="submit" class="btn btn-danger">Logout</button>
                              </form>
                           </li>
                        @else
                           <li class="nav-item" style="padding-right: 10px;">
                              <a class="btn btn-success" href="{{ url('login') }}">Login</a>
                           </li>
                           @if (Route::has('register'))
                              <li class="nav-item">
                                 <a class="btn btn-primary" href="{{ url('register') }}">Register</a>
                              </li>
                           @endif
                        @endauth
                     @endif
                  </ul>
               </div>
            </nav>
         </div>
      </div>
   </div>
</div>
<!-- end header inner -->