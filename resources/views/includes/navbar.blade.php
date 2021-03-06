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
            <img src="/images/category.svg" width="20" />
            <br>
            <small style="color: white">Kategori</small>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('promotion') }}" class="nav-link">
            <img src="/images/promo.svg" width="20" />
            @if ($notif_promotion != 0)
              <span class="badge badge-warning">{{ $notif_promotion }}</span> 
            @endif
             <br>
            <small style="color: white">Promo</small>
          </a>
        </li>
        @guest
        <li class="nav-item">
          <a href="{{ route('login') }}" class="nav-link">
            <img src="/images/user.svg" width="20" />
             <br>
            <small style="color: white">Akun</small>
          </a>
        </li>          
        @endguest
        @auth
           <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link">
            <img src="/images/user.svg" width="20" />
             <br>
            <small style="color: white">Akun</small>
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
        <div class="d-none d-lg-flex">
           <a href="{{ route('home') }}" class="navbar-brand">
             <img src="/images/logo.png" alt="logo" style="width:52px;" />
           </a>
          <form action="{{ route('search-product') }}" method="POST" class="form-inline">
            @csrf
            <div class="input-group">
              <input
                type="text"
                class="form-control"
                name="q"
                placeholder="Cari Produk"
              />
              <div class="input-group-append">
                <span class="input-group-text" id="basic-addon2"
                  ><i class="fa fa-search" aria-hidden="true"></i
                ></span>
              </div>
            </div>
          </form>
        </div>

        <div class="d-lg-none">
           <a href="{{ route('home') }}" class="navbar-brand">
             <img src="/images/logo.png" alt="logo" style="width:30px;" />
           </a>
           <div class="row">
             <div class="col-sm-5">
               <form action="{{ route('search-product') }}" method="POST" class="form-inline">
                 @csrf
                 <div class="input-group">
                   <input
                     type="text"
                     class="form-control"
                     name="q"
                     placeholder="Cari Produk di Percikanshop"
                   />
                   <div class="input-group-append">
                     <span class="input-group-text" id="basic-addon2"
                       ><i class="fa fa-search" aria-hidden="true"></i
                     ></span>
                   </div>
                 </div>
               </form>
             </div>
           </div>
        </div>

        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a href="{{ route('home') }}" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('categories') }}" class="nav-link">Kategori</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('promotion') }}" class="nav-link">Promo</a>
            </li>
            
            @guest
              <li class="nav-item">
                <a href="{{ route('register') }}" class="nav-link">Daftar</a>
              </li>
              <li class="nav-item">
                <a
                  href="{{ route('login') }}"
                  class="btn btn-success nav-link px-4 text-white"
                  >Login</a
                >
              </li>
            @endguest
          </ul>
          @auth
               <!-- Desktop Menu -->
          <ul class="navbar-nav d-none d-lg-flex">
            <li class="nav-item dropdown">
              <a
                href="#"
                class="nav-link"
                id="navbarDropdown"
                role="button"
                data-toggle="dropdown"
              >
                <img
                  src="/images/user_pc.png"
                  alt=""
                  class="rounded-circle mr-2 profile-picture"
                />
                Hi, {{ Auth::user()->name }}
              </a>
              <div class="dropdown-menu">
                <a href="{{ route('dashboard') }}" class="dropdown-item">Dashboard</a>
                <a href="{{ route('dashboard-settings-account') }}" class="dropdown-item"
                  >Settings</a
                >
                <div class="dropdown-divider"></div>
                <a  href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();" 
                    class="dropdown-item">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                </form>
              </div>
            </li>
            <li class="nav-item">
              <a href="{{ route('cart') }}" class="nav-link d-inline-block mt-2">
                @php
                    $carts = \App\Cart::where('users_id', Auth::user()->id)->count();
                @endphp
                @if ($carts > 0)
                <img src="/images/icon-cart-filled.svg" alt="" />
                <div class="card-badge">{{ $carts }}</div>
                @else                    
                <img src="/images/icon-cart-empty.svg" alt="" />
                @endif
              </a>
            </li>
          </ul>

          <ul class="navbar-nav d-block d-lg-none">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link">
                            Hi, {{ Auth::user()->name }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('cart') }}" class="nav-link d-inline-block">
                            Cart
                        </a>
                    </li>
                </ul>  
          @endauth
        </div>
      </div>
    </nav>