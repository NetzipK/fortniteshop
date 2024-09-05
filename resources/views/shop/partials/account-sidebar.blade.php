<aside class="sidebar">

  <div class="widget widget-checkbox">
    <h3><a role="button" aria-expanded="true" aria-controls="widget-discount-collapse">Account Search</a></h3>
    <div class="collapse in" id="widget-discount-collapse" aria-expanded="true" role="tabpanel">
        <div class="widget-body">
            <form id="search-articles" method="GET" action="javascript:doFilteredRequest()">
                <div class="form-group">
                    @if(Route::currentRouteName() === 'accounts.showbr')
                        <input class="form-control" id="name" name="name" type="text" placeholder="Black Knight, Mako...">
                    @elseif(Route::currentRouteName() === 'accounts.showstw')
                        <input class="form-control" id="name" name="name" type="text" placeholder="Twine Peaks, Deluxe...">
                    @endif
                </div>
               <button class="btn btn-danger btn-sm" type="submit" onclick="doFilteredRequest()">Search</button>
                @if(Route::currentRouteName() === 'accounts.showbr')
                    <a href="{{route('accounts.showbr')}}" class="btn btn-info btn-sm"><i class="fa fa-undo"></i></a>
                @elseif(Route::currentRouteName() === 'accounts.showstw')
                    <a href="{{route('accounts.showstw')}}" class="btn btn-info btn-sm"><i class="fa fa-undo"></i></a>
                @endif
            </form>
        </div>
    </div>
  </div>
  <div class="widget widget-checkbox">
    <h3><a role="button" aria-expanded="true" aria-controls="widget-discount-collapse">Categories</a></h3>
    <div class="widget-body">
        <ul class="list-unstyled">
            <li style="margin-left: 1rem;">
                <a href="{{ route('accounts.showbr') }}">
                    @if(Route::currentRouteName() === 'accounts.showbr')
                        <div class="account-container">
                            <img src="{{URL::to('/')}}/assets/images/category/01_br_button.png" alt="Battle Royale" class="account-category-checked">
                            <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" class="account-category-check">
                        </div>
                    @else
                        <img src="{{URL::to('/')}}/assets/images/category/01_br_button.png" alt="Battle Royale">
                    @endif
                </a>
            </li>
            <li style="margin-left: 1rem; margin-top: 14px;">
                <a href="{{ route('accounts.showstw') }}">
                    @if(Route::currentRouteName() === 'accounts.showstw')
                        <div class="account-container">
                            <img src="{{URL::to('/')}}/assets/images/category/02_stw_button.png" alt="Save The World" class="account-category-checked">
                            <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" class="account-category-check">
                        </div>
                    @else
                        <img src="{{URL::to('/')}}/assets/images/category/02_stw_button.png" alt="Save The World">
                    @endif
                </a>
            </li>
            {{--    <li style="margin-left: 1rem;">
                    <a class="checkbox" href="{{ route('accounts.showbr') }}"><i class="fa fa-arrow-circle-o-right"></i>
                        @if(Route::currentRouteName() === 'accounts.showbr')
                            <strong>Battle Royale</strong>
                        @else
                            Battle Royale
                        @endif
                        <hr style="margin-top: 3px; margin-bottom: 3px;">
                    </a>
                </li>
                <li style="margin-left: 2rem;">
                    <a class="checkbox" href="{{ route('accounts.showbracc') }}">
                        @if(Route::currentRouteName() === 'accounts.showbracc')
                            <strong>Full E-Mail Access</strong>
                        @else
                            Full E-Mail Access
                        @endif
                    </a>
                </li>
                <li style="margin-left: 2rem;">
                    <a class="checkbox" href="{{ route('accounts.showbrnoacc') }}">
                        @if(Route::currentRouteName() === 'accounts.showbrnoacc')
                            <strong>Without E-Mail Access</strong>
                        @else
                            Without E-Mail Access
                        @endif
                    </a>
                </li>
                <li style="margin-left: 1rem;">
                    <a class="checkbox" href="{{ route('accounts.showstw') }}"><i class="fa fa-arrow-circle-o-right"></i>
                        @if(Route::currentRouteName() === 'accounts.showstw')
                            <strong>Save The World</strong>
                        @else
                            Save The World
                        @endif
                        <hr style="margin-top: 3px; margin-bottom: 3px;">
                    </a>
                </li>
                <li style="margin-left: 2rem;">
                    <a class="checkbox" href="{{ route('accounts.showstwacc') }}">
                        @if(Route::currentRouteName() === 'accounts.showstwacc')
                            <strong>Full E-Mail Access</strong>
                        @else
                            Full E-Mail Access
                        @endif
                    </a>
                </li>
                <li style="margin-left: 2rem;">
                    <a class="checkbox" href="{{ route('accounts.showstwnoacc') }}">
                        @if(Route::currentRouteName() === 'accounts.showstwnoacc')
                            <strong>Without E-Mail Access</strong>
                        @else
                            Without E-Mail Access
                        @endif
                    </a>
                </li> --}}
            </ul>
        </div>

  </div>


</aside>
