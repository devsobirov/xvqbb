<div class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar navbar-light">
            <div class="container-xl">
                <ul class="navbar-nav">

                    <li class="nav-item @if(request()->routeIs('head.home') || request()->routeIs('branch.home')) active @endif">
                        <a class="nav-link" href="{{ route('home') }}" >
                            <x-svg.home></x-svg.home>
                            <span class="nav-link-title">
                               Bosh sahifa
                            </span>
                        </a>
                    </li>

                    <li class="nav-item @if(request()->routeIs('users.*')) active @endif">
                        <a class="nav-link" href="{{ route('users.index') }}" >
                            <x-svg.users></x-svg.users>
                            <span class="nav-link-title">
                                Xodimlar
                            </span>
                        </a>
                    </li>

                    <li class="nav-item dropdown @if(request()->routeIs('branches.*') || request()->routeIs('departments.*')) active @endif">
                        <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                            <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-list-details" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M13 5h8"></path>
                                    <path d="M13 9h5"></path>
                                    <path d="M13 15h8"></path>
                                    <path d="M13 19h5"></path>
                                    <rect x="3" y="4" width="6" height="6" rx="1"></rect>
                                    <rect x="3" y="14" width="6" height="6" rx="1"></rect>
                                </svg>
                            </span>
                            <span class="nav-link-title">
                            Sozlamalar
                            </span>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item @if(request()->routeIs('branches.*')) active @endif" href="{{route('branches.index')}}">
                                Filiallar
                            </a>
                            <a class="dropdown-item @if(request()->routeIs('departments.*')) active @endif" href="{{route('departments.index')}}">
                                Rahbariyat
                            </a>
                            <a class="dropdown-item" href="{{route('log-viewer.index')}}">
                                Jurnal (Log)
                            </a>
                            {{-- <div class="dropend">
                                <a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                                    Submenu Item #2
                                </a>
                                <div class="dropdown-menu">
                                  <a href="#" class="dropdown-item">
                                    Subsubmenu Item #1
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    Subsubmenu Item #2
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    Subsubmenu Item #3
                                  </a>
                                </div>
                            </div> --}}
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>
