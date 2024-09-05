var fromPrice, toPrice, platform, bronzeRank, silverRank, goldRank;

$(".js-range-slider").ionRangeSlider({
    type: "double",
    min: 1,
    max: 500,
    onStart: function(data) {
        fromPrice = data.from;
        toPrice = data.to;
    },
    onFinish: function (data) {
        fromPrice = data.from;
        toPrice = data.to;
        doFilteredRequest();
    }
});

$('input[type="checkbox"][name="rank_bronze"]').change(function() {
    bronzeRank = $('input[type="checkbox"][name="rank_bronze"]').is(":checked");
    doFilteredRequest();
});

$('input[type="checkbox"][name="rank_silver"]').change(function() {
    silverRank = $('input[type="checkbox"][name="rank_silver"]').is(":checked");
    doFilteredRequest();
});

$('input[type="checkbox"][name="rank_gold"]').change(function() {
    goldRank = $('input[type="checkbox"][name="rank_gold"]').is(":checked");
    doFilteredRequest();
});

$('input[type="radio"][name="platform"]').change(function() {
    platform = $('input[type="radio"][name="platform"]:checked').val();
    doFilteredRequest();
});

bronzeRank = $('input[type="checkbox"][name="rank_bronze"]').is(":checked");
silverRank = $('input[type="checkbox"][name="rank_silver"]').is(":checked");
goldRank = $('input[type="checkbox"][name="rank_gold"]').is(":checked");
platform = $('input[type="radio"][name="platform"]:checked').val()

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
            platform: platform,
            bronze_rank: bronzeRank,
            silver_rank: silverRank,
            gold_rank: goldRank
        },
        error: function(jqXHR) {
           console.log("error", jqXHR)
        },
        success: function(responseData, textStatus, jqXHR) {
            $("#accounts-container").html("");

            for (let index = 0; index < responseData.accounts.length; index++) {
                const account = responseData.accounts[index];

                $("#accounts-container").append(`
                    <div class="account">
                        <p class="name">${account.name}</p>
                        <p class="rank">${account.rank}</p>
                        <p class="platform">${account.platform}</p>
                        <p class="vbucks">${account.vbucks}</p>
                        <p class="price">${account.price}€</p>
                        <a href="${account.url}" class="link">Buy Now</a>
                    </div>
                `)
            }
        }
    });
}
