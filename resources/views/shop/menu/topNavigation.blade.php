<div class="top-header top-header-dark hidden-xs">
  <div class="container">
        <div class="row">
            <div class="col-sm-5"></div>
            <div class="col-sm-7 text-right">
                <ul class="list-inline links">
                    {{-- Show this only for a registered user --}}
                    @auth
                    <li>
                        <a href="{{route('shop.home')}}">
                            <i class="fa fa-user" aria-hidden="true"></i> My Account
                        </a>
                    </li>
                    <li>
                        <a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out" aria-hidden="true"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                    @endauth

                    {{-- Show this only for users thats are not logged in --}}
                    @guest
                    <li>
                        <a href="{{route('register')}}">
                            <i class="fa fa-user-plus" aria-hidden="true"></i> Register
                        </a>
                    </li>
                    <li>
                        <a href="{{route('login')}}">
                            <i class="fa fa-sign-in" aria-hidden="true"></i> Login
                        </a>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </div>
</div>