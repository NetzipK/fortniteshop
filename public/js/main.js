var fromPrice, toPrice, pcPlatform, ps4Platform, xboxPlatform, brType, stwType;

$(".js-range-slider-account-level").ionRangeSlider({
    skin: "round",
    type: "double",
    min: 0,
    max: 310,
    hide_min_max: true,
    hide_from_to: true,
});

$(".js-range-slider-vbucks").ionRangeSlider({
    skin: "round",
    type: "double",
    min: 0,
    max: 10000,
    hide_min_max: true,
    hide_from_to: true,
});

$(".js-range-slider-battlepass-level").ionRangeSlider({
    skin: "round",
    type: "double",
    min: 0,
    max: 310,
    hide_min_max: true,
    hide_from_to: true,
});

$(".js-range-slider").ionRangeSlider({
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
        updateLabels();
    },
    onFinish: function (data) {
        fromPrice = data.from;
        toPrice = data.to;
        doFilteredRequest();
    },
    onChange: function (data) {
        fromPrice = data.from;
        toPrice = data.to;
        updateLabels();
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

$('input[type="checkbox"][name="type_br"]').change(function() {
    brType = $('input[type="checkbox"][name="type_br"]').is(":checked");
    doFilteredRequest();
});

$('input[type="checkbox"][name="type_stw"]').change(function() {
    stwType = $('input[type="checkbox"][name="type_stw"]').is(":checked");
    doFilteredRequest();
});

$('input[type="radio"][name="platform"]').change(function() {
    platform = $('input[type="radio"][name="platform"]:checked').val();
    doFilteredRequest();
});

$('input[type="radio"][name="email_access"]').change(function() {
    emailAccess = $('input[type="radio"][name="email_access"]:checked').val();
    doFilteredRequest();
});

pcPlatform = $('input[type="checkbox"][name="platform_pc"]').is(":checked");
ps4Platform = $('input[type="checkbox"][name="platform_ps4"]').is(":checked");
xboxPlatform = $('input[type="checkbox"][name="platform_xbox"]').is(":checked");

brType = $('input[type="checkbox"][name="type_br"]').is(":checked");
stwType = $('input[type="checkbox"][name="type_stw"]').is(":checked");

emailAccess = $('input[type="radio"][name="email_access"]:checked').val()

function updateLabels() {
    $("#fromPrice").text(`${fromPrice}`);
    $("#toPrice").text(`${toPrice}`);
}

function doFilteredRequest() {
    $.ajax({
        headers: {
            'Accept': 'application/json'
        },
        type: 'POST',
        url: 'http://localhost:8000/accounts',
        data: {
            from_price: fromPrice,
            to_price: toPrice,
            // platform: platform,
            platform_pc: pcPlatform,
            platform_ps4: ps4Platform,
            platform_xbox: xboxPlatform,
            type_br: brType,
            type_stw: stwType,
            email_access: emailAccess,
        },
        error: function(jqXHR) {
           console.log("error", jqXHR)
        },
        success: function(responseData, textStatus, jqXHR) {
            $("#accounts-container").html("");
            console.log(responseData)
            for (let index = 0; index < responseData.accounts.length; index++) {
                const account = responseData.accounts[index];

                $("#accounts-container").append(`
                    <div class="account">
                        <p class="name">${account.name}</p>
                        <p class="vbucks">VBucks: ${account.vbucks}</p>
                        <p class="price">${account.price}€</p>
                        <a href="${account.url}" class="link">Buy Now</a>
                    </div>
                `)
            }
        }
    });
}
