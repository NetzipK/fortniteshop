var emailAccess, currentCQ, currentEdition; // Radios
var pcPlatform, ps4Platform, xboxPlatform, switchPlatform; // Checkboxes platform
var fromPrice, fromPower, fromVBucks; // Sliders' From
var toPrice, toPower, toVBucks; // Sliders' To
var Search, sortBy;

var maxLevel = document.getElementById("maxLevel").textContent;
var maxVBucks = document.getElementById("maxVBucks").textContent;
var maxBPLevel = document.getElementById("maxBPLevel").textContent;
var maxSkins = document.getElementById("maxSkins").textContent;
var maxPickaxes = document.getElementById("maxPickaxes").textContent;
var maxBackblings = document.getElementById("maxBackblings").textContent;
var maxGliders = document.getElementById("maxGliders").textContent;
var maxDances = document.getElementById("maxDances").textContent;
var maxPrice = document.getElementById("maxPrice").textContent;

$(".js-range-slider-homebase-level").ionRangeSlider({
    skin: "round",
    type: "double",
    min: 0,
    max: 310,
    hide_min_max: true,
    hide_from_to: true,
    onStart: function(data) {
        fromPower = data.from;
        toPower = data.to;
        updateLabels("Power", fromPower, toPower);
    },
    onFinish: function (data) {
        fromPower = data.from;
        toPower = data.to;
        doFilteredRequest();
    },
    onChange: function (data) {
        fromPower = data.from;
        toPower = data.to;
        updateLabels("Power", fromPower, toPower);
    },
});

$(".js-range-slider-vbucks").ionRangeSlider({
    skin: "round",
    type: "double",
    min: 0,
    max: 10000,
    step: 100,
    hide_min_max: true,
    hide_from_to: true,
    onStart: function(data) {
        fromVBucks = data.from;
        toVBucks = data.to;
        updateLabels("VBucks", fromVBucks, toVBucks);
    },
    onFinish: function (data) {
        fromVBucks = data.from;
        toVBucks = data.to;
        doFilteredRequest();
    },
    onChange: function (data) {
        fromVBucks = data.from;
        toVBucks = data.to;
        updateLabels("VBucks", fromVBucks, toVBucks);
    },
});

$(".js-range-slider-price").ionRangeSlider({
    skin: "round",
    type: "double",
    min: 0,
    max: 310,
    prefix: '$',
    hide_min_max: true,
    hide_from_to: true,
    onStart: function(data) {
        fromPrice = data.from;
        toPrice = data.to;
        updateLabels("Price", fromPrice, toPrice);
    },
    onFinish: function (data) {
        fromPrice = data.from;
        toPrice = data.to;
        doFilteredRequest();
    },
    onChange: function (data) {
        fromPrice = data.from;
        toPrice = data.to;
        updateLabels("Price", fromPrice, toPrice);
    },
});

$('input[type="checkbox"][name="platform_pc"]').change(function() {
    pcPlatform = $('input[type="checkbox"][name="platform_pc"]').is(":checked");
    doFilteredRequest();
});

$('input[type="checkbox"][name="platform_ps4"]').change(function() {
    ps4Platform = $('input[type="checkbox"][name="platform_ps4"]').is(":checked");
    doFilteredRequest();
});

$('input[type="checkbox"][name="platform_xbox"]').change(function() {
    xboxPlatform = $('input[type="checkbox"][name="platform_xbox"]').is(":checked");
    doFilteredRequest();
});

$('input[type="checkbox"][name="platform_switch"]').change(function() {
    switchPlatform = $('input[type="checkbox"][name="platform_switch"]').is(":checked");
    doFilteredRequest();
});

$('input[type="radio"][name="email_access"]').change(function() {
    emailAccess = $('input[type="radio"][name="email_access"]:checked').val();
    doFilteredRequest();
});

$('input[type="radio"][name="current_cq"]').change(function() {
    currentCQ = $('input[type="radio"][name="current_cq"]:checked').val();
    doFilteredRequest();
});

$('input[type="radio"][name="current_edition"]').change(function() {
    currentEdition = $('input[type="radio"][name="current_edition"]:checked').val();
    doFilteredRequest();
});

pcPlatform = $('input[type="checkbox"][name="platform_pc"]').is(":checked");
ps4Platform = $('input[type="checkbox"][name="platform_ps4"]').is(":checked");
xboxPlatform = $('input[type="checkbox"][name="platform_xbox"]').is(":checked");
switchPlatform = $('input[type="checkbox"][name="platform_switch"]').is(":checked");

emailAccess = $('input[type="radio"][name="email_access"]:checked').val()
currentCQ = $('input[type="radio"][name="current_cq"]:checked').val();
currentEdition = $('input[type="radio"][name="current_edition"]:checked').val();

Search = document.getElementById('name').value;

sortBy = $('button[class=dropbtn]').text();

function formatNumber(num) {
  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}

function updateLabels(arg, from, to) {
    if(arg == "Price") {
        $(`#from${arg}`).text(`${formatNumber(from)} USD`);
        $(`#to${arg}`).text(`${formatNumber(to)} USD`);
    } else {
        $(`#from${arg}`).text(`${formatNumber(from)}`);
        $(`#to${arg}`).text(`${formatNumber(to)}`);
    }
}

$(document).ready( function () {
  doFilteredRequest();
});

function setSort(sort) {
    if(sort == "pAsc") {
        tempTxt = $('button[class=dropbtn]').text();
        $('button[class=dropbtn]').text($('a[id=selectionTwo]').text());
        $('a[id=selectionTwo]').text(tempTxt);
        doFilteredRequest();
    }
    if(sort == "pDesc") {
        tempTxt = $('button[class=dropbtn]').text();
        $('button[class=dropbtn]').text($('a[id=selectionOne]').text());
        $('a[id=selectionOne]').text(tempTxt);
        doFilteredRequest();
    }
}

// var emailAccess, currentCQ; // Radios

function doFilteredRequest() {
    Search = document.getElementById('name').value;
    sortBy = $('button[class=dropbtn]').text();
    $("#all-accounts").html('<div style="text-align: center; font-size: 18px;"><i class="fa fa-spinner fa-spin"></i> Loading...</div>');
    $.ajax({
        headers: {
            'Accept': 'application/json'
        },
        type: 'POST',
        url: '/shop/accounts/stwfilter',
        data: {
            from_price: fromPrice,
            to_price: toPrice,
            from_power: fromPower,
            to_power: toPower,
            from_vbucks: fromVBucks,
            to_vbucks: toVBucks,
            platform_pc: pcPlatform,
            platform_ps4: ps4Platform,
            platform_xbox: xboxPlatform,
            platform_switch: switchPlatform,
            email_access: emailAccess,
            current_cq: currentCQ,
            current_edition: currentEdition,
            search: Search,
            sortBy: sortBy,
        },
        error: function(jqXHR) {
           console.log("error", jqXHR)
        },
        success: function(responseData, textStatus, jqXHR) {
            $("#all-accounts").html("");
            console.log(responseData)
            for (let index = 0; index < responseData.accounts.length; index++) {
                const account = responseData.accounts[index];

                // $("#accounts-container").append(`
                //     <div class="account">
                //         <p class="name">${account.name}</p>
                //         <p class="vbucks">VBucks: ${account.vbucks}</p>
                //         <p class="price">${account.price}€</p>
                //         <a href="${account.url}" class="link">Buy Now</a>
                //     </div>
                // `);

                $("#all-accounts").append(`
                <div class="col-sm-4 col-md-2 col-xl-3 col-lg-6 col-xs-5 article-grid-item" style="width:218px;">
                  <article class="product-item" id="product-item">
                    <div class="row">
                        <div class="col-sm-3 accounts-overlay-filters" style="display: flex; justify-content: center; min-height: 15rem; align-items: center;">
                            <div class="product-overlay">
                                <a href="${account.url}" class="product-permalink"></a>
                                <div class="account-container">
                                    <img style="height: 100%;" src="${account.access_img}" class="img-responsive" alt="Fortnitemall.gg Item ${account.name}">
                                    <div class="account-level-stw">
                                        ${account.power}
                                    </div>
                                    <div class="account-vbucks-stw">
                                        ${account.vbucks}
                                    </div>
                                    ${account.edition}
                                    <div class="edition">
                                        EDITION
                                    </div>
                                    <div class="account-campagne">
                                        ${account.campaign}
                                    </div>
                                </div>
                              </div>
                          </div>
                          <div class="col-sm-9">
                            <div class="product-body">
                                <hr style="margin-top: 0px;">
                                <div style="font-size: 1.5rem; font-weight: 700;  min-height: 58px;">
                                    ${account.name}
                                </div>

                                <div class="product-labels">
                                    <!-- TO-DO IF WANTED -->
                                </div>
                                  <span class="price" style="font-size: 1.2rem;">
                                    <ins>
                                        <span class="amount text-danger" style="font-size: 2rem;">
                                            USD <span id="newPrice-${account.external_id}">${account.price}</span>
                                        </span>
                                    </ins>
                                  </span>
                                  <!-- <hr style="margin-bottom: 0px; margin-top: 10px;"> -->
                                  <div class="buttons">
                                    <a href="${account.url}" class="btn btn-primary btn-sm btn-block add-to-cart">
                                        Details
                                    </a>
                                  </div>
                              </div>
                          </div>
                      </div>
                    </article>
                  </div>
                `);
            }
        }
    });
}
