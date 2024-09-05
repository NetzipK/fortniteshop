$(document).ready(function() {
    $(".help-menu ul li > a").click(function(e) {
        e.preventDefault();
        $("#help-content").html('<div class="spinner-center"><div class="lds-facebook"><div></div><div></div><div></div></div></div>');
        $(".help-menu ul li > a").each(function() {
            $(this).removeClass("active");
        });
        $(this).addClass("active");
        link = $(this).attr('href');
        window.history.pushState("", "", link);
        $("#help-content").load(link+" #helpcontent", function(responseTxt, statusTxt, xhr){
            // if(statusTxt == "success")

          });
    });
    var link = window.location.href;
    $(".help-menu ul li > a").each(function() {
        if($(this).attr('href') === link)
            $(this).addClass("active");
    });
});
