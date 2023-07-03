<div class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar navbar-light">
            <div class="container-xl">
                <ul class="navbar-nav">

                    <li class="nav-item @if(request()->routeIs('head.home') || request()->routeIs('branch.home')) active @endif">
                        <a class="nav-link" href="{{ route('home') }}" >
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <x-svg.home></x-svg.home>
                            </span>
                            <span class="nav-link-title">
                               Bosh sahifa
                            </span>
                        </a>
                    </li>

                    @if(auth()->user()->isManager())
                    <li class="nav-item @if(request()->routeIs('head.tasks.*') || request()->routeIs('head.process.*')) active @endif">
                        <a class="nav-link" href="{{ route('head.tasks.index') }}" >
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <x-svg.tasks></x-svg.tasks>
                            </span>
                            <span class="nav-link-title">
                                Topshiriqlar
                            </span>
                        </a>
                    </li>
                    <li class="nav-item @if(request()->routeIs('head.stats.*')) active @endif">
                        <a class="nav-link" href="{{ route('head.stats.index') }}" >
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <x-svg.stats></x-svg.stats>
                            </span>
                            <span class="nav-link-title">
                                Statistika
                            </span>
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->isBranchManager())
                        <li class="nav-item @if(request()->routeIs('branch.tasks.*')) active @endif">
                            <a class="nav-link" href="{{ route('branch.tasks.index') }}" >
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <x-svg.tasks></x-svg.tasks>
                                </span>
                                <span class="nav-link-title">
                                    Topshiriqlar
                                </span>
                            </a>
                        </li>
                        <li class="nav-item @if(request()->routeIs('branch.stats.*')) active @endif">
                            <a class="nav-link" href="{{ route('branch.stats.index') }}" >
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <x-svg.stats></x-svg.stats>
                            </span>
                                <span class="nav-link-title">
                                Statistika
                            </span>
                            </a>
                        </li>
                    @endif
                    @if(auth()->user()->isAdmin())

                    <li class="nav-item @if(request()->routeIs('users.*')) active @endif">
                        <a class="nav-link" href="{{ route('users.index') }}" >
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <x-svg.users></x-svg.users>
                            </span>
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
                        </div>
                    </li>
                    @endif

                    <li class="nav-item d-md-none d-sm-block">
                        <a x-cloak href="#" @click.prevent="toggleTheme()" class="nav-link">
                            <span x-cloak x-show="!dark" class="nav-link-icon d-md-none d-lg-inline-block"><x-svg.moon></x-svg.moon></span>
                            <span x-cloak x-show="dark" class="nav-link-icon d-md-none d-lg-inline-block"><x-svg.sun></x-svg.sun></span>
                            <span x-text="dark ? `Yorug' rejinmi yoqish` : `Qorong'i rejimni yoqish`"></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
