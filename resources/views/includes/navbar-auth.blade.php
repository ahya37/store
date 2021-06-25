 <nav
      class="navbar navbar-dark bg-success navbar-expand fixed-bottom d-md-none d-lg-none d-xl-none"
    >
      <ul class="navbar-nav nav-justified w-100">
        <li class="nav-item">
          <a href="{{ route('home') }}" class="nav-link">
            <img src="/images/home.svg" width="20" />
            <br>
            <small style="color: white">Home</small>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('categories') }}" class="nav-link">
            <img src="/images/category.svg" width="20" /> <br>
            <small style="color: white">Kategori</small>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('promotion') }}" class="nav-link">
            <img src="/images/promo.svg" width="20" />
             <br>
            <small style="color: white">Promo</small>
          </a>
        </li>
        @guest
        <li class="nav-item">
          <a href="{{ route('login') }}" class="nav-link">
            <img src="/images/user.svg" width="20" />
             <br>
            <small style="color: white">Login</small>
          </a>
        </li>          
        @endguest
        @auth
           <li class="nav-item">
          <a href="{{ route('register') }}" class="nav-link">
            <img src="/images/user.svg" width="20" />
          </a>
        </li> 
        @endauth
      </ul>
</nav>
<nav
      class="navbar navbar-expand-lg navbar-light navbar-store fixed-top navbar-fixed-top"
      data-aos="fade-down"
    >
      <div class="container">
        <a href="{{ route('home') }}" class="navbar-brand">
          <img src="/images/logo.png" alt="Logo" style="width:52px;" />
        </a>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a href="{{  route('home') }}" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
              <a href="{{  route('categories') }}" class="nav-link">Kategori</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>