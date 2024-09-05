@if(Route::currentRouteName() === 'accounts.showbr')
<aside class="sidebar">
<div class="col-sm-6" style="width: 47%;">
        <div class="widget widget-checkbox">
            <h3><a role="button" aria-expanded="true" aria-controls="widget-discount-collapse">General Filter</a></h3>
            <div class="collapse in" id="widget-discount-collapse" aria-expanded="true" role="tabpanel">
                <div class="widget-body" style="height: 325px;">
                    <div class="container-fluid general-filter">
                        <div class="row email-access filter-row" style="margin-bottom: 5px;">
                            <div class="col-2">
                                <label class="filter-title">Full E-Mail Access:</label>
                            </div>
                            <div class="col-6" style="display: inline-block;">
                                <input type="radio" class="custom_radio" name="email_access" value="bothea" id="bothea" checked /><label for="bothea">Both <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" style="position: absolute; width: 9px; margin-top: -23px; margin-left: 88px; display: block;"> </label>
                                <input type="radio" class="custom_radio" name="email_access" value="yesea" id="yesea" /><label for="yesea" style="border-right: 0px;"> Yes <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" style="position: absolute; width: 9px; margin-top: -23px; margin-left: 88px; display: block;"> </label>
                                <input type="radio" class="custom_radio" name="email_access" value="noea" id="noea" /><label for="noea">No <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" style="position: absolute; width: 9px; margin-top: -23px; margin-left: 88px; display: block;"> </label>
                            </div>
                        </div>
                        <div class="row account-level-filter filter-row">
                            <div class="col-2">
                                <label class="filter-title">Current Account Level:</label>
                            </div>
                            <div class="col-6 slider slider-account-level">
                                <p id="fromLevel">0</p>
                                <div style="width: 155px; display: inline-block;">
                                    <input type="text" class="js-range-slider-account-level" style="width: 150px;" name="my_range" value="" />
                                </div>
                                <p id="toLevel">310</p>
                            </div>
                        </div>
                        <div class="row account-vbucks-filter filter-row">
                            <div class="col-2">
                                <label class="filter-title">V-Bucks:</label>
                            </div>
                            <div class="col-6 slider slider-vbucks">
                                <p id="fromVBucks">0</p>
                                <div style="width: 155px; display: inline-block;">
                                    <input type="text" class="js-range-slider-vbucks" style="width: 150px;" name="my_range" value="" />
                                </div>
                                <p id="toVBucks">10.000</p>
                            </div>
                        </div>
                        <div class="row current-battlepass-filter filter-row" style="margin-bottom: 5px;">
                            <div class="col-2">
                                <label class="filter-title">Current Battle Pass:</label>
                            </div>
                            <div class="col-6" style="display: inline-block;">
                                <input type="radio" class="custom_radio" name="current_bp" value="bothbp" id="bothbp" checked /><label for="bothbp">Both <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" style="position: absolute; width: 9px; margin-top: -23px; margin-left: 88px; display: block;"> </label>
                                <input type="radio" class="custom_radio" name="current_bp" value="yesbp" id="yesbp" /><label for="yesbp" style="border-right: 0px;"> Yes <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" style="position: absolute; width: 9px; margin-top: -23px; margin-left: 88px; display: block;"> </label>
                                <input type="radio" class="custom_radio" name="current_bp" value="nobp" id="nobp" /><label for="nobp">No <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" style="position: absolute; width: 9px; margin-top: -23px; margin-left: 88px; display: block;"> </label>
                            </div>
                        </div>
                        <div class="row battlepass-level-filter filter-row">
                            <div class="col-2">
                                <label class="filter-title">Current Battle Pass Level:</label>
                            </div>
                            <div class="col-6 slider slider-battlepass-level">
                                <p id="fromBPLevel">0</p>
                                <div style="width: 155px; display: inline-block;">
                                    <input type="text" class="js-range-slider-battlepass-level" style="width: 150px;" name="my_range" value="" />
                                </div>
                                <p id="toBPLevel">310</p>
                            </div>
                        </div>
                        <div class="row platform-filter filter-row">
                            <div class="col-2">
                                <label class="filter-title">Able to link:</label>
                            </div>
                            <div class="col-6" style="display: inline-block;">
                                <input type="checkbox" class="platform_type_checkbox" id="platform_pc" name="platform_pc" value="1" /><label for="platform_pc"> <img src="{{URL::to('/')}}/assets/images/others/windows.png" alt="PC"> <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" class="platform_checked"> </label>
                                <input type="checkbox" class="platform_type_checkbox" id="platform_ps4" name="platform_ps4" value="1" /><label for="platform_ps4"> <img src="{{URL::to('/')}}/assets/images/others/ps4.png" alt="PS4"> <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" class="platform_checked"> </label>
                                <input type="checkbox" class="platform_type_checkbox" id="platform_xbox" name="platform_xbox" value="1" /><label for="platform_xbox"> <img src="{{URL::to('/')}}/assets/images/others/xbox.png" alt="XBOX"> <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" class="platform_checked"> </label>
                                <input type="checkbox" class="platform_type_checkbox" id="platform_switch" name="platform_switch" value="1" /><label for="platform_switch"> <img src="{{URL::to('/')}}/assets/images/others/swittch.png" alt="SWITCH"> <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" class="platform_checked"> </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</aside>
<aside class="sidebar">
<div style="width: 30%;" class="col-sm-4">
        <div class="widget widget-checkbox">
            <h3><a role="button" aria-expanded="true" aria-controls="widget-discount-collapse">Skin Filter</a></h3>
            <div class="collapse in" id="widget-discount-collapse" aria-expanded="true" role="tabpanel">
                <div class="widget-body" style="height: 325px;">
                    <div class="container skin-filter">
                        <div class="skin-filter-row">
                            <div class="col-2">
                                <img src="{{URL::to('/')}}/assets/images/others/01_skin.png" alt="Skin">
                                <img src="{{URL::to('/')}}/assets/images/others/02_pickaxe.png" alt="Pickaxe">
                                <img src="{{URL::to('/')}}/assets/images/others/03_backbling.png" alt="BackBling">
                                <img src="{{URL::to('/')}}/assets/images/others/04_glider.png" alt="Glider">
                                <img src="{{URL::to('/')}}/assets/images/others/05_emote.png" alt="Emote">
                            </div>
                            <div class="col-5 slider-col skin-border">
                                <p id="fromSkins" style="margin: 15px 0px 15px;">1</p>
                                <div style="width: 155px; display: inline-block;">
                                    <input type="text" class="js-range-slider-account-skins" style="width: 150px;" name="my_range" value="" />
                                </div>
                                <p id="toSkins" style="margin: 15px 0px 15px;">200</p>
                                <hr>
                                <p id="fromPickaxes">1</p>
                                <div style="width: 155px; display: inline-block;">
                                    <input type="text" class="js-range-slider-account-pickaxes" style="width: 150px;" name="my_range" value="" />
                                </div>
                                <p id="toPickaxes">200</p>
                                <hr>
                                <p id="fromBackblings">1</p>
                                <div style="width: 155px; display: inline-block;">
                                    <input type="text" class="js-range-slider-account-backblings" style="width: 150px;" name="my_range" value="" />
                                </div>
                                <p id="toBackblings">200</p>
                                <hr>
                                <p id="fromGliders">1</p>
                                <div style="width: 155px; display: inline-block;">
                                    <input type="text" class="js-range-slider-account-gliders" style="width: 150px;" name="my_range" value="" />
                                </div>
                                <p id="toGliders">200</p>
                                <hr>
                                <p id="fromDances">1</p>
                                <div style="width: 155px; display: inline-block;">
                                    <input type="text" class="js-range-slider-account-dances" style="width: 150px;" name="my_range" value="" />
                                </div>
                                <p id="toDances">200</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</aside>
@elseif(Route::currentRouteName() === 'accounts.showstw')
<aside class="sidebar">
<div class="col-sm-6" style="width: 77%;">
        <div class="widget widget-checkbox">
            <h3><a role="button" aria-expanded="true" aria-controls="widget-discount-collapse">General Filter</a></h3>
            <div class="collapse in" id="widget-discount-collapse" aria-expanded="true" role="tabpanel">
                <div class="widget-body" style="height: 325px;">
                    <div class="container general-filter-stw">
                        <div class="row email-access filter-row" style="margin-bottom: 5px;">
                            <div class="col-2">
                                <label class="filter-title">Full E-Mail Access:</label>
                            </div>
                            <div class="col-6" style="display: inline-block;">
                                <input type="radio" class="custom_radio" name="email_access" value="bothea" id="bothea" checked /><label for="bothea">Both <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" style="position: absolute; width: 9px; margin-top: -23px; margin-left: 88px; display: block;"> </label>
                                <input type="radio" class="custom_radio" name="email_access" value="yesea" id="yesea" /><label for="yesea" style="border-right: 0px;"> Yes <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" style="position: absolute; width: 9px; margin-top: -23px; margin-left: 88px; display: block;"> </label>
                                <input type="radio" class="custom_radio" name="email_access" value="noea" id="noea" /><label for="noea">No <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" style="position: absolute; width: 9px; margin-top: -23px; margin-left: 88px; display: block;"> </label>
                            </div>
                        </div>
                        <div class="row account-level-filter filter-row">
                            <div class="col-2">
                                <label class="filter-title">Homebase Power:</label>
                            </div>
                            <div class="col-6 slider slider-account-level">
                                <p id="fromPower">0</p>
                                <div style="width: 155px; display: inline-block;">
                                    <input type="text" class="js-range-slider-homebase-level" style="width: 150px;" name="my_range" value="" />
                                </div>
                                <p id="toPower">310</p>
                            </div>
                        </div>
                        <div class="row account-vbucks-filter filter-row">
                            <div class="col-2">
                                <label class="filter-title">V-Bucks:</label>
                            </div>
                            <div class="col-6 slider slider-vbucks">
                                <p id="fromVBucks">0</p>
                                <div style="width: 155px; display: inline-block;">
                                    <input type="text" class="js-range-slider-vbucks" style="width: 150px;" name="my_range" value="" />
                                </div>
                                <p id="toVBucks">310</p>
                            </div>
                        </div>
                        <div class="row current-battlepass-filter filter-row" style="margin-bottom: 5px;">
                            <div class="col-2">
                                <label class="filter-title">Campaign quest:</label>
                            </div>
                            <div class="col-6" style="display: inline-block;">
                                <input type="radio" class="custom_radio quest" name="current_cq" value="t1" id="t1" checked /><label for="t1">T1: Stonewood <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" style="position: absolute; width: 9px; margin-top: -23px; margin-left: 88px; display: block;"> </label>
                                <input type="radio" class="custom_radio quest" name="current_cq" value="t2" id="t2" /><label for="t2" style="border-right: 0px;">T2: Plankerton <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" style="position: absolute; width: 9px; margin-top: -23px; margin-left: 88px; display: block;"> </label>
                                <input type="radio" class="custom_radio quest" name="current_cq" value="t3" id="t3" /><label for="t3">T3: Canney Valley <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" style="position: absolute; width: 9px; margin-top: -23px; margin-left: 88px; display: block;"> </label>
                                <input type="radio" class="custom_radio quest" name="current_cq" value="t4" id="t4" /><label for="t4">T4: Twine Peaks <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" style="position: absolute; width: 9px; margin-top: -23px; margin-left: 88px; display: block;"> </label>
                            </div>
                        </div>
                        <div class="row current-battlepass-filter filter-row" style="margin-bottom: 5px;">
                            <div class="col-2">
                                <label class="filter-title">Edition:</label>
                            </div>
                            <div class="col-6" style="display: inline-block;">
                                <input type="radio" class="custom_radio quest" name="current_edition" value="both" id="both" checked /><label for="both">All <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" style="position: absolute; width: 9px; margin-top: -23px; margin-left: 88px; display: block;"> </label>
                                <input type="radio" class="custom_radio quest" name="current_edition" value="standard" id="standard" /><label for="standard">Standard <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" style="position: absolute; width: 9px; margin-top: -23px; margin-left: 88px; display: block;"> </label>
                                <input type="radio" class="custom_radio quest" name="current_edition" value="deluxe" id="deluxe" /><label for="deluxe" style="border-right: 0px;">Deluxe <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" style="position: absolute; width: 9px; margin-top: -23px; margin-left: 88px; display: block;"> </label>
                                <input type="radio" class="custom_radio quest" name="current_edition" value="super_deluxe" id="super_deluxe" /><label for="super_deluxe">Super Deluxe <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" style="position: absolute; width: 9px; margin-top: -23px; margin-left: 88px; display: block;"> </label>
                            </div>
                        </div>
                        <div class="row platform-filter filter-row">
                            <div class="col-2">
                                <label class="filter-title">Able to link:</label>
                            </div>
                            <div class="col-6" style="display: inline-block;">
                                <input type="checkbox" class="platform_type_checkbox" id="platform_pc" name="platform_pc" value="1" /><label for="platform_pc"> <img src="{{URL::to('/')}}/assets/images/others/windows.png" alt="PC"> <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" class="platform_checked"> </label>
                                <input type="checkbox" class="platform_type_checkbox" id="platform_ps4" name="platform_ps4" value="1" /><label for="platform_ps4"> <img src="{{URL::to('/')}}/assets/images/others/ps4.png" alt="PS4"> <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" class="platform_checked"> </label>
                                <input type="checkbox" class="platform_type_checkbox" id="platform_xbox" name="platform_xbox" value="1" /><label for="platform_xbox"> <img src="{{URL::to('/')}}/assets/images/others/xbox.png" alt="XBOX"> <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" class="platform_checked"> </label>
                                <input type="checkbox" class="platform_type_checkbox" id="platform_switch" name="platform_switch" value="1" /><label for="platform_switch"> <img src="{{URL::to('/')}}/assets/images/others/swittch.png" alt="SWITCH"> <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" class="platform_checked"> </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</aside>
@endif
<aside class="sidebar">
<div style="width: 77%;" class="col-sm-10">
        <div class="widget widget-checkbox" style="margin-top: -6px; border-bottom: 4px solid #19A5D4;">
            <div class="collapse in" id="widget-discount-collapse" aria-expanded="true" role="tabpanel">
                <div class="widget-body" style="height: 45px;">
                    <div class="container price-filter">
                        <div class="col-lg-2 col-sm-2">
                            <label class="filter-title" style="margin-left: 2px;">Sort by:</label>
                            <div class="dropdown-filter">
                                <button class="dropbtn" id="btnTxt">newest</button>
                                <div class="dropdown-content">
                                    <a href="javascript:setSort('pDesc')" id="selectionOne">price descending</a>
                                    <a href="javascript:setSort('pAsc')" id="selectionTwo">price ascending</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-10" style="display: inline-block;">
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
</div>
</aside>
