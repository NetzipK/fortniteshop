<aside class="sidebar col-sm-6 col-lg-2" style="min-width: 22%;">
  <div class="widget widget-checkbox">
    <h3><a role="button" aria-expanded="true" aria-controls="widget-discount-collapse">Skin Search</a></h3>
    <div class="collapse in" id="widget-discount-collapse" aria-expanded="true" role="tabpanel">
        <div class="widget-body" style="height: 125px;">
            <form id="search-articles" method="GET" action="javascript:doFilteredRequest()">
                @csrf
                <div class="form-group">
                    <input class="form-control" id="name" name="name" type="text" placeholder="Counterattack, Reflex...">
                </div>
               <button class="btn btn-danger btn-sm" type="submit" onclick="doFilteredRequest();">Search</button>
                <a href="{{route('skins.index')}}" class="btn btn-info btn-sm"><i class="fa fa-undo"></i></a>
            </form>
        </div>
    </div>
  </div>
</aside>

<aside class="sidebar col-sm-8" style="min-width: 77%;">
    <div class="widget widget-checkbox">
        <h3><a role="button" aria-expanded="true" aria-controls="widget-discount-collapse">General Filter</a></h3>
        <div class="collapse in" id="widget-discount-collapse" aria-expanded="true" role="tabpanel">
            <div class="widget-body" style="min-height: 125px;">
                <div class="container-fluid skin-general-filter">
                <div class="row platform-filter filter-row">
                        <div class="col-2">
                            <label class="filter-title">Platform:</label>
                        </div>
                        <div class="col-6" style="display: inline-block;">
                            <input type="checkbox" class="platform_type_checkbox" id="platform_pc" name="platform_pc" value="1" /><label for="platform_pc"> <img src="{{URL::to('/')}}/assets/images/others/windows.png" alt="PC"> <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" class="platform_checked"> </label>
                            <input type="checkbox" class="platform_type_checkbox" id="platform_ps4" name="platform_ps4" value="1" /><label for="platform_ps4"> <img src="{{URL::to('/')}}/assets/images/others/ps4.png" alt="PS4"> <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" class="platform_checked"> </label>
                            <input type="checkbox" class="platform_type_checkbox" id="platform_xbox" name="platform_xbox" value="1" /><label for="platform_xbox"> <img src="{{URL::to('/')}}/assets/images/others/xbox.png" alt="XBOX"> <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" class="platform_checked"> </label>
                            <input type="checkbox" class="platform_type_checkbox" id="platform_switch" name="platform_switch" value="1" /><label for="platform_switch"> <img src="{{URL::to('/')}}/assets/images/others/swittch.png" alt="SWITCH"> <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" class="platform_checked"> </label>
                        </div>
                    </div>
                    <div class="row region-filter filter-row" style="margin-bottom: -10px;">
                        <div class="col-2">
                            <label class="filter-title" style="margin-left: 5.5px;">Region:</label>
                        </div>
                        <div class="col-6" style="display: inline-block;">
                            <input type="radio" class="custom_radio" name="region" value="all" id="all" checked /><label for="all">All<img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" style="position: absolute; width: 9px; margin-top: -23px; margin-left: 80px; display: block;"> </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside>

<aside class="sidebar col-sm-11" style="min-width: 99%">
    <div class="widget widget-checkbox" style="margin-top: -6px; border-bottom: 4px solid #19A5D4;">
        <div class="collapse in" id="widget-discount-collapse" aria-expanded="true" role="tabpanel">
            <div class="widget-body" style="height: 45px;">
                <div class="container price-filter" style="margin-left: 70px;">
                    <div class="col-lg-4 col-sm-2" style="text-align:right;">
                        <label class="filter-title" style="margin-left: 2px;">Sort by:</label>
                        <div class="dropdown-filter">
                            <button class="dropbtn" id="btnTxt">newest</button>
                            <div class="dropdown-content">
                                <a href="javascript:setSort('pDesc')" id="selectionOne">price descending</a>
                                <a href="javascript:setSort('pAsc')" id="selectionTwo">price ascending</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8" style="display: inline-block;">
                        <label class="filter-title">Price:</label>
                        <div class="col-6 slider slider-vbucks" style="margin-top: -8px;">
                            <p id="fromPrice">20 USD</p>
                            <div style="width: 300px;display: inline-block; margin-top: -8px;">
                                <input type="text" class="js-range-slider-price" style="width: 200px;" name="my_range" value="" />
                            </div>
                            <p id="toPrice">300 USD</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside>
