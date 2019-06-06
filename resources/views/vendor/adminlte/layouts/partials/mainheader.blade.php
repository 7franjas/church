<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ url('/home') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><img src="{{url('/img/logo/svg/logo-mini.svg')}}" class="svg-logo" onError="this.onerror=null;this.src='/img/logo/png/logo-mini.png';" /></span>
        <span class="logo-mini logo-color"><img src="{{url('/img/logo/svg/logo-mini-color.svg')}}" class="svg-logo" onError="this.onerror=null;this.src='/img/logo/png/logo-mini-color.png';" /></span>
    
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><img src="{{url('/img/logo/png/logo.png')}}" class="svg-logo" onError="this.onerror=null;this.src='/img/logo/png/logo.png';" /></span>
        <span class="logo-lg logo-color"><img src="{{url('/img/logo/png/logo-color.png')}}" class="svg-logo" onError="this.onerror=null;this.src='/img/logo/png/logo-color.png';" /></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">{{ trans('adminlte_lang::message.togglenav') }}</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                @if (Auth::guest())
                    <li><a href="{{ url('/register') }}">{{ trans('adminlte_lang::message.register') }}</a></li>
                    <li><a href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a></li>
                @else
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu" id="user_menu" style="max-width: 280px;white-space: nowrap;">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img id="menu-profile-user-img" onError="this.onerror=null;this.src='/img/avatar/default.png';" src="{{ url('/img/avatar/'.Auth::user()->avatar) }}" class="user-image" alt="User Image"/>
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ explode(' ',trim(Auth::user()->name))[0] }}</span>
                        </a>

                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li>
                                <a href="{{ url('/profile') }}"><i class="fa fa-user"></i> Mi Perfil</a>
                            </li>
                            <li>
                                <a href="{{ url('/logout') }}" id="logout"
                                    onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i>Cerrar Sesión
                                </a>
                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                        <input type="submit" value="logout" style="display: none;">
                                    </form>
                            </li>
                        </ul>
                    </li>
                @endif

                <!-- Control Sidebar Toggle Button 
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>-->
            </ul>
        </div>
    </nav>
</header>
