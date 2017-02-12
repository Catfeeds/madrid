/**
 * @namespace
 */
var xzmui = xzmui || {};

/**
 * 单击方式，由于开始使用tap导致了很多问题，现在改用click
 * @type {string}
 */
xzmui.clickName = "click";

/**
 * xzmui项目路径配置
 * @type {string}
 */
xzmui.path = basedir;

/**
 * xzmui依赖的插件配置，可以使用定义的名字调用
 * @type {Object}
 */
xzmui.libs = {
	swiper: [
		'swiper/swiper.min.js',
		'swiper/swiper.min.css'
	],
	mobiscroll: [
		'mobiscroll/mobiscroll.min.js',
		'mobiscroll/mobiscroll.min.css'
	],
	upload: [
		'upload/lrz.mobile.min.js'
	],
	upload2: [
		'upload2/lrz.mobile.min.js'
	],
	iscroll: [
		'iscroll/iscroll-zoom.js'
	]
}


/**
 * 异步加载css，js
 * @param {(string｜Array.<string>)} 需要加载的文件，单个文件、配置的插件可用字符串，多个文件使用数组
 * @param {Function} callback 加载完成后执行方法
 */
xzmui.load = function(files, callback){
	var head = document.getElementsByTagName("head")[0];
	var list = [];
	var complete = 0;

	if(!$.isArray(files)){
		files = [files];
	}

	// 生成需要加载文件的列表
	for(var i = 0; i < files.length; i++){
		if(files[i].indexOf(".") != -1){
			list.push(files[i]);
		}else{
			for(var item in xzmui.libs){
				if(item == files[i]){
					for(var j = 0; j < xzmui.libs[item].length; j++){
						list.push(xzmui.path + "" + xzmui.libs[item][j]);
					}
					break;
				}
			}
		}
	}

	for(var i = 0; i < list.length; i++){
		var type = /[^\.]+$/.exec(list[i]) + "";

		switch(type){
			case "js":
				loadJs(list[i]);
			break;
			case "css":
				loadCss(list[i])
			break;
		}
	}

	// 加载js文件
	function loadJs(file){
		if(loaded("js", file)){
			var script = document.createElement("script");
			script.type = "text/javascript";
			script.src = file;
			head.appendChild(script);

			script.onload = function(){
				success();
			}
		}else{
			success();
		}
	}

	// 加载css文件
	function loadCss(file){
		if(loaded("css", file)){
			var link = document.createElement("link");
			link.rel = "stylesheet";
			link.href = file;
			head.appendChild(link);

			link.onload = function(){
				success();
			}
		}else{
			success();
		}
	}

	// 检查文件是否已经加载
	function loaded(type, file){
		var tag = "script";
		var attr = "src";

		if(type === "css"){
			tag = "link";
			attr = "href";
		}

		var tags = document.getElementsByTagName(tag);

		for(var i = 0; i < tags.length; i++){
			if(tags[i].getAttribute(attr) == file){
				return false;
			}
		}
		return true;
	}

	function success(){
		complete ++;

		if(complete == list.length){
			callback();
		}
	}
}
/**
 * 弹框
 * @param {string} opts.title 标题
 * @param {string} opts.className 弹框最外层的class，一般用于修改弹框样式
 * @param {string} opts.content 内容
 * @param {string} opts.confirmText 确定按钮文字
 * @param {string} opts.cancelText 取消按钮文字
 * @param {Function} opts.confirm 确定回调  确定和取消回调都没有配置时，默认显示确定按钮
 * @param {Function} opts.cancel  取消回调  有配置的话显示与配置对应的按钮
 * @return {Object} 返回dialog对象,可链式调用 dialog.title("xxx").content("xxx").show();
 */
;(function(xzmui, $){
	var Dialog = function(opts){
		var defaults = {
			title: "弹出框",
			className: "",
			content: "内容",
			confirmText: "确定",
			cancelText: "关闭",
			confirm: null,
			cancel: null
		}
		opts = $.extend(defaults, opts);
		var id = new Date().getTime();
		var tpl = ''
			+'<div class="ui-dialog '+ opts.className +'" id="dialog-'+ id +'">'
			+	'<div class="ui-dialog-main">'
			+		'<div class="ui-dialog-hd">'+ opts.title +'</div>'
			+		'<div class="ui-dialog-bd">'+ opts.content +'</div>'
			+		'<div class="ui-dialog-ft">'
			+			'<button class="ui-dialog-btn ui-dialog-confirm">'+ opts.confirmText +'</button>'
			+			'<button class="ui-dialog-btn ui-dialog-cancel">'+ opts.cancelText +'</button>'
			+		'</div>'
			+	'</div>'
			+'</div>';
		$("body").append(tpl);
		this.opts = opts;
		this.dialog = $("#dialog-" + id);
		return this._init();
	}

	Dialog.prototype = {
		_init: function(){
			var _this = this;

			if(!this.opts.confirm && !this.opts.cancel){
				this.dialog.find(".ui-dialog-cancel").remove();
				this.opts.confirm = function(){};
			}else{
				if(!this.opts.confirm){
					this.dialog.find(".ui-dialog-confirm").remove();
					this.opts.confirm = function(){};
				}
				if(!this.opts.cancel){
					this.dialog.find(".ui-dialog-cancel").remove();
					this.opts.cancel = function(){};
				}
			}

			this.dialog.find(".ui-dialog-btn").on(xzmui.clickName, function(e){
				if($(this).hasClass("ui-dialog-confirm")){
					if($.isFunction(_this.opts.confirm) && _this.opts.confirm() !== false){
						_this.hide();
					}
				}
				if($(this).hasClass("ui-dialog-cancel")){
					if($.isFunction(_this.opts.cancel) && _this.opts.cancel() !== false){
						_this.hide();
					}
				}
				e.stopPropagation();
			});
			return this;
		},
		// 打开弹窗
		show: function(){
			this.dialog.addClass("ui-dialog-show");
			return this;
		},
		// 关闭弹窗
		hide: function(){
			this.dialog.removeClass("ui-dialog-show");
			return this;
		},
		// 设置标题
		title: function(title){
			this.dialog.find(".ui-dialog-hd").html(title);
			return this;
		},
		// 设置内容
		content: function(content){
			this.dialog.find(".ui-dialog-bd").html(content);
			return this;
		}
	}

	// 添加到xzmui
	xzmui.dialog = function(opts){
		return new Dialog(opts);
	}
})(xzmui, jQuery);

;(function(xzmui, $){
	var dialog = null;

	function dialogTips(type, msg, callback){
		if(dialog == null){
			dialog = xzmui.dialog({className:'ui-dialog-tips'});
		}

		dialog.dialog.attr("id", type);

		if(msg){
			msg = '<div class="ui-dialog-tips-text">'+ msg +'</div>';
		}else{
			msg = '';
		}

		dialog.content('<div class="ui-dialog-tips-icon"></div>' + msg).show();

		if(type == 'success' || type == 'error'){
			setTimeout(function(){
				dialog.hide();
				if(callback){
					callback();
				}
			}, 2000);
		}
	}

	xzmui.loading = function(msg){
		dialogTips('loading', msg);
	}

	xzmui.success = function(msg, callback){
		dialogTips('success', msg, callback);
	}

	xzmui.error = function(msg, callback){
		dialogTips('error', msg, callback);
	}
})(xzmui, jQuery);
/**
 * 图片浏览
 * @param {string} selector 触发选择器
 * @param {number} opts.index 默认显示的位置
 * @param {string} opts.title 图片浏览器标题
 * @param {string} opts.mode 模式，其他扩展应用
 */
;(function(xzmui, $){
	var PhotoSwipe = function(selector, opts){
		var defaults = {
			index: 0,
			title: window.document.title,
			data: [],
			mode: "default",
			ready: null
		}
		this.selector = selector;
		this.opts = $.extend(defaults, opts);
		this._init();
		this._crateSwiper();
		this._event();

		return this;
	}

	PhotoSwipe.prototype = {
		_init: function(){
			var header;
			switch(this.opts.mode){
				case "default":
					header = ''
					+'<a class="ui-header-link ui-header-back" href="javascript:;"></a>'
					+'<h1 class="ui-header-title">'+ this.opts.title +'</h1>'
					+'<div class="ui-header-right"><div class="ui-photoview-num"><span class="ui-photoview-current">1</span> / <span class="ui-photoview-total"></span></div></div>';
				break;
				case "upload":
					header = ''
					+'<a class="ui-header-link ui-header-back" href="javascript:;"></a>'
					+'<h1 class="ui-header-title"><div class="ui-photoview-num"><span class="ui-photoview-current">1</span> / <span class="ui-photoview-total"></span></div></h1>'
					+'<div class="ui-header-right"><div class="ui-header-link ui-photoview-remove"><i class="iconfont icon-remove"></i></div></div>';
				break;
			}

			var tpl = ''
			+'<div class="ui-photoview">'
			+   '<header class="ui-header">'
			+		header
			+	'</header>'
			+   '<section class="ui-photoview-main"><div class="swiper-wrapper"></section>'
			+'</div>';

			var photoViewListHtml = [];

			for(var i = 0; i < this.opts.data.length; i++){
				var img = this.opts.data[i];
				photoViewListHtml.push('<div class="swiper-slide" data-src="'+ img.src +'"><div class="ui-loading-icon"></div></div>');
			}

			$(".ui-wrapper").append(tpl);

			this.ui = $(".ui-photoview");
			this.ui.find(".swiper-wrapper").html(photoViewListHtml.join(""));
		},
		_crateSwiper: function(){
			var me = this;
			xzmui.load('swiper', function(){
				me.swiper = $(".ui-photoview-main").swiper({
					onInit: function(swiper){
						me.swiper = swiper;
						me.update();
						if(me.swiper.slides.length){
							me.loadImage(swiper.activeIndex);
						}
						if(me.opts.ready){
							me.opts.ready(swiper);
						}
					},
					onSlideChangeEnd: function(swiper){
						me.loadImage(swiper.activeIndex);
					},
					onSlideChangeStart: function(swiper){
						me.update();
					}
				});
			});
		},
		_event: function(){
			var me = this;

			$("body").on("click", me.selector, function(){
				var index = 0 || (me.opts.index - 1);

				if(me.opts.mode == "upload"){
					index = $(this).index();
					console.log(index);
				}

				if(me.opts.index == -1){
					index = $(this).attr('index');
				}

				me.swiper.slideTo(index, 0);

				if(index == 0){
					me.loadImage(index);
				}

				me.show();

			});

			this.ui.find(".ui-header-back").on("click", function(){
				me.hide();
			});

			this.ui.find(".ui-photoview-remove").on("click", function(){
				me.swiper.removeSlide(me.swiper.activeIndex);
				$(me.selector).eq(me.swiper.activeIndex).remove();
				me.update();
				if(me.swiper.slides.length){
					me.loadImage(me.swiper.activeIndex);
				}else{
					me.hide();
				}
			});

		},
		loadImage: function(i){
			var me = this;
			var slide = $(this.swiper.slides[i]);
			var img = new Image();
			var src = slide.data("src");

			if(src == ""){
				return;
			}

			img.src = src;
			slide.data("src", "");

			img.onload = function(){
				slide.html(img);
			}
		},
		show: function(){
			this.ui.removeClass("ui-photoview-hide").addClass("ui-photoview-show");
		},
		hide: function(){
			this.ui.removeClass("ui-photoview-show").addClass("ui-photoview-hide");
		},
		update: function(){
			this.ui.find(".ui-photoview-current").text(this.swiper.activeIndex + 1);
			this.ui.find(".ui-photoview-total").text(this.swiper.slides.length);
			this.swiper.update();
		}
	}

	xzmui.photoView = function(selector, opts){
		return new PhotoSwipe(selector, opts);
	}
})(xzmui, jQuery);

$(function(){
	var body = $("body");
	// 选项卡
	(function(){
		body.find(".ui-tab-link").on(xzmui.clickName, function(){
			$(this).addClass("current").siblings().removeClass("current");
			$(this).parent().next(".ui-tab-con").find(".ui-tab-item").eq($(this).index()).addClass("show").siblings().removeClass("show");
		});

		body.find(".ui-tab").on("swipeLeft", function(){
			$(this).find(".ui-tab-nav .current").next().trigger("tap");
		});

		body.find(".ui-tab").on("swipeRight", function(){
			$(this).find(".ui-tab-nav .current").prev().trigger("tap");
		});
	})();

	// 链接跳转
	(function(){
		body.on(xzmui.clickName, "[data-href]", function(){
			window.location.href = $(this).data("href");
		});
	})();

	// 日期时间
	(function(){
		var date = body.find(".ui-date");
		var time = body.find(".ui-time");
		var select = body.find(".ui-custom-select");
		if(date.length || time.length || select.length){
			$(date, time, select.find(".ui-input-text")).focus(function(){
				$(this).blur();
			});

			xzmui.load('mobiscroll', function(){
				var defaults = {
					theme: "ios",
					display: "bottom",
					lang: "zh",
					height: 34,
					minWidth: 160
				}

				if(date.length){
					var options = {dateFormat: "yy-mm-dd"}
					options = $.extend(options, defaults);
					body.find(".ui-date").mobiscroll().date(options);
				}

				if(time.length){
					var options = {}
					options = $.extend(options, defaults);
					body.find(".ui-time").mobiscroll().time(options);
				}

				if(select.length){
					select.each(function(n){
						var _this = $(this);
						var data = [];
						var selected = [];
						$(this).find("select").each(function(i){
							data.push({values:[], keys:[]});
							$(this).find("option").each(function(){
								data[i].values.push($(this).text());
								data[i].keys.push($(this).val());

								if($(this).attr("selected")){
									selected.push($(this).val());
								}
							});
						});

						var options = {
							wheels: [data],
							onSelect: function(v, o){
								var arrs = [];
								var vals = o.getArrayVal();
								var txts = [];
								for(var i = 0; i < vals.length; i++){
									var txt = $(this).find("select").eq(i).find("option[value='"+ vals[i] +"']").attr("selected", "selected").text();
									txts.push(txt);
									arrs.push({value: vals[i], text: txt});
								}
								$(this).find(".ui-input-text").val(txts.join(" "));
								$(this).find(".ui-custom-select-label").text(txts.join(" "));

								if(_this.data("callback")){
									var callback = window[_this.data("callback")];
									callback(arrs,_this[0]);
								}
							}
						}

						options = $.extend(options, defaults);
						$(this).mobiscroll().scroller(options);
						$(this).mobiscroll('setValue', selected, true);
					});
				}
			});
		}
	})();

	// 焦点图
	(function(){
		var slider = body.find(".ui-slider:not(.noinit)");
		if(slider.length){
			xzmui.load('swiper', function(){
				slider.each(function(){
					var me = $(this);
					var opts = {};
					var num = me.find(".ui-slider-num");

					if(me.hasClass("ui-slider-title")){
						opts = {
							onInit: function(swiper){
								num.text(1 + "/" + swiper.slides.length);
							},
							onSlideChangeStart: function(swiper){
								num.text((swiper.activeIndex + 1) + "/" + swiper.slides.length);
							}
						}
					}else{
						opts = {pagination: me.find('.swiper-pagination')}
					}

					me.swiper(opts);
				});
			});
		}
	})();

	// 表单验证调用
	(function(){
		var vaildform = body.find(".validform");

		if(vaildform.length > 0){
			xzmui.validform(vaildform);
		}
	})();

	// 分页
	(function(){
		var page = body.find(".ui-page");

		if(page.length > 0){
			var tpl = ''
				+'<div class="ui-page-bg ui-page-close"></div>'
				+'<div class="ui-page-keyboard">'
				+	'<div class="ui-page-topbar">'
				+		'<a href="javascript:;" class="ui-page-confirm ui-page-close">\u786e\u5b9a</a>'
				+	'</div>'
				+	'<ul class="cc">'
				+		'<li class="ui-page-item ui-page-num" data-key="1"></li>'
				+		'<li class="ui-page-item ui-page-num" data-key="2"></li>'
				+		'<li class="ui-page-item ui-page-num" data-key="3"></li>'
				+		'<li class="ui-page-item ui-page-num" data-key="4"></li>'
				+		'<li class="ui-page-item ui-page-num" data-key="5"></li>'
				+		'<li class="ui-page-item ui-page-num" data-key="6"></li>'
				+		'<li class="ui-page-item ui-page-num" data-key="7"></li>'
				+		'<li class="ui-page-item ui-page-num" data-key="8"></li>'
				+		'<li class="ui-page-item ui-page-num" data-key="9"></li>'
				+		'<li class="ui-page-item ui-page-empty"></li>'
				+		'<li class="ui-page-item ui-page-num" data-key="0"></li>'
				+		'<li class="ui-page-item ui-page-delete"></li>'
				+	'</ul>'
				+'</div>';

			body.append(tpl);

			var nums = [], input = body.find(".ui-page-input");

			body.find(".ui-page-info").on(xzmui.clickName, function(){
				var y = $(window).height() - ($(this).offset().top - $(window).scrollTop()) - body.find(".ui-page").height() - 20 -488;

				if(y < 0){
					body.find(".ui-wrapper").css({"-webkit-transform":"translateY("+ y +"px)"});
				}

				body.addClass("ui-page-show");

				body.find(document).bind("touchmove", function(e){
					e.preventDefault();
				});
			});

			var max = parseInt(input.prev("span").text().split("/")[1]);

			body.find(".ui-page-close").on(xzmui.clickName, function(){
				if($(this).hasClass("ui-page-confirm")){
					if($.trim(input.text()) === ""){
						xzmui.tips("请输入页数");
						return;
					}else if(parseInt(input.text()) > max){
						xzmui.tips("输入有误，页数请不要大于" + max);
						nums = [];
						input.text("");
						return;
					}else{
						window.location.href = page.data("url") + input.text();
					}
				}
				nums = [];
				body.removeClass("ui-page-show");
				body.find(".ui-wrapper").css({"-webkit-transform":"translateY(0px)"});
				body.find(document).unbind("touchmove");
			});

			body.find(".ui-page-num").on(xzmui.clickName, function(){
				nums.push($(this).data("key"));
				input.text(nums.join(""));
			});

			body.find(".ui-page-delete").on(xzmui.clickName, function(){
				nums.pop();
				input.text(nums.join(""));
			});
		}
	})();
});

/**
 * 搜索提示，分为两种，一种匹配到的结果带链接的，点击直接跳转，另外一种链接用"#"号,点击后设置内容到输入框。
 * @param {string} selector 输入框选择器
 * @param {string} opts.url 请求地址
 * @param {string} opts.type 请求类型
 * @param {string} opts.name 请求字段名
 * @param {string} opts.data 请求数据
 * @param {string} opts.arrows 显示的数据是否带箭头
 * @param {function(list, data)} opts.callback 数据结构比较特殊的，使用回调拼好结构后放到列表中
 */
;(function(xzmui, $){
	xzmui.autocomplete = function(selector, opts){
		var defaults = {
			url: "",
			type: "GET",
			data: {},
			name: "keyword",
			arrows: true,
			callback: null
		}
		opts = $.extend(defaults, opts);

		var input = $(selector);
		var timer = null;
		var className = opts.arrows ? "ui-list-arrows" : "";

		input.after('<div class="ui-list '+ className +'"></div>');

		var list = input.siblings(".ui-list");

		list.on("click", ".ui-list-item", function(){
			if($(this).attr("href") === "#"){
				list.removeClass("ui-list-show");
				input.val($(this).find(".ui-list-title").text());
				return false;
			}
		});

		input.on("input", function(){
			list.addClass("ui-list-show").html('<div class="ui-search-tip ui-search-loading">数据加载中...</div>');
			clearTimeout(timer);
			if($.trim(input.val()) == ""){
				list.removeClass("ui-list-show");
				return false;
			}

			timer = setTimeout(function(){
				var html = [];

				opts.data[opts.name] = input.val();

				$.ajax({
					type: opts.type,
					url: opts.url,
					data: opts.data,
					dataType: "json",
					success: function(data, status, xhr){
						if(opts.callback){
							opts.callback(list, data);
						}else{
							if(data.length > 0){
								for(var i = 0; i < data.length; i++){
									var r = data[i];
									html.push('<a href="'+ r.url +'" class="ui-list-item"><div class="ui-list-title">'+ r.name +'</div></a>');
								}
							}else{
								html.push('<div class="ui-search-tip ui-search-empty">暂无搜索结果</div>');
							}
							list.html(html.join(""));
						}
					}
				});

			},500)
		});
	}
})(xzmui, jQuery);

/**
 * 消息提示
 * @param {string} msg 提示内容
 */
;(function(xzmui, $){
	var timer = null;

	xzmui.tips = function(msg){
		var tpl = '<div class="ui-tips"><span></span></div>';
		var tip = $(".ui-tips span");
		var body = $("body");

		if(tip.length === 0){
			$("body").append(tpl);
			tip = $(".ui-tips span");
		}

		if(body.hasClass("ui-tips-show")){
			clearTimeout(timer);
		}

		tip.text(msg);

		if(body.hasClass("ui-tips-show")){
			clearTimeout(timer);
		}else{
			body.addClass("ui-tips-show");
		}

		autoHide();

		function autoHide(){
			timer = setTimeout(function(){
				body.removeClass("ui-tips-show");
			}, 2000);
		}
	}
})(xzmui, jQuery);

/**
 * 上传图片
 * @param {string} selector file选择器
 * @param {string} opts.limit 限制上传数量，0为不限制数量
 * @param {string} opts.name 隐藏域name名
 */
;(function(xzmui, $){
	xzmui.upload = function(selector, opts){
		var defaults = {
			limit: 5,
			name: "img[]"
		}
		opts = $.extend(defaults, opts);

		var selector = $(selector);
		var itemClass = '.ui-upload-item';

		var pv = xzmui.photoView(itemClass, {
			mode: "upload",
			ready: function(swiper){
				$(itemClass).each(function(){
					swiper.appendSlide('<div class="swiper-slide" data-src="'+ $(this).find("img").attr("src") +'"><div class="ui-loading-icon"></div></div>');
					pv.update();
				});
			}
		});

		xzmui.load('upload2', function(){
			selector.on("change", function(){
				var item = $(itemClass);
				var n = item.length;
				if((item.length + this.files.length > opts.limit) && opts.limit > 0){
					xzmui.tips("最多上传"+ opts.limit +"张图片");
				}else{
					for(var i = 0; i < this.files.length; i++){
						selector.parent().before('<div class="ui-upload-block ui-upload-item ui-loading"><div class="ui-loading-icon"></div></div>');
						/*
						lrz(this.files[i], {width:800}, function(result){
							var img = new Image();
							img.src = result.base64;

							img.onload = function(){
								$(itemClass).eq(n).removeClass("ui-loading").html(img).append('<input type="hidden" name="'+ opts.name +'" value="'+ result.base64 +'">');
								pv.swiper.appendSlide('<div class="swiper-slide" data-src="'+ result.base64 +'"><div class="ui-loading-icon"></div></div>');
								pv.update();
								n ++;
							}
						});
						*/
						(function(file){
							lrz(file, {
								width:800,
								done: function(result){
									var img = new Image();
									img.src = result.base64;

									img.onload = function(){
										$(itemClass).eq(n).removeClass("ui-loading").html(img).append('<input type="hidden" name="'+ opts.name +'" value="'+ result.base64 +'">');
										pv.swiper.appendSlide('<div class="swiper-slide" data-src="'+ result.base64 +'"><div class="ui-loading-icon"></div></div>');
										pv.update();
										n ++;
									}
								}
							});
						})(this.files[i]);
					}
				}
			});
		});
	}
})(xzmui, jQuery);

/**
 * 表单验证
 * @param {function(obj, msg, form)} opts.callback 默认错误信息用xzmui.tips提示，在这个方法里可以实现用其他方式显示错误信息
 * @param {function(form)} opts.beforeCheck 验证之前执行的方法
 * @param {function(form, params)} opts.beforeSubmit 全部验证成功之后执行的方法，返回false表单不提交
 */
;(function(xzmui, $){
	xzmui.validform = function(selector, opts){
		var defaults = {
			callback: null,
			beforeCheck: null,
			beforeSubmit: null
		}

		var form = $(selector);
		opts = $.extend(defaults, opts);

		var regex = {
			email: /\w+((-w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+/,
			phone: /0?(13|14|15|17|18)[0-9]{9}/,
			number: /^[1-9]\d*$/,
            currency: /^\d+(?:\.\d{0,2})?$/
		}

		var params = {};

		if($.isFunction(opts.beforeCheck) && !opts.beforeCheck(form)){
			return false;
		}

		form.on("submit", function(){
			var flag;

			form.find("[data-type]").each(function(){
				if($(this).is(":visible")){
					flag = true;
					var type = $.trim($(this).data("type"));
					if(type !== ""){
						var val = getValue($(this)), msg;

						if(val === ""){
							$(this).focus();
							flag = false;
							msg = getMsg($(this), "null");

							if($.isFunction(opts.callback)){
								opts.callback($(this), msg, form);
							}else{
								xzmui.tips(msg);
							}
							return false;
						}else{
							var reg = getRegex(type);
							if(reg && !reg.test(val)){
								$(this).focus();
								flag = false;
								msg = getMsg($(this), "error");

								if($.isFunction(opts.callback)){
									opts.callback($(this), msg, form);
								}else{
									xzmui.tips(msg);
								}
								return false;
							}
						}

						var name = $(this).attr("name");
						if(name){
							params[name] = val;
						}

					}
				}
			});

			if($.isFunction(opts.beforeSubmit)){
				if(flag){
					return opts.beforeSubmit(form, params);
				}
				return false;
			}else{
				return flag;
			}
		});

		// 获取值
		function getValue(obj){
			var val = "";
			console.log(obj);
			switch(obj[0].tagName){
				case "INPUT":
				case "TEXTAREA":
					var type = obj.attr("type");
					if(type == "radio"){
						val = form.find("input[name='"+ obj.attr("name") +"']:checked").val();
					}else if(type == "checkbox"){
						var valarr = [];
						form.find("input[name='"+ obj.attr("name") +"']:checked").each(function(){
							valarr.push($(this).val());
						});
						val = valarr.join(",");
					}else{
						val = obj.val();
					}
				break;
				case "SELECT":
					val = obj[0].options[obj[0].selectedIndex].value;
				break;
			}
			return $.trim(val);
		}

		// 获取提示信息
		function getMsg(obj, type){
			var msg = obj.data(type);

			if(!msg){
				if((obj[0].tagName == "INPUT" && obj.hasClass("ui-input-text")) || obj[0].tagName == "TEXTAREA"){
					msg = type == "null" ? "请输入信息" : "信息格式错误";
				}
			}

			if(!msg){
				msg = "请选择信息";
			}

			return msg;
		}

		// 是否有这个类型
		function getRegex(type){

			if(type.charAt(0) == "/" && type.charAt(type.length - 1) == "/"){
				return new RegExp(type.substring(1, type.length - 1));
			}

			for(var item in regex){
				if(type == item){
					return regex[item];
				}
			}

			return null;
		}
	}
})(xzmui, jQuery);
