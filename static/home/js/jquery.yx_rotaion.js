(function($){   
    $.fn.extend({     
         yx_rotaion: function(options) {   
		    //默认参数
            var defaults = {
			     /**轮换间隔时间，单位毫秒*/
                 during:3000,
				 /**是否显示左右按钮*/
                 btn:true,
				 /**是否显示焦点按钮*/
                 focus:true,
				 /**是否显示标题*/
                 title:true,
				 /**是否自动播放*/
                 auto:true				 
            }        
            var options = $.extend(defaults, options);   
            return this.each(function(){
			    var o = options;   
				var curr_index = 0;
                var _this = $(this);				
                var $li = _this.find("li");
                var li_count = $li.length;
				_this.css({position:'relative',overflow:'hidden',width:$li.find("a").width(),height:$li.find("a").height()});
				_this.find("li").css({position:'absolute',left:0,top:0}).hide();
			    $li.first().show();
				/**左右按钮**/
				if(o.btn){ 
					var btn_html='<a class="o_btn big_prev icon"></a><a class="o_btn big_next icon"></a>';
					_this.after(btn_html);
				}

				/**焦点按钮**/
                if(o.focus){ 
					var focus_html='<ol id="controls">';
					// 输出焦点按钮
				   for(i=0;i< li_count;i++){
					 focus_html += '<li ' + ( i== 0 ? 'class="current"' : '' )+ '><a href=""></a></li>';
				   }
				   focus_html += '</ol>';
				   _this.after(focus_html);
				}

                /**标题**/
                if(o.title){
                    var title_html=' <div id="controlsdesc"><a href="' + $li.eq(0).find("a").attr("href") + '">' + $li.eq(0).find("img").attr("alt")+ '</a></div>';
                    _this.after(title_html);
                }

				var $btn = $(".o_btn"),
                    $title = $("#controlsdesc").find("a"),
                    $f = $("#controls").children("li");
				var t;

				var tf = function(){
					t = setInterval(function(){
						 var next = curr_index + 1;						
						 if(next >= li_count){
							next = 0;
						 }

						 $f.eq(curr_index).removeClass("current");
						 $f.eq(next).addClass("current");
						 $li.eq(curr_index).fadeOut(300);
						 $li.eq(next).fadeIn(300);
						 $title.text($li.eq(next).find("img").attr("alt"));
                         $title.attr("href",$li.eq(next).find("a").attr("href"));
						 curr_index = next;

					},o.during);
					return t;
				}
				if(o.btn && o.auto){
					tf();
				}else if(o.focus && o.auto){
					tf();
				}
			   //鼠标覆盖元素，清除计时器
               $btn.add($li).add($f).hover(function(){
                if(t) clearInterval(t);
               },function(){
                if(o.auto) 
					tf();
               });
			   
			   //鼠标覆盖焦点按钮效果
               $f.bind("mouseover",function(){
				 curr_index = $(this).index();
				 $f.not(curr_index).removeClass("current");
				 $(this).addClass("current");
				 $li.not(curr_index).fadeOut(300);
				 $li.eq(curr_index).fadeIn(300);
	             $title.text($li.eq(curr_index).find("img").attr("alt"));
				 $title.attr("href",$li.eq(curr_index).find("a").attr("href"));
               });
			   //鼠标点击左右按钮效果
               $btn.bind("click",function(){
				 //curr_index = $(this).index();
				 if($(this).hasClass("big_prev")){
					curr_index = curr_index - 1;
					if(curr_index < 0){
						curr_index = li_count - 1;
					}
				 } else if($(this).hasClass("big_next")){
					curr_index = curr_index + 1;
					if(curr_index >= li_count){
						curr_index = 0;
					}
				 }

	             $f.removeClass("current");
				 $f.eq(curr_index).addClass("current");
				 $li.fadeOut(300);
				 $li.eq(curr_index).fadeIn(300);
	             $title.text($li.eq(curr_index).find("img").attr("alt"));
				 $title.attr("href",$li.eq(curr_index).find("a").attr("href"));
               });

                $btn.bind("mouseover",function(){
                    $btn.css({"display" : "block"});
                });
                $btn.bind("mouseleave",function(){
                    $btn.css({"display" : "none"});
                });
                $li.bind("mouseover",function(){
                    $btn.css({"display" : "block"});
                });
                $li.bind("mouseleave",function(){
                    $btn.css({"display" : "none"});
                });
 
            });   
        }   
    });   
       
})(jQuery);
