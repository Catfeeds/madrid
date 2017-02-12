(function(window,$) {

    (function() {
        //重构浏览器默认select统一样式
        //onOpen 点击打开Select
        //onClose 关闭Select
        //onSelect 选择

        function U_Select(option) {
            return new U_Select.prototype._init(option);
        }

        U_Select.prototype = {
            constructor : U_Select,
            _init : function(option) {
                
            },
            _innerHTML : function() {
                var html = 
                ["      <div class=\"ui-select\">",
                "          <div class=\"ui-selected-value\"><span>销售状态不限</span><i class=\"kanfangicon icon-26 ui-select-arrow\"></i></div>",
                "          <ul class=\"ui-select-option ui-select-open\">",
                "              <li class=\"ui-select-item\">销售状态不限</li>",
                "              <li class=\"ui-select-item\">销售状态不限</li>",
                "              <li class=\"ui-select-item\">销售状态不限</li>",
                "              <li class=\"ui-select-item\">销售状态不限</li>",
                "          </ul>",
                "          <select id=\"\" name=\"\" class=\"ui-select-origin\"><option value=\"\"></option></select>",
                "      </div>",
                ].join("");

                return html;
            },
            onOpen:function() {
                
            },
            onClose:function() {
                
            },
            onSelect:function() {
                
            }
        };

        U_Select.prototype._init.prototype = U_Select.prototype;

        window.hj.U_Select = U_Select;
    })();



    //消息机制
     (function(window) {
        var core_slice = Array.prototype.slice;
        function Event() {
            this._event = [];
        }
        Event.prototype = {
            constructor:Event,
            on:function(event, func) {
                this._event[event] = this.push(this._event[event], func);
            },
            trigger:function(event) {
                if(!this._event[event]) return;
                var args = core_slice.call(arguments,1);
                Array.forEach(this._event[event], function(func, i) {
                    func.apply(null, args);
                });
            },
            listenTo:function(obj, event, fun) {
                obj.on(event, function() {
                    var args = core_slice.call(arguments);
                    fun.apply(obj, args);
                });
            },
            push:function(eve, func) {
                eve = Array.isArray(eve) ? eve : [];
                eve[eve.length] = func;
                return eve;
            }
        }

        Array.isArray = Array.prototype.isArray || function(ele) {
            return Object.prototype.toString.call(ele) === "[object Array]";
        };

        Array.forEach = Array.prototype.forEach && function(eles, func) {
            eles = [].slice.call(eles);
            eles.forEach(function(ele, i) {
                func(ele, i);
            });
        } || function(eles, func) {
            eles = [].slice.call(eles);
            for(var i = 0, len = eles.length; i < len; i++){
                func.call(eles[i], eles[i], i);
            }
        }
        window.hj.Event = Event;
    })(window);   
})(window,jQuery);
