var pcPlatform, ps4Platform, xboxPlatform, switchPlatform; // Checkboxes platform
var fromPrice; // Sliders' From
var toPrice; // Sliders' To
var Search, sortBy;

// var maxLevel = document.getElementById("maxLevel").textContent;
// var maxVBucks = document.getElementById("maxVBucks").textContent;
// var maxBPLevel = document.getElementById("maxBPLevel").textContent;
// var maxSkins = document.getElementById("maxSkins").textContent;
// var maxPickaxes = document.getElementById("maxPickaxes").textContent;
// var maxBackblings = document.getElementById("maxBackblings").textContent;
// var maxGliders = document.getElementById("maxGliders").textContent;
// var maxDances = document.getElementById("maxDances").textContent;
// var maxPrice = document.getElementById("maxPrice").textContent;

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

pcPlatform = $('input[type="checkbox"][name="platform_pc"]').is(":checked");
ps4Platform = $('input[type="checkbox"][name="platform_ps4"]').is(":checked");
xboxPlatform = $('input[type="checkbox"][name="platform_xbox"]').is(":checked");
switchPlatform = $('input[type="checkbox"][name="platform_switch"]').is(":checked");

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
    $("#all-skins").html('<div style="text-align: center; font-size: 18px;"><i class="fa fa-spinner fa-spin"></i> Loading...</div>');
    $.ajax({
        headers: {
            'Accept': 'application/json'
        },
        type: 'POST',
        url: '/shop/skins/skinfilter',
        data: {
            from_price: fromPrice,
            to_price: toPrice,
            platform_pc: pcPlatform,
            platform_ps4: ps4Platform,
            platform_xbox: xboxPlatform,
            platform_switch: switchPlatform,
            search: Search,
            sortBy: sortBy,
        },
        error: function(jqXHR) {
           console.log("error", jqXHR)
        },
        success: function(responseData, textStatus, jqXHR) {
            $("#all-skins").html("");
            console.log(responseData)
            for (let index = 0; index < responseData.skins.length; index++) {
                const skin = responseData.skins[index];

                // $("#skins-container").append(`
                //     <div class="skin">
                //         <p class="name">${skin.name}</p>
                //         <p class="vbucks">VBucks: ${skin.vbucks}</p>
                //         <p class="price">${skin.price}€</p>
                //         <a href="${skin.url}" class="link">Buy Now</a>
                //     </div>
                // `);

                $("#all-skins").append(`
                    <div class="col-sm-4 col-md-2 col-xl-3 col-lg-5 col-xs-5 article-grid-item" style="width:218px;">
                      <article class="product-item">
                        <div class="row">
                            <div class="col-sm-3" style="display: flex; justify-content: center; min-height: 15rem; align-items: center;">
                                <div class="product-overlay">
                                    <a href="${skin.url}" class="product-permalink"></a>
                                    <div style="position: relative;">
                                        <img style="width: 100%;" src="${skin.imageURL}" class="img-responsive" alt="Fortnitemall.gg Skin ${skin.name}">
                                    </div>
                                </div>
                              </div>
                              <div class="col-sm-9">
                                <div class="product-body">
                                    <hr style="margin-top: 0px;">
                                    <div style="font-size: 1.5rem; font-weight: 700;  min-height: 3.5rem;">
                                        ${skin.name}
                                    </div>

                                      <span class="price" style="font-size: 1.2rem;">
                                        <ins>
                                            <span class="amount text-danger" style="font-size: 2rem;">
                                                USD <span id="newPrice-${skin.external_id}">${skin.price}</span>
                                            </span>
                                        </ins>
                                      </span>
                                      <div class="buttons">
                                        <a href="${skin.url}" class="btn btn-primary btn-sm btn-block add-to-cart">
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
