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

                    <li class="nav-item @if(request()->routeIs('head.tasks.*')) active @endif">
                        <a class="nav-link" href="{{ route('head.tasks.index') }}" >
                            <x-svg.tasks></x-svg.tasks>
                            <span class="nav-link-title">
                                Topshiriqlar
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
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <x-svg.settings></x-svg.settings>
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
