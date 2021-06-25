<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>@yield('title')</title>

    @stack('prepend-style')
      <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
      <link href="/style/main.css" rel="stylesheet" />
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.css"/>
    @stack('addon-style')

  </head>

  <body>
    <div class="page-dashboard">
      <div class="d-flex" id="wrapper" data-aos="fade-right">
        <!-- Sidebar -->
        <div class="border-right" id="sidebar-wrapper">
          <div class="sidebar-heading text-center">
            <img src="/images/admin.png" class="my-4" style="width: 150px;" />
          </div>
          <div class="list-group list-group-flush">
            @if (Auth::user()->access == 'SUPERADMIN')
            <a
              href="{{ route('admin-dashboard') }}"
              class="list-group-item list-group-item-action"
            >
              Dashboard
            </a>
            <a
              href="{{ route('product.index') }}"
              class="list-group-item list-group-item-action {{ (request()->is('admin/product')) ? 'active' : '' }}"
            >
              Produk
            </a>
            <a
              href="{{ route('promotion.index') }}"
              class="list-group-item list-group-item-action {{ (request()->is('admin/promotion*')) ? 'active' : '' }}"
            >
              Promosi
            </a>
            <a
              href="{{ route('product-gallery.index') }}"
              class="list-group-item list-group-item-action {{ (request()->is('admin/product-gallery*')) ? 'active' : '' }}"
            >
              Galleri
            </a>

            {{-- Top Kategori --}}
            <a
              href="{{ route('topcategory.index') }}"
              class="list-group-item list-group-item-action {{ (request()->is('admin/topcategory*')) ? 'active' : '' }}"
            >
              Kategori
            </a>
            <a
              href="{{ route('category.index') }}"
              class="list-group-item list-group-item-action {{ (request()->is('admin/category*')) ? 'active' : '' }}"
            >
              Sub Kategori
            </a>
             <a
              href="{{  route('transactions.index')  }}"
              class="list-group-item list-group-item-action {{ (request()->is('admin/transactions*')) ? 'active' : '' }}"
            >
              Transaksi
            </a>
            <a
              href="{{  route('point.index')  }}"
              class="list-group-item list-group-item-action {{ (request()->is('admin/point*')) ? 'active' : '' }}"
            >
              Poin
            </a>
            <a
              href="{{  route('report.index')  }}"
              class="list-group-item list-group-item-action {{ (request()->is('admin/report*')) ? 'active' : '' }}"
            >
              Laporan
            </a>
            <a
              href="{{ route('user.index') }}"
              class="list-group-item list-group-item-action {{ (request()->is('admin/user*')) ? 'active' : '' }}"
            >
              Pengguna
            </a>
            <a
              href="{{ route('submissionidcard.index') }}"
              class="list-group-item list-group-item-action {{ (request()->is('admin/submissionidcard*')) ? 'active' : '' }}"
            >
              Pengajuan
            </a>
            <a
              href="#"
              class="list-group-item list-group-item-action"
            >
              Sign Out
            </a>
            @endif()

            @if (Auth::user()->access == 'CS')
              <a
              href="{{  route('transactions.index')  }}"
              class="list-group-item list-group-item-action {{ (request()->is('admin/transactions*')) ? 'active' : '' }}"
            >
              Transaksi
            </a>
            <a
              href="{{  route('point.index')  }}"
              class="list-group-item list-group-item-action {{ (request()->is('admin/point*')) ? 'active' : '' }}"
            >
              Poin
            </a>
            <a
              href="{{ route('user.index') }}"
              class="list-group-item list-group-item-action {{ (request()->is('admin/user*')) ? 'active' : '' }}"
            >
              Pelanggan
            </a>
            @endif
          </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
          <nav
            class="navbar navbar-expand-lg navbar-light navbar-store fixed-top"
            data-aos="fade-down"
          >
            <div class="container-fluid">
              <button
                class="button btn btn-secondary d-md-none mr-auto mr2"
                id="menu-toggle"
              >
                &laquo; Menu
              </button>
              <button
                class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navbarSupportedContent"
              >
                <span class="navbar-toggler-icon"> </span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- desktop menu -->
                <ul class="navbar-nav d-none d-lg-flex ml-auto">
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
                        class="reounded-circle mr-2 profile-picture"
                      />
                      Hi, {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu">
                      <a  class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                        Logout
                      </a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                          @csrf
                        </form>
                    </div>
                  </li>
                </ul>

                 <ul class="navbar-nav d-block d-lg-none">
                    <li class="nav-item">
                        <a href="{{ route('admin-dashboard') }}" class="nav-link">
                            Hi, {{ Auth::user()->name }}
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="{{ route('cart') }}" class="nav-link d-inline-block">
                            Cart
                        </a>
                    </li> --}}
                </ul>  
              </div>
            </div>
          </nav>
          
          {{-- Content --}}
          @yield('content')

        </div>
      </div>
    </div>
   @stack('prepend-script')
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
      AOS.init();
    </script>
    <script src="/script/navbar-scroll.js"></script>
    <script>
      $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
      });
    </script>
   @stack('addon-script')
  </body>
</html>
