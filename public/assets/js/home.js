if(window.location.hostname === 'fortniteshop.gg' || window.location.hostname === 'www.fortniteshop.gg') {
    var $path = window.location.pathname;
    window.location = 'https://fortnitemall.gg' + $path;
}

$(document).ready(function() {
    var a = window.innerWidth;
    var b = [],
        c = [];
    $(document).find(".clkMenu").each(function(f, g) {
        var h = $(g).attr("id");
        b[h] = !1;
        var i = $(g),
            k = $(document).find("." + h + "_clkMenuBtn"),
            l = $(document).find("." + h + "_clkMenuBox");
        k.click(function() {
            768 < a && (d(h), b[h] ? (i.removeClass("cur"), l.removeClass("cur")) : (i.addClass("cur"), l.addClass("cur")), b[h] = !b[h])
        }), i.hover(function() {
            768 < a && (d(h), i.addClass("cur"), l.addClass("cur"), e(h))
        }, function() {
            768 < a && !b[h] && (c[h] = setTimeout(function() {
                i.removeClass("cur"), l.removeClass("cur")
            }, 250))
        }), l.hover(function() {
            768 < a && (d(h), i.addClass("cur"), l.addClass("cur"))
        }, function() {
            if (768 < a && !b[h] && !$.contains(i.get(0), l.get(0))) {
                var d = l.parents(".mCustomScrollBox");
                0 < d.length || (c[h] = setTimeout(function() {
                    i.removeClass("cur"), l.removeClass("cur")
                }, 250))
            }
        }), l.find("input").focus(function() {
            768 < a && i.hasClass("cur") && l.hasClass("cur") && (d(h), b[h] = !0)
        }), i.clickoutside(function(c) {
            if (768 < a) {
                var e = $(c.target),
                    f = e.parents(".mCustomScrollBox");
                if (0 < f.length || e.hasClass("mCustomScrollBox"));
                else {
                    var g = !0;
                    k.each(function(a, b) {
                        b = $(b), ($.contains(b.get(0), e.get(0)) || b.get(0) == e.get(0)) && (g = !1)
                    }), l.each(function(a, b) {
                        b = $(b), ($.contains(b.get(0), e.get(0)) || b.get(0) == e.get(0)) && (g = !1)
                    }), g && (d(h), i.removeClass("cur"), l.removeClass("cur"), b[h] = !1)
                }
            }
        })
    });
    var d = function(a) {
            c[a] && (clearTimeout(c[a]), delete c[a])
        },
        e = function(a) {
            $(document).find(".clkMenu").each(function(c, e) {
                var f = $(e).attr("id");
                if (a === f) return !0;
                b[f] = !1, d(f);
                var g = $(e),
                    h = $(document).find("." + f + "_clkMenuBox");
                g.removeClass("cur"), h.removeClass("cur")
            })
        };
    $("#quick_find").children("i.fa-search").click(function() {
        $("#quick_find").submit()
    });
    var f = !1;
    $(".m_navIcon").click(function() {
        $("body").toggleClass("ovfHiden"), $(this).toggleClass("cur");
        var a = $(".hideNav").hasClass("cur");
        a ? $(".hideNav").removeClass("cur") : $(".hideNav").addClass("cur");
        f ? a ? ($(".click_btns").siblings("ul").hide(), $(".hideNav").removeClass("cur")) : $(".click_btns").siblings("ul").addClass("out") : ($(".click_btns").siblings("ul").hide(), $(".click_btns").siblings("ul").removeClass("out"), !a && $(".hideNav").addClass("cur")), f = !f
    }), $(".click_btns").click(function() {
        768 >= a && (this.hasAttribute("data-mobile-direct") && "" != $(this).data("mobile-direct") ? window.location.href = $(this).data("mobile-direct") : ($(this).siblings("ul").show().parents("li").siblings("li").children("ul").hide(), setTimeout(function() {
            $(".hideNav").removeClass("cur")
        }, 100)))
    }), $(".backIcon").click(function() {
        $(".hideNav").addClass("cur")
    });

    $("a.noclick").click(function(e) {
        e.preventDefault();
    });

    var n = function() {
            var e = $(window).scrollTop();
            if (768 < a) {
                if (e >= $(".header-top").height()) {
                    $(".header-main").css({
                        position: "fixed",
                        top: "0"
                    }), $(".commScroll").css({
                        height: $(".header-main").height()
                    });
                    $("#announcement").css({
                        position: "fixed",
                        top: 70,
                    });
                    $("header.navbar .navbar-logo-bg").css('display', 'none');
                    $("header.navbar .navbar-logo").css('display', 'none');
                    $("header.navbar .social-media").css('display', 'none');
                    var f = $(".header-main").height()
                } else {
                    $(".header-main").removeAttr("style"), $(".commScroll").css({
                        height: "0"
                    });
                    $("#announcement").css({
                        position: "absolute",
                        top: 170,
                    });
                    $("header.navbar .navbar-logo-bg").css('display', 'block');
                    $("header.navbar .navbar-logo").css('display', 'block');
                    $("header.navbar .social-media").css('display', 'block');
                    var f = $(".header-main").height() + $(".header-top").height() - e
                }
                $(".head .hideNav").css({
                    "max-height": "calc(100vh - " + (f + 50) + "px)"
                })
            } else {
                var g = $("#hideNavNotScrollable");
                0 < g.length && ($("#hideNavNotScrollable .add_aff").insertBefore(".hideNav .lastBG"), $("#hideNavNotScrollable .lagTop").insertBefore(".hideNav .lastBG"), g.remove()), $(".hideNav").removeAttr("style");
                var h = $(".header-main").height();
                if ($(".hideNav li ul").each(function(a, b) {
                        $(b).children().last().css({
                            "margin-bottom": 50
                        })
                    }), $(".hideNav > ul").children().last().css({
                        "margin-bottom": 50
                    }), e >= h) {
                    var i = $(".header-main").height();
                    $(".head .search").css({
                        top: i
                    }), $(".hideNav li ul").css({
                        height: "calc(100vh - " + i + "px)",
                        top: i
                    }), $(".hideNav > ul").css({
                        height: "calc(100vh - " + i + "px)",
                        top: "0"
                    }), $(".header-main").css({
                        position: "fixed",
                        top: "0"
                    }), $(".commScroll").css({
                        height: i
                    }), $("#announcement").css({
                        position: "fixed",
                        top: 45,
                    })
                } else {
                    var k = $(".header").height();
                    $(".head .search").css({
                        top: k - e
                    }), $(".hideNav li ul").css({
                        height: "calc(100vh - " + (k - e) + "px)",
                        top: k - e
                    }), $(".hideNav > ul").css({
                        height: "calc(100vh - " + (k - e) + "px)",
                        top: -e
                    }), $(".header-main").removeAttr("style"), $(".commScroll").css({
                        height: "0"
                    }), $("#announcement").css({
                        position: "absolute",
                        top: 100,
                    })
                }
            }
        };


        // 768 >= a ? $("#announcement").css('top', 100) : $("#announcement").css('top', 45);

        768 >= a ? $(".footT .produkte li").removeClass("cur") : n();

        $(window).scroll(function() {
            n();
        });

    $('#quick_find').submit(function(e) {
        e.preventDefault();
    });
    var searchRequest = null;
    $('#quick_find input').keyup(function() {
        var that = this,
        value = $(this).val();

        if (value.length >= 3) {
            $('.autocomplete-suggestions').css('display', 'block');
            $('.autocomplete-suggestions').html('<div style="text-align: center; font-size: 18px; position: relative; top: 8px; height: 36px;"><i class="fa fa-spinner fa-spin"></i> Loading...</div>');
            if (searchRequest != null)
                searchRequest.abort();
            searchRequest = $.ajax({
                headers: {
                    'Accept': 'application/json'
                },
                type: 'POST',
                url: '/navsearch',
                data: {
                    search: value,
                },
                error: function(jqXHR) {
                   console.log("error", jqXHR)
                },
                success: function(responseData, textStatus, jqXHR) {
                    $(".autocomplete-suggestions").html("");

                    for (let index = 0; index < responseData.result.length; index++) {
                        const result = responseData.result[index];
                        $(".autocomplete-suggestions").append(`
                            <ul class="autocomplete-suggestion">
                                <li>
                                    <div class="ac-img">
                                        <img src="${result.image}" alt="">
                                    </div>
                                    <div class="ac-info">
                                        <div class="ac-type">
                                            ${result.type}
                                        </div>
                                        <div class="ac-name">
                                            ${result.name}
                                        </div>
                                        <div class="ac-link">
                                            <a href="${result.url}" class="btn btn-primary">View Item</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        `);

                    }
                }
            });
        }
        else {
            $('.autocomplete-suggestions').css('display', 'none');
            $('.autocomplete-suggestions').html('');
        }
    });
    $('#quick_find input').clickoutside(function(c) {
        b = $(c.target);
        f = b.parents(".autocomplete-suggestions");
        if(f.length === 0 && !b.hasClass("autocomplete-suggestions")) {
            $('.autocomplete-suggestions').css('display', 'none');
            $('.autocomplete-suggestions').html('');
        }
    });
});

(function(c){c.fn.clickoutside=function(a){var b=1,self=$(this);self.cb=a;this.click(function(){b=0});$(document).click(function(e){b&&self.cb(e);b=1});return $(this)}})(jQuery);
