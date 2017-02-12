var LiveSearch = {
    input : null,
    formatResult: function(obj){

    },
	init: function (input, conf) {
		var config = {
			url: conf.url || false,
            defaultVal: "",
			data: conf.data || {}
		};
        this.input = input;
        this.formatResult = conf.formatResult;
		input.attr('autocomplete', 'off');
		var container = $('.result-list');
		input.on('keyup', function (e) {
			if ($(this).val() != config.defaultVal) {
				var q = $(this).val();
				if (this.liveSearchTimer) {
					clearTimeout(this.liveSearchTimer);
				}
				var url = config.url + q;
				//url += '&' + LiveSearch.serialize(config.data);

				var self = this;

				this.liveSearchTimer = setTimeout(function () {
					if (q) {
						$.ajax({
							method: 'get', 
							url: url,
                            type: 'json',
							success: function (data) {
                                var html = '';
                                $.each(data.msg,function(){
                                    html += LiveSearch.formatResult(this);
                                });
								container.html(html);
                                container.show();
							}
						});
					}
					else {
						container.html('');
					}
				}, 300);
			}
		});

        $(document).on('click', function(){
            container.hide();
        });
	},

	serialize: function (obj) {
		var str = [];
		for(var p in obj) {
			if (obj.hasOwnProperty(p)) {
				str.push(encodeURIComponent(p) + '=' + encodeURIComponent(obj[p]));
			}
		}
		return str.join('&');
	},
    destroy: function(){
        if(this.input)
            this.input.unbind("keyup");
    }
};

if (typeof(jQuery) != 'undefined') {
	jQuery.fn.liveSearch = function (conf) {
		return this.each(function () {
			LiveSearch.init(this, conf);
		});
	};
}