$("#btn_logout").click(function (e) {
    e.preventDefault();
    $.ajax({
        type: "post",
        url: "logout",
        data: { _token: $("meta[name=csrf-token]").attr("content") },
        // dataType: "dataType",
        success: function (response) {
            if (response) {
                window.location.href = "/creden";
            }
        },
    });
});
$("#btn_menu_A").click(function (e) {
    e.preventDefault();
    $.ajax({
        type: "get",
        url: "credenciales/view_1",
        // data: "data",
        // dataType: "dataType",
        success: function (response) {
            $("#main_cont").html(response);
            queryShow_1();
        },
    });
});
$("#btn_menu_B_User").click(function (e) {
    e.preventDefault();
    $.ajax({
        type: "get",
        url: "Usuarios/view_2_user",
        // data: "data",
        // dataType: "dataType",
        success: function (response) {
            $("#main_cont").html(response);
        },
    });
});
$("#btn_menu_B_Empr").click(function (e) {
    e.preventDefault();
    $.ajax({
        type: "get",
        url: "Empresa/view_2_empr",
        // data: "data",
        // dataType: "dataType",
        success: function (response) {
            $("#main_cont").html(response);
        },
    });
});
$(" #btn_menu_creden_B").click(function (e) {
    e.preventDefault();
    $.get("credenciales/view_cv_1", function (data, textStatus, jqXHR) {
        $("#main_cont").html(data);
    });
});
$(" #btn_menu_viculos").click(function (e) {
    e.preventDefault();
    $.get("Vehiculo/view_vei_home", function (data, textStatus, jqXHR) {
        $("#main_cont").html(data);
    });
});
const viewTerminal = () => {
    $.get("terminal/view_home", function (data, textStatus, jqXHR) {
        $("#main_cont").html(data);
    });
};
function noti_fi(tp, tx) {
    switch (tp) {
        case 1:
            params = {
                heading: "Correcto",
                text: tx,
                showHideTransition: "slide",
                icon: "success",
                loaderBg: "#f96868",
                position: "top-right",
                family: "amethyst",
            };

            break;
        case 2:
            params = {
                heading: "Información",
                text: tx,
                showHideTransition: "slide",
                icon: "info",
                loaderBg: "#46c35f",
                position: "top-right",
            };
            break;
        case 3:
            params = {
                heading: "Alerta",
                text: tx,
                showHideTransition: "slide",
                icon: "warning",
                loaderBg: "#57c7d4",
                position: "top-right",
            };
            break;
        case 4:
            params = {
                heading: "Error!",
                text: tx,
                showHideTransition: "slide",
                icon: "error",
                loaderBg: "#f2a654",
                position: "top-right",
            };
            break;

        default:
            break;
    }
    $.toast(params);
}
!(function (e, i, t) {
    "use strict";
    t(i).ready(function () {
        function a(e, i) {
            e.children(".submenu-content")
                .show()
                .slideUp(200, function () {
                    t(this).css("display", ""),
                        t(this).find(".menu-item").removeClass("is-shown"),
                        e.removeClass("open"),
                        i && i();
                });
        }
        var s = t(".app-sidebar"),
            n = t(".sidebar-content"),
            l = t(".wrapper"),
            o = i.querySelector(".sidebar-content");
        new PerfectScrollbar(o, {
            wheelSpeed: 10,
            wheelPropagation: !0,
            minScrollbarLength: 5,
        }),
            n.on("click", ".navigation-main .nav-item a", function () {
                var e = t(this).parent(".nav-item");
                if (e.hasClass("has-sub") && e.hasClass("open")) a(e);
                else {
                    if (
                        (e.hasClass("has-sub") &&
                            (function (e, i) {
                                var a = e.children(".submenu-content"),
                                    s = a
                                        .children(".menu-item")
                                        .addClass("is-hidden");
                                e.addClass("open"),
                                    a.hide().slideDown(200, function () {
                                        t(this).css("display", "");
                                    }),
                                    setTimeout(function () {
                                        s.addClass("is-shown"),
                                            s.removeClass("is-hidden");
                                    }, 0);
                            })(e),
                        n.data("collapsible"))
                    )
                        return !1;
                    a(e.siblings(".open")),
                        e
                            .siblings(".open")
                            .find(".nav-item.open")
                            .removeClass("open");
                }
            }),
            t(".nav-toggle").on("click", function () {
                var e = t(this).find(".toggle-icon");
                "expanded" === e.attr("data-toggle")
                    ? (l.addClass("nav-collapsed"),
                      t(".nav-toggle")
                          .find(".toggle-icon")
                          .removeClass("ik-toggle-right")
                          .addClass("ik-toggle-left"),
                      e.attr("data-toggle", "collapsed"))
                    : (l.removeClass("nav-collapsed menu-collapsed"),
                      t(".nav-toggle")
                          .find(".toggle-icon")
                          .removeClass("ik-toggle-left")
                          .addClass("ik-toggle-right"),
                      e.attr("data-toggle", "expanded"));
            }),
            s
                .on("mouseenter", function () {
                    if (l.hasClass("nav-collapsed")) {
                        l.removeClass("menu-collapsed");
                        var e = t(
                            ".navigation-main .nav-item.nav-collapsed-open"
                        );
                        e
                            .children(".submenu-content")
                            .hide()
                            .slideDown(300, function () {
                                t(this).css("display", "");
                            }),
                            n
                                .find(".nav-item.active")
                                .parents(".nav-item")
                                .addClass("open"),
                            e
                                .addClass("open")
                                .removeClass("nav-collapsed-open");
                    }
                })
                .on("mouseleave", function (e) {
                    if (l.hasClass("nav-collapsed")) {
                        l.addClass("menu-collapsed");
                        var i = t(".navigation-main .nav-item.open"),
                            a = i.children(".submenu-content");
                        i.addClass("nav-collapsed-open"),
                            a.show().slideUp(300, function () {
                                t(this).css("display", "");
                            }),
                            i.removeClass("open");
                    }
                }),
            t(e).width() < 992 &&
                (s.addClass("hide-sidebar"),
                l.removeClass("nav-collapsed menu-collapsed")),
            t(e).resize(function () {
                t(e).width() < 992 &&
                    (s.addClass("hide-sidebar"),
                    l.removeClass("nav-collapsed menu-collapsed")),
                    t(e).width() > 992 &&
                        (s.removeClass("hide-sidebar"),
                        "collapsed" === t(".toggle-icon").attr("data-toggle") &&
                            l.not(".nav-collapsed menu-collapsed") &&
                            l.addClass("nav-collapsed menu-collapsed"));
            }),
            t(i).on("click", ".navigation li:not(.has-sub)", function () {
                t(e).width() < 992 && s.addClass("hide-sidebar");
            }),
            t(i).on("click", ".logo-text", function () {
                t(e).width() < 992 && s.addClass("hide-sidebar");
            }),
            t(".mobile-nav-toggle").on("click", function (e) {
                e.stopPropagation(), s.toggleClass("hide-sidebar");
            }),
            t("html").on("click", function (i) {
                t(e).width() < 992 &&
                    (s.hasClass("hide-sidebar") ||
                        0 !== s.has(i.target).length ||
                        s.addClass("hide-sidebar"));
            }),
            t("#sidebarClose").on("click", function () {
                s.addClass("hide-sidebar");
            }),
            t('[data-toggle="tooltip"]').tooltip(),
            t("#checkbox_select_all").on("click", function () {
                for (
                    var e = i.getElementsByName("item_checkbox"), a = 0;
                    a < e.length;
                    a++
                )
                    "checkbox" == e[a].type && (e[a].checked = !0),
                        t(e).parent().parent().addClass("selected");
            }),
            t("#checkbox_deselect_all").on("click", function () {
                for (
                    var e = i.getElementsByName("item_checkbox"), a = 0;
                    a < e.length;
                    a++
                )
                    "checkbox" == e[a].type && (e[a].checked = !1),
                        t(e).parent().parent().removeClass("selected");
            }),
            t("#quick-search").keyup(function () {
                var e = t(this).val().trim().toLowerCase();
                t(".app-item")
                    .hide()
                    .filter(function () {
                        return (
                            -1 != t(this).html().trim().toLowerCase().indexOf(e)
                        );
                    })
                    .show();
            }),
            t(".list-item input:checkbox").change(function () {
                t(this).is(":checked")
                    ? t(this).parent().parent().addClass("selected")
                    : t(this).parent().parent().removeClass("selected");
            }),
            t("#navbar-fullscreen").on("click", function (e) {
                "undefined" != typeof screenfull &&
                    screenfull.enabled &&
                    screenfull.toggle();
            }),
            t("#selectall").click(function () {
                t(this).is(":checked")
                    ? t(".select_all_child:checkbox").attr("checked", !0)
                    : t(".select_all_child:checkbox").attr("checked", !1);
            }),
            t(".list-item-wrap .list-item .list-title a").on(
                "click",
                function (e) {
                    t(".list-item.quick-view-opened")
                        .not(this)
                        .removeClass("quick-view-opened"),
                        t(this)
                            .parents()
                            .parent(".list-item")
                            .toggleClass("quick-view-opened");
                }
            ),
            t(i).on("click", function (e) {
                t(e.target).closest(".list-item").length ||
                    t(".list-item").removeClass("quick-view-opened");
            }),
            "undefined" != typeof screenfull &&
                screenfull.enabled &&
                t(i).on(screenfull.raw.fullscreenchange, function () {
                    screenfull.isFullscreen
                        ? t("#navbar-fullscreen")
                              .find("i")
                              .toggleClass("ik-minimize ik-maximize")
                        : t("#navbar-fullscreen")
                              .find("i")
                              .toggleClass("ik-maximize ik-minimize");
                }),
            t(".minimize-widget").on("click", function () {
                var e = t(this),
                    i = t(e.parents(".widget"));
                t(i).children(".widget-body").slideToggle(),
                    t(this).toggleClass("ik-minus").fadeIn("slow"),
                    t(this).toggleClass("ik-plus").fadeIn("slow");
            }),
            t(".remove-widget").on("click", function () {
                var e = t(this);
                e.parents(".widget").animate({
                    opacity: "0",
                    "-webkit-transform": "scale3d(.3, .3, .3)",
                    transform: "scale3d(.3, .3, .3)",
                }),
                    setTimeout(function () {
                        e.parents(".widget").remove();
                    }, 800);
            }),
            t(".card-header-right .card-option .action-toggle").on(
                "click",
                function () {
                    var e = t(this);
                    e.hasClass("ik-chevron-right")
                        ? e.parents(".card-option").animate({ width: "28px" })
                        : e.parents(".card-option").animate({ width: "90px" }),
                        t(this).toggleClass("ik-chevron-right").fadeIn("slow");
                }
            ),
            t(".card-header-right .close-card").on("click", function () {
                var e = t(this);
                e.parents(".card").animate({
                    opacity: "0",
                    "-webkit-transform": "scale3d(.3, .3, .3)",
                    transform: "scale3d(.3, .3, .3)",
                }),
                    setTimeout(function () {
                        e.parents(".card").remove();
                    }, 800);
            }),
            t(".card-header-right .minimize-card").on("click", function () {
                var e = t(this),
                    i = t(e.parents(".card"));
                t(i).children(".card-body").slideToggle(),
                    t(this).toggleClass("ik-minus").fadeIn("slow"),
                    t(this).toggleClass("ik-plus").fadeIn("slow");
            }),
            t(".task-list").on("click", "li.list", function () {
                t(this).toggleClass("completed");
            }),
            t(".search-btn").on("click", function () {
                t(".header-search").addClass("open"),
                    t(".header-search .form-control").animate({
                        width: "200px",
                    });
            }),
            t(".search-close").on("click", function () {
                t(".header-search .form-control").animate({ width: "0" }),
                    setTimeout(function () {
                        t(".header-search").removeClass("open");
                    }, 300);
            });
        new PerfectScrollbar(".right-sidebar", {
            wheelSpeed: 10,
            wheelPropagation: !0,
            minScrollbarLength: 5,
        }),
            new PerfectScrollbar(".messages", {
                wheelSpeed: 10,
                wheelPropagation: !0,
                minScrollbarLength: 5,
            });
        $(".right-sidebar-toggle").on("click", function (e) {
            return (
                this.classList.toggle("active"),
                $(".wrapper").toggleClass("right-sidebar-expand"),
                !1
            );
        }),
            document.addEventListener("click", function (e) {
                var i = document.getElementsByClassName("right-sidebar")[0],
                    t = document.getElementsByClassName("chat-panel")[0];
                if (!(i.contains(e.target) || t.contains(e.target))) {
                    document.body.classList.remove("right-sidebar-expand");
                    for (
                        var a = document.getElementsByClassName(
                                "right-sidebar-toggle"
                            ),
                            s = 0;
                        s < a.length;
                        s++
                    )
                        a[s].classList.remove("active");
                    t.hidden = "hidden";
                }
            });
        c = $('[data-plugin="chat-sidebar"]');
        if (c.length) {
            c.find(".chat-list").each(function (e) {
                var i = $(this);
                $(this)
                    .find(".list-group a")
                    .on("click", function () {
                        i.find(".list-group a.active").removeClass("active"),
                            $(this).addClass("active");
                        var e = $(".chat-panel");
                        if (e.length) {
                            e.removeAttr("hidden");
                            var t = e.find(".messages");
                            (t[0].scrollTop = t[0].scrollHeight),
                                t[0].classList.contains("scrollbar-enabled") &&
                                    t.perfectScrollbar("update"),
                                e
                                    .find(".user-name")
                                    .html($(this).data("chat-user"));
                        }
                    });
            });
            var c;
            if ((c = $(".chat-panel")).length) {
                c.find(".close").on("click", function () {
                    c.attr("hidden", !0),
                        c.find(".panel-body").removeClass("hide");
                }),
                    c.find(".minimize").on("click", function () {
                        c
                            .find(".card-block")
                            .attr(
                                "hidden",
                                !c.find(".card-block").attr("hidden")
                            ),
                            "hidden" === c.find(".card-block").attr("hidden")
                                ? $(this)
                                      .find(".material-icons")
                                      .html("expand_less")
                                : $(this)
                                      .find(".material-icons")
                                      .html("expand_more");
                    });
                var d = $("a.view-grid"),
                    r = $("a.view-thumb"),
                    h = $("a.view-list"),
                    m = ($("ul.view-as"), $(".dispaly-option-buttons a"));
                d.click(function () {
                    $("#layout-wrap .list-item").attr(
                        "class",
                        "col-xl-3 col-lg-4 col-12 col-sm-6 mb-4 list-item list-item-grid"
                    );
                }),
                    h.click(function () {
                        $("#layout-wrap .list-item").attr(
                            "class",
                            "col-12 list-item"
                        );
                    }),
                    r.click(function () {
                        $("#layout-wrap .list-item").attr(
                            "class",
                            "col-12 list-item list-item-thumb"
                        );
                    }),
                    $(m).on("click", function () {
                        $(m).removeClass("active"), $(this).addClass("active");
                    });
            }
        }
    });
})(window, document, jQuery);
