var xzmui = xzmui || {};
xzmui.clickName = "click",
xzmui.path = "http://st.xizi.com/xzmui/",
xzmui.libs = {
    swiper: ["swiper/swiper.min.js", "swiper/swiper.min.css"],
    mobiscroll: ["mobiscroll/mobiscroll.min.js", "mobiscroll/mobiscroll.min.css"],
    upload: ["upload/lrz.mobile.min.js"],
    upload2: ["upload2/lrz.mobile.min.js"],
    iscroll: ["iscroll/iscroll-zoom.js"]
},
xzmui.load = function(i, t) {
    function e(i) {
        if (n("js", i)) {
            var t = document.createElement("script");
            t.type = "text/javascript",
            t.src = i,
            o.appendChild(t),
            t.onload = function() {
                s()
            }
        } else s()
    }
    function a(i) {
        if (n("css", i)) {
            var t = document.createElement("link");
            t.rel = "stylesheet",
            t.href = i,
            o.appendChild(t),
            t.onload = function() {
                s()
            }
        } else s()
    }
    function n(i, t) {
        var e = "script",
        a = "src";
        "css" === i && (e = "link", a = "href");
        for (var n = document.getElementsByTagName(e), s = 0; s < n.length; s++) if (n[s].getAttribute(a) == t) return ! 1;
        return ! 0
    }
    function s() {
        u++,
        u == l.length && t()
    }
    var o = document.getElementsByTagName("head")[0],
    l = [],
    u = 0;
    $.isArray(i) || (i = [i]);
    for (var c = 0; c < i.length; c++) if ( - 1 != i[c].indexOf(".")) l.push(i[c]);
    else for (var r in xzmui.libs) if (r == i[c]) {
        for (var d = 0; d < xzmui.libs[r].length; d++) l.push(xzmui.path + "libs/" + xzmui.libs[r][d]);
        break
    }
    for (var c = 0; c < l.length; c++) {
        var h = /[^\.]+$/.exec(l[c]) + "";
        switch (h) {
        case "js":
            e(l[c]);
            break;
        case "css":
            a(l[c])
        }
    }
},
function(i, t) {
    var e = function(i) {
        var e = {
            title: "\u5f39\u51fa\u6846",
            className: "",
            content: "\u5185\u5bb9",
            confirmText: "\u786e\u5b9a",
            cancelText: "\u5173\u95ed",
            confirm: null,
            cancel: null
        };
        i = t.extend(e, i);
        var a = (new Date).getTime(),
        n = '<div class="ui-dialog ' + i.className + '" id="dialog-' + a + '"><div class="ui-dialog-main"><div class="ui-dialog-hd">' + i.title + '</div><div class="ui-dialog-bd">' + i.content + '</div><div class="ui-dialog-ft"><button class="ui-dialog-btn ui-dialog-confirm">' + i.confirmText + '</button><button class="ui-dialog-btn ui-dialog-cancel">' + i.cancelText + "</button></div></div></div>";
        return t("body").append(n),
        this.opts = i,
        this.dialog = t("#dialog-" + a),
        this._init()
    };
    e.prototype = {
        _init: function() {
            var e = this;
            return this.opts.confirm || this.opts.cancel ? (this.opts.confirm || (this.dialog.find(".ui-dialog-confirm").remove(), this.opts.confirm = function() {}), this.opts.cancel || (this.dialog.find(".ui-dialog-cancel").remove(), this.opts.cancel = function() {})) : (this.dialog.find(".ui-dialog-cancel").remove(), this.opts.confirm = function() {}),
            this.dialog.find(".ui-dialog-btn").on(i.clickName,
            function(i) {
                t(this).hasClass("ui-dialog-confirm") && t.isFunction(e.opts.confirm) && e.opts.confirm() !== !1 && e.hide(),
                t(this).hasClass("ui-dialog-cancel") && t.isFunction(e.opts.cancel) && e.opts.cancel() !== !1 && e.hide(),
                i.stopPropagation()
            }),
            this
        },
        show: function() {
            return this.dialog.addClass("ui-dialog-show"),
            this
        },
        hide: function() {
            return this.dialog.removeClass("ui-dialog-show"),
            this
        },
        title: function(i) {
            return this.dialog.find(".ui-dialog-hd").html(i),
            this
        },
        content: function(i) {
            return this.dialog.find(".ui-dialog-bd").html(i),
            this
        }
    },
    i.dialog = function(i) {
        return new e(i)
    }
} (xzmui, Zepto),
function(i, t) {
    function e(t, e, n) {
        null == a && (a = i.dialog({
            className: "ui-dialog-tips"
        })),
        a.dialog.attr("id", t),
        e = e ? '<div class="ui-dialog-tips-text">' + e + "</div>": "",
        a.content('<div class="ui-dialog-tips-icon"></div>' + e).show(),
        ("success" == t || "error" == t) && setTimeout(function() {
            a.hide(),
            n && n()
        },
        2e3)
    }
    var a = null;
    i.loading = function(i) {
        e("loading", i)
    },
    i.success = function(i, t) {
        e("success", i, t)
    },
    i.error = function(i, t) {
        e("error", i, t)
    }
} (xzmui, Zepto),
function(i, t) {
    var e = function(i, e) {
        var a = {
            index: 0,
            title: window.document.title,
            data: [],
            mode: "default",
            ready: null
        };
        return this.selector = i,
        this.opts = t.extend(a, e),
        this._init(),
        this._crateSwiper(),
        this._event(),
        this
    };
    e.prototype = {
        _init: function() {
            var i;
            switch (this.opts.mode) {
            case "default":
                i = '<a class="ui-header-link ui-header-back" href="javascript:;"></a><h1 class="ui-header-title">' + this.opts.title + '</h1><div class="ui-header-right"><div class="ui-photoview-num"><span class="ui-photoview-current">1</span> / <span class="ui-photoview-total"></span></div></div>';
                break;
            case "upload":
                i = '<a class="ui-header-link ui-header-back" href="javascript:;"></a><h1 class="ui-header-title"><div class="ui-photoview-num"><span class="ui-photoview-current">1</span> / <span class="ui-photoview-total"></span></div></h1><div class="ui-header-right"><div class="ui-header-link ui-photoview-remove"><i class="iconfont icon-remove"></i></div></div>'
            }
            for (var e = '<div class="ui-photoview"><header class="ui-header">' + i + '</header><section class="ui-photoview-main"><div class="swiper-wrapper"></section></div>',
            a = [], n = 0; n < this.opts.data.length; n++) {
                var s = this.opts.data[n];
                a.push('<div class="swiper-slide" data-src="' + s.src + '"><div class="ui-loading-icon"></div></div>')
            }
            t(".ui-wrapper").append(e),
            this.ui = t(".ui-photoview"),
            this.ui.find(".swiper-wrapper").html(a.join(""))
        },
        _crateSwiper: function() {
            var e = this;
            i.load("swiper",
            function() {
                e.swiper = t(".ui-photoview-main").swiper({
                    onInit: function(i) {
                        e.swiper = i,
                        e.update(),
                        e.swiper.slides.length && e.loadImage(i.activeIndex),
                        e.opts.ready && e.opts.ready(i)
                    },
                    onSlideChangeEnd: function(i) {
                        e.loadImage(i.activeIndex)
                    },
                    onSlideChangeStart: function(i) {
                        e.update()
                    }
                })
            })
        },
        _event: function() {
            var i = this;
            t("body").on("click", i.selector,
            function() {
                var e = 0 || i.opts.index - 1;
                "upload" == i.opts.mode && (e = t(this).index(), console.log(e)),
                -1 == i.opts.index && (e = t(this).attr("index")),
                i.swiper.slideTo(e, 0),
                0 == e && i.loadImage(e),
                i.show()
            }),
            this.ui.find(".ui-header-back").on("click",
            function() {
                i.hide()
            }),
            this.ui.find(".ui-photoview-remove").on("click",
            function() {
                i.swiper.removeSlide(i.swiper.activeIndex),
                t(i.selector).eq(i.swiper.activeIndex).remove(),
                i.update(),
                i.swiper.slides.length ? i.loadImage(i.swiper.activeIndex) : i.hide()
            })
        },
        loadImage: function(i) {
            var e = t(this.swiper.slides[i]),
            a = new Image,
            n = e.data("src");
            "" != n && (a.src = n, e.data("src", ""), a.onload = function() {
                e.html(a)
            })
        },
        show: function() {
            this.ui.removeClass("ui-photoview-hide").addClass("ui-photoview-show")
        },
        hide: function() {
            this.ui.removeClass("ui-photoview-show").addClass("ui-photoview-hide")
        },
        update: function() {
            this.ui.find(".ui-photoview-current").text(this.swiper.activeIndex + 1),
            this.ui.find(".ui-photoview-total").text(this.swiper.slides.length),
            this.swiper.update()
        }
    },
    i.photoView = function(i, t) {
        return new e(i, t)
    }
} (xzmui, Zepto),
$(function() {
    var i = $("body"); !
    function() {
        i.find(".ui-tab-link").on(xzmui.clickName,
        function() {
            $(this).addClass("current").siblings().removeClass("current"),
            $(this).parent().next(".ui-tab-con").find(".ui-tab-item").eq($(this).index()).addClass("show").siblings().removeClass("show")
        }),
        i.find(".ui-tab").on("swipeLeft",
        function() {
            $(this).find(".ui-tab-nav .current").next().trigger("tap")
        }),
        i.find(".ui-tab").on("swipeRight",
        function() {
            $(this).find(".ui-tab-nav .current").prev().trigger("tap")
        })
    } (),
    function() {
        i.on(xzmui.clickName, "[data-href]",
        function() {
            window.location.href = $(this).data("href")
        })
    } (),
    function() {
        var t = i.find(".ui-date"),
        e = i.find(".ui-time"),
        a = i.find(".ui-custom-select"); (t.length || e.length || a.length) && ($(t, e, a.find(".ui-input-text")).focus(function() {
            $(this).blur()
        }), xzmui.load("mobiscroll",
        function() {
            var n = {
                theme: "ios",
                display: "bottom",
                lang: "zh",
                height: 68,
                minWidth: 160
            };
            if (t.length) {
                var s = {
                    dateFormat: "yy-mm-dd"
                };
                s = $.extend(s, n),
                i.find(".ui-date").mobiscroll().date(s)
            }
            if (e.length) {
                var s = {};
                s = $.extend(s, n),
                i.find(".ui-time").mobiscroll().time(s)
            }
            a.length && a.each(function(i) {
                var t = $(this),
                e = [],
                a = [];
                $(this).find("select").each(function(i) {
                    e.push({
                        values: [],
                        keys: []
                    }),
                    $(this).find("option").each(function() {
                        e[i].values.push($(this).text()),
                        e[i].keys.push($(this).val()),
                        $(this).attr("selected") && a.push($(this).val())
                    })
                });
                var s = {
                    wheels: [e],
                    onSelect: function(i, e) {
                        for (var a = [], n = e.getArrayVal(), s = [], o = 0; o < n.length; o++) {
                            var l = $(this).find("select").eq(o).find("option[value='" + n[o] + "']").attr("selected", "selected").text();
                            s.push(l),
                            a.push({
                                value: n[o],
                                text: l
                            })
                        }
                        if ($(this).find(".ui-input-text").val(s.join(" ")), t.data("callback")) {
                            var u = window[t.data("callback")];
                            u(a)
                        }
                    }
                };
                s = $.extend(s, n),
                $(this).mobiscroll().scroller(s),
                $(this).mobiscroll("setValue", a, !0)
            })
        }))
    } (),
    function() {
        var t = i.find(".ui-slider:not(.noinit)");
        t.length && xzmui.load("swiper",
        function() {
            t.each(function() {
                var i = $(this),
                t = {},
                e = i.find(".ui-slider-num");
                t = i.hasClass("ui-slider-title") ? {
                    onInit: function(i) {
                        e.text("1/" + i.slides.length)
                    },
                    onSlideChangeStart: function(i) {
                        e.text(i.activeIndex + 1 + "/" + i.slides.length)
                    }
                }: {
                    pagination: i.find(".swiper-pagination")
                },
                i.swiper(t)
            })
        })
    } (),
    function() {
        var t = i.find(".validform");
        t.length > 0 && xzmui.validform(t)
    } (),
    function() {
        var t = i.find(".ui-page");
        if (t.length > 0) {
            var e = '<div class="ui-page-bg ui-page-close"></div><div class="ui-page-keyboard"><div class="ui-page-topbar"><a href="javascript:;" class="ui-page-confirm ui-page-close">\u786e\u5b9a</a></div><ul class="cc"><li class="ui-page-item ui-page-num" data-key="1"></li><li class="ui-page-item ui-page-num" data-key="2"></li><li class="ui-page-item ui-page-num" data-key="3"></li><li class="ui-page-item ui-page-num" data-key="4"></li><li class="ui-page-item ui-page-num" data-key="5"></li><li class="ui-page-item ui-page-num" data-key="6"></li><li class="ui-page-item ui-page-num" data-key="7"></li><li class="ui-page-item ui-page-num" data-key="8"></li><li class="ui-page-item ui-page-num" data-key="9"></li><li class="ui-page-item ui-page-empty"></li><li class="ui-page-item ui-page-num" data-key="0"></li><li class="ui-page-item ui-page-delete"></li></ul></div>';
            i.append(e);
            var a = [],
            n = i.find(".ui-page-input");
            i.find(".ui-page-info").on(xzmui.clickName,
            function() {
                var t = $(window).height() - ($(this).offset().top - $(window).scrollTop()) - i.find(".ui-page").height() - 20 - 488;
                0 > t && i.find(".ui-wrapper").css({
                    "-webkit-transform": "translateY(" + t + "px)"
                }),
                i.addClass("ui-page-show"),
                i.find(document).bind("touchmove",
                function(i) {
                    i.preventDefault()
                })
            });
            var s = parseInt(n.prev("span").text().split("/")[1]);
            i.find(".ui-page-close").on(xzmui.clickName,
            function() {
                if ($(this).hasClass("ui-page-confirm")) {
                    if ("" === $.trim(n.text())) return void xzmui.tips("\u8bf7\u8f93\u5165\u9875\u6570");
                    if (parseInt(n.text()) > s) return xzmui.tips("\u8f93\u5165\u6709\u8bef\uff0c\u9875\u6570\u8bf7\u4e0d\u8981\u5927\u4e8e" + s),
                    a = [],
                    void n.text("");
                    window.location.href = t.data("url") + n.text()
                }
                a = [],
                i.removeClass("ui-page-show"),
                i.find(".ui-wrapper").css({
                    "-webkit-transform": "translateY(0px)"
                }),
                i.find(document).unbind("touchmove")
            }),
            i.find(".ui-page-num").on(xzmui.clickName,
            function() {
                a.push($(this).data("key")),
                n.text(a.join(""))
            }),
            i.find(".ui-page-delete").on(xzmui.clickName,
            function() {
                a.pop(),
                n.text(a.join(""))
            })
        }
    } ()
}),
function(i, t) {
    i.autocomplete = function(i, e) {
        var a = {
            url: "",
            type: "GET",
            data: {},
            name: "keyword",
            arrows: !0,
            callback: null
        };
        e = t.extend(a, e);
        var n = t(i),
        s = null,
        o = e.arrows ? "ui-list-arrows": "";
        n.after('<div class="ui-list ' + o + '"></div>');
        var l = n.siblings(".ui-list");
        l.on("click", ".ui-list-item",
        function() {
            return "#" === t(this).attr("href") ? (l.removeClass("ui-list-show"), n.val(t(this).find(".ui-list-title").text()), !1) : void 0
        }),
        n.on("input",
        function() {
            return l.addClass("ui-list-show").html('<div class="ui-search-tip ui-search-loading">\u6570\u636e\u52a0\u8f7d\u4e2d...</div>'),
            clearTimeout(s),
            "" == t.trim(n.val()) ? (l.removeClass("ui-list-show"), !1) : void(s = setTimeout(function() {
                var i = [];
                e.data[e.name] = n.val(),
                t.ajax({
                    type: e.type,
                    url: e.url,
                    data: e.data,
                    dataType: "json",
                    success: function(t, a, n) {
                        if (e.callback) e.callback(l, t);
                        else {
                            if (t.length > 0) for (var s = 0; s < t.length; s++) {
                                var o = t[s];
                                i.push('<a href="' + o.url + '" class="ui-list-item"><div class="ui-list-title">' + o.name + "</div></a>")
                            } else i.push('<div class="ui-search-tip ui-search-empty">\u6682\u65e0\u641c\u7d22\u7ed3\u679c</div>');
                            l.html(i.join(""))
                        }
                    }
                })
            },
            500))
        })
    }
} (xzmui, Zepto),
function(i, t) {
    var e = null;
    i.tips = function(i) {
        function a() {
            e = setTimeout(function() {
                o.removeClass("ui-tips-show")
            },
            2e3)
        }
        var n = '<div class="ui-tips"><span></span></div>',
        s = t(".ui-tips span"),
        o = t("body");
        0 === s.length && (t("body").append(n), s = t(".ui-tips span")),
        o.hasClass("ui-tips-show") && clearTimeout(e),
        s.text(i),
        o.hasClass("ui-tips-show") ? clearTimeout(e) : o.addClass("ui-tips-show"),
        a()
    }
} (xzmui, Zepto),
function(i, t) {
    i.upload = function(e, a) {
        var n = {
            limit: 5,
            name: "img[]"
        };
        a = t.extend(n, a);
        var e = t(e),
        s = ".ui-upload-item",
        o = i.photoView(s, {
            mode: "upload",
            ready: function(i) {
                t(s).each(function() {
                    i.appendSlide('<div class="swiper-slide" data-src="' + t(this).find("img").attr("src") + '"><div class="ui-loading-icon"></div></div>'),
                    o.update()
                })
            }
        });
        i.load("upload2",
        function() {
            e.on("change",
            function() {
                var n = t(s),
                l = n.length;
                if (n.length + this.files.length > a.limit && a.limit > 0) i.tips("\u6700\u591a\u4e0a\u4f20" + a.limit + "\u5f20\u56fe\u7247");
                else for (var u = 0; u < this.files.length; u++) e.parent().before('<div class="ui-upload-block ui-upload-item ui-loading"><div class="ui-loading-icon"></div></div>'),
                function(i) {
                    lrz(i, {
                        width: 800,
                        done: function(i) {
                            var e = new Image;
                            e.src = i.base64,
                            e.onload = function() {
                                t(s).eq(l).removeClass("ui-loading").html(e).append('<input type="hidden" name="' + a.name + '" value="' + i.base64 + '">'),
                                o.swiper.appendSlide('<div class="swiper-slide" data-src="' + i.base64 + '"><div class="ui-loading-icon"></div></div>'),
                                o.update(),
                                l++
                            }
                        }
                    })
                } (this.files[u])
            })
        })
    }
} (xzmui, Zepto),
function(i, t) {
    i.validform = function(e, a) {
        function n(i) {
            var e = "";
            switch (console.log(i), i[0].tagName) {
            case "INPUT":
            case "TEXTAREA":
                var a = i.attr("type");
                if ("radio" == a) e = u.find("input[name='" + i.attr("name") + "']:checked").val();
                else if ("checkbox" == a) {
                    var n = [];
                    u.find("input[name='" + i.attr("name") + "']:checked").each(function() {
                        n.push(t(this).val())
                    }),
                    e = n.join(",")
                } else e = i.val();
                break;
            case "SELECT":
                e = i[0].options[i[0].selectedIndex].value
            }
            return t.trim(e)
        }
        function s(i, t) {
            var e = i.data(t);
            return e || ("INPUT" == i[0].tagName && i.hasClass("ui-input-text") || "TEXTAREA" == i[0].tagName) && (e = "null" == t ? "\u8bf7\u8f93\u5165\u4fe1\u606f": "\u4fe1\u606f\u683c\u5f0f\u9519\u8bef"),
            e || (e = "\u8bf7\u9009\u62e9\u4fe1\u606f"),
            e
        }
        function o(i) {
            if ("/" == i.charAt(0) && "/" == i.charAt(i.length - 1)) return new RegExp(i.substring(1, i.length - 1));
            for (var t in c) if (i == t) return c[t];
            return null
        }
        var l = {
            callback: null,
            beforeCheck: null,
            beforeSubmit: null
        },
        u = t(e);
        a = t.extend(l, a);
        var c = {
            email: /\w+((-w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+/,
            phone: /0?(13|14|15|17|18)[0-9]{9}/,
            number: /^[1-9]\d*$/,
            currency: /^\d+(?:\.\d{0,2})?$/
        },
        r = {};
        return t.isFunction(a.beforeCheck) && !a.beforeCheck(u) ? !1 : void u.on("submit",
        function() {
            var e;
            return u.find("[data-type]").each(function() {
                if (t(this).is(":visible")) {
                    e = !0;
                    var l = t.trim(t(this).data("type"));
                    if ("" !== l) {
                        var c, d = n(t(this));
                        if ("" === d) return t(this).focus(),
                        e = !1,
                        c = s(t(this), "null"),
                        t.isFunction(a.callback) ? a.callback(t(this), c, u) : i.tips(c),
                        !1;
                        var h = o(l);
                        if (h && !h.test(d)) return t(this).focus(),
                        e = !1,
                        c = s(t(this), "error"),
                        t.isFunction(a.callback) ? a.callback(t(this), c, u) : i.tips(c),
                        !1;
                        var p = t(this).attr("name");
                        p && (r[p] = d)
                    }
                }
            }),
            t.isFunction(a.beforeSubmit) ? e ? a.beforeSubmit(u, r) : !1 : e
        })
    }
} (xzmui, Zepto);