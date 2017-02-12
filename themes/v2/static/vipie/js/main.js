window.UEDITOR_HOME_URL = basedir + 'ueditor/';
Do.add('countdown',{
    'type' : 'js',
    'path' : basedir + 'countdown.min.js'
});
Do.add('BMap',{
    type : 'js',
    path : 'http://api.map.baidu.com/getscript?v=2.0&ak=srGiaQruHjU9pu4s3QVnLYnC&services=&t=20150812134435'
});
Do.add('datepicker',{
    'type' : 'js',
    'path' : basedir + 'My97DatePicker/my_WdatePicker.js'
});
Do.add('jqueryui',{
    'type' : 'js',
    'path' : basedir + 'jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.min.js',
    'requires' : ['jqueryui-css']
});
Do.add('jqueryui-css',{
    'type' : 'css',
    'path' : basedir + 'jquery-ui-1.9.2.custom/css/base/jquery-ui-1.9.2.custom.min.css'
});
Do.add('jqueryui-theme-css',{
    'type' : 'css',
    'path' : basedir + 'jquery-ui-1.9.2/themes/base/jquery.ui.theme.css'
});
Do.add('json2',{
    'type' : 'js',
    'path' : basedir + 'json2.js'
});
Do.add('placeholder',{
    'type' : 'js',
    'path' : basedir + 'jquery.placeholder.min.js'
});
Do.add('underscore',{
    'type' : 'js',
    'path' : basedir + 'underscore.js'
});
Do.add('template',{
    'type' : 'js',
    'path' : basedir + 'template.js' 
});
Do.add('ueditor',{
    'type' : 'js',
    'path' : basedir + 'ueditor/ueditor.all.min.js',
    'requires' : ['ueditor-config']
});
Do.add('ueditor-config',{
    'type' : 'js',
    'path' : basedir + 'ueditor/ueditor.config.js'
});
Do.add('qiniu',{
    'type' : 'js',
    'path' : basedir + 'qiniu-sdk/dist/qiniu.min.js'
});
Do.add('plupload',{
    'type' : 'js',
    'path' : basedir + 'plupload/js/plupload.full.min.js',
    'requires' : ['qiniu']
});
Do.add('validform',{
    'type' : 'js',
    'path' : basedir + 'validform.min.js'
});
Do.add('highcharts',{
    'type' : 'js',
    'path' : basedir + 'Highcharts-4.1.7/js/highcharts.js'
});
Do.add('superslide',{
    'type' : 'js',
    'path' : basedir + 'jquery.SuperSlide.2.1.1.js'
});
Do.add('dialog',{
    'type' : 'js',
    'path' : basedir + 'artDialog4.1.6/artDialog.js?skin=mysimple'
})
Do('plupload','placeholder','jqueryui','underscore','template','json2',function() {
    var $html = $('html');
    function is_html5(){
        return $html.hasClass('html5');
    }
    $('input,textarea').placeholder();

    //input radio 美化
    $.widget('my.modradio',{
        'options' : {
        },
        '_create' : function() {
            this._beautify();
            this._bindEvent();
            this._refresh();
        },
        //美化
        '_beautify' : function() {
            this._wrapElement = this.element.wrap('<span class="u-radio"></span>').closest('li');
            return this;
        },
        //绑定事件
        '_bindEvent' : function() {
            this._on(this._wrapElement,{
                'click' : function(e) {
                    this.element.prop('checked',true).triggerHandler('click');
                    e.preventDefault();
                }
            });
            this._on(this.element,{
                'click' : function() {
                    this._refreshAll();
                }
            });
        },
        //刷新样式，自己更新样式，自己一组也要更新样式
        '_refresh' : function() {
            this._delay(function() {
                var is_checked = this.element.prop('checked');
                this._wrapElement.toggleClass('checked', is_checked);
            });
            return this;
        },
        'refresh' : function() {
            this._refresh();
        },
        'refreshAll' : function() {
            this._refreshAll();
        },
        '_refreshAll' : function() {
            if(!this.checkbox_list){
                var radio_name = this.element.attr('name');
                this.checkbox_list = $('input[type="radio"][name="' + radio_name + '"]');
            }
            this.checkbox_list.modradio('refresh');
        }
    });

    //input checkbox 美化
    $.widget('my.modcheckbox',{
        'options' : {
        },
        '_create' : function() {
            this._beautify();
            this._bindEvent();
            this._refresh();
        },
        //美化
        '_beautify' : function() {
            this._wrapElement = this.element.wrap('<span class="u-checkbox"></span>').closest('li');
            return this;
        },
        //绑定事件
        '_bindEvent' : function() {
            this._on(this._wrapElement,{
                'click' : function() {
                    this.element.prop('checked',!this.element.prop('checked')).triggerHandler('click');
                }
            })
            this._on(this.element,{
                'click' : function() {
                    this._refresh();
                }
            });
        },
        //刷新样式，自己更新样式，自己一组也要更新样式
        '_refresh' : function() {
            this._delay(function() {
                var is_checked = this.element.prop('checked');
                this._wrapElement.toggleClass('checked',is_checked);
            });
            return this;
        },
        'refresh' : function() {
            this._refresh();
        }
    });
    //下拉组件
    $.widget('my.modselect',{
        'options' : {
            'classname' : '',
            'value' : null,
            'mheight' : 200
        },
        '_create' : function() {
            var container = this.element.wrap('<div class="mod-select ' + this.options.classname + '"></div>').parent();
            var html = this._getTpl();
            this.element.after(html);

            this._on(container,{
                'click .u-btn' : function(e) {
                    var list = $(e.target).parent().find('ul');
                    list.toggleClass('u-menu-show');
                }
            });
            this._on(container,{
                'click ul a' : function(e) {
                    var $self = $(e.target);
                    var $list = $self.closest('ul');
                    var value = $self.data('value');
                    var name = $self.text();
                    var $select_name = $self.closest('.mod-select').find('.select-name');
                    $list.removeClass('u-menu-show');
                    $select_name.text(name);
                    this.element.val(value);
                }
            });
        },
        'close' : function() {
            this.element.parent().find('ul').removeClass('u-menu-show');
            return this;
        },
        '_refresh' : function() {
            var html = this._getTpl();
            this.element.next().remove();
            this.element.after(html);
        },
        '_getTpl' : function() {
            var tpl = 'modselect-tpl';
            var options = this.element.find('option');
            var datalist = _.map(options,function(obj) {
                var $self = $(obj);
                var value = $self.val();
                var text = $self.text();
                return {
                    'name' : text,
                    'value' :value
                };
            })
            var now = {
                'value' : this.element.val(),
                'name' : this.element.find('option:selected').text()
            };
            var data = {
                'now' : now,
                'datalist' : datalist
            };
            var html = template(tpl,data);
            return html;
        },
        'refresh' : function() {
            this._refresh();
            return this;
        },
        '_setOption' : function(key,value) {
            this.element.val(value);
            this._refresh();
            this._super(key,value);
            return this;
        },
        'destroy' : function() {
            this.element.parent().after(this.element).remove();
            this._super();
        }
    });

    $(document).on('click',function(e) {
        var all_mod_select = $(':my-modselect');
        var parent_with_mod_select = $(e.target).closest('.mod-select');
        if(parent_with_mod_select){
            var now_select = parent_with_mod_select.find(':my-modselect');
            all_mod_select.not(now_select).modselect('close');
        }
    })

    //确认操作提示
    $.widget('my.modconfirm',{
        options : {
            'title' : '确认删除吗？',
            'ok' : null,
            'cancel' : null
        },
        _create : function() {
            this._initDialog();
            this._on(this.element,{
                'click' : function(e) {
                    if(this.isShow()){
                        this.hide();
                    }else{
                        this.show()
                    }
                }
            });

            this._on($('.g-mn'),{
                'scroll' : function() {
                    this.hide();
                }
            });
        },
        _initDialog: function() {
            var tpl = 'dialog-confirm';
            var data = {
                'title' : this.options.title
            };
            var $dialog = $(template(tpl,data));
            this._on($dialog,{
                'click .cancel' : function() {
                    this._trigger('cancel');
                    this.hide();
                },
                'click .ok' : function() {
                    this._trigger('ok');
                    this.hide();
                }
            });
            this._dialog = $dialog;
            return this;
        },
        isShow : function() {
            return this._dialog.is(':visible');
        },
        show : function() {
            this._dialog.appendTo('body').show()
            .position({
                    'my' : 'center bottom',
                    'at' : 'center top-8',
                    'of' : this.element
            }).find('.dialog-title').text(this.options.title);
        },
        hide : function() {
            this._dialog.remove();
        }
    });

    //编辑器
    $.widget('my.modueditor',{
        options : {
            'type' : 'simple'
        },
        _create : function() {
            this._initEditor();
            return this;
        },
        '_initEditor' : function() {
            var ue = UE.getEditor(this.element.prop('id'),{
                toolbars: [
                    ['fullscreen', 'source', 'undo', 'redo', 'bold']
                ]
            });
            this._ue = ue;
        },
        'getValue' : function() {
            return this._ue.getContent();
        }
    });

    //消息弹框
    $.widget('my.modmsg',{
        'options' : {
            'delay' : 2e3
        },
        _create : function() {
        },
        'show' : function() {
            var _this = this;
            this._show(this.element,{},function() {
                if(_this.options.delay){
                    _this._delay(_this.hide,_this.options.delay);
                }
            });
        },
        'hide' : function() {
            this._hide(this.element);
        }
    });

    //上传图片
    //type : 0 封面，删除
    //type : 1 无封面 无描述 有删除
    $.widget('my.modupload',{
        'options' : {
            //初始化数据
            'w' : 120,
            'h' : 90,
            'type' : 0,
            'max' : 2,
            'data' : {
                'list' : [],
                'current' : ''
            }
        },
        '_create' : function() {
            var _this = this;
            var element = this.element;
            var upload_empty = this.upload_empty = this.element.find('.upload-empty');
            var upload_list = this.upload_list =  this.element.find('.upload-img-list');
            var btn1 = this.btn1 = this.element.find('.u-upload-btn1').get(0);
            this.data = $.extend(true,{},this.options.data);
            this.upload1 = this._initUpload(btn1);
            this._bindEvent();
            this._refresh();
        },
        '_bindEvent' : function() {
            var _this = this;
            this.element.on('click','a.close',function(e) {
                var $self = $(this);
                var $container = $self.closest('.img-ele');
                var index = $container.data('index');
                //如果删除了封面，默认设置第一张为封面
                if(_this.data.current == index){
                    _this.data.current = 0;
                }
                var deletePic = _this.data.list.splice(index,1);
                $container.remove();
                _this._refresh();
                var key = deletePic && deletePic[0] && deletePic[0]['key'];
                _this._trigger('delete',event,key);
                return false;
            });

            this.element.on('click','.img-ele .pic',function(e) {
                var $self = $(this);
                var value = $self.parent().data('index');
                $self.parent().addClass('on').siblings().removeClass('on');
                _this._setCover(value);
            });
        },
        '_setCover' : function(value) {
            this.data.current = value;
        },
        //删除
        'delete' : function(obj) {
            var key = obj.key;
            var index = _.findIndex(this.data.list,{
                'key' : key
            });
            this.data.list.splice(index,1);
            this.refresh();
            return this;
        },
        //添加
        'add' : function(obj) {
            this.data.list.push(obj);
            this.refresh();
            return this;
        },
        '_refresh' : function() {
            var tpl = 'upload-tpl';
            if(this.options.type == 0){
                tpl = 'upload-tpl';
            }else if(this.options.type == 1){
                tpl = 'upload2-tpl';
            }
            if(this.data.list.length){
                var html = template(tpl,{
                    'list' : this.data.list,
                    'current' : this.data.current,
                    'w' : this.options.w,
                    'h' : this.options.h
                });
                this.upload_list.find('.img-ele').remove();
                this.upload_list.find('ul').append(html);
                this.upload_empty.hide();
                this.upload_list.show();
            }else{
                this.upload_empty.show();
                this.upload_list.hide();
            }
            if(this.data.list.length >= this.options.max){
                this.disable();
            }else{
                this.enable();
            }

        },
        '_ok' : function(up, file, res) {
            if(this.data.list.length >= this.options.max){
                return;
            }
            var domain = qn_domain;
            var data = $.parseJSON(res);
            var pic = 'http://' + domain + '/' + data.key;
            this.data.list.push({
                'pic' : pic,
                'key' : data.key
            });
            this._refresh();
        },
        '_error' : function(up, err, errTip) {
            
        },
        //初始化上传组件
        '_initUpload' : function(btnid) {
            var domain = qn_domain;
            var _this = this;
            var uploader = Qiniu.uploader({
                runtimes: 'html5,flash,html4',      // 上传模式，依次退化
                browse_button: btnid,         // 上传选择的点选按钮，必需
                // 在初始化时，uptoken，uptoken_url，uptoken_func三个参数中必须有一个被设置
                // 切如果提供了多个，其优先级为uptoken > uptoken_url > uptoken_func
                // 其中uptoken是直接提供上传凭证，uptoken_url是提供了获取上传凭证的地址，如果需要定制获取uptoken的过程则可以设置uptoken_func
                // uptoken : '<Your upload token>', // uptoken是上传凭证，由其他程序生成
                uptoken_url: qn_url,         // Ajax请求uptoken的Url，强烈建议设置（服务端提供）
                // uptoken_func: function(file){    // 在需要获取uptoken时，该方法会被调用
                //    // do something
                //    return uptoken;
                // },
                get_new_uptoken: false,             // 设置上传文件的时候是否每次都重新获取新的uptoken
                // downtoken_url: '/downtoken',
                // Ajax请求downToken的Url，私有空间时使用，JS-SDK将向该地址POST文件的key和domain，服务端返回的JSON必须包含url字段，url值为该文件的下载地址
                unique_names: true,              // 默认false，key为文件名。若开启该选项，JS-SDK会为每个文件自动生成key（文件名）
                save_key: true,                  // 默认false。若在服务端生成uptoken的上传策略中指定了sava_key，则开启，SDK在前端将不对key进行任何处理
                domain: domain,     // bucket域名，下载资源时用到，必需
                max_file_size: '100mb',             // 最大文件体积限制
                flash_swf_url: './plupload/js/Moxie.swf',  //引入flash，相对路径
                max_retries: 3,                     // 上传失败最大重试次数
                dragdrop: true,                     // 开启可拖曳上传
                drop_element: 'container',          // 拖曳上传区域元素的ID，拖曳文件或文件夹后可触发上传
                chunk_size: '4mb',                  // 分块上传时，每块的体积
                auto_start: true,                   // 选择文件后自动上传，若关闭需要自己绑定事件触发上传
                //x_vars : {
                //    查看自定义变量
                //    'time' : function(up,file) {
                //        var time = (new Date()).getTime();
                          // do something with 'time'
                //        return time;
                //    },
                //    'size' : function(up,file) {
                //        var size = file.size;
                          // do something with 'size'
                //        return size;
                //    }
                //},
                init: {
                    'FilesAdded': function(up, files) {
                        plupload.each(files, function(file) {
                            // 文件添加进队列后，处理相关的事情
                        });
                    },
                    'BeforeUpload': function(up, file) {
                           // 每个文件上传前，处理相关的事情
                    },
                    'UploadProgress': function(up, file) {
                           // 每个文件上传时，处理相关的事情
                    },
                    'FileUploaded': function(up, file, res) {
                        _this._ok(up,file,res);
                        //var data = $.parseJSON(res);
                        //var pic = 'http://' + domain + '/' + data.key;
                        //$('<img style="width:100px;" src="' + pic + '"/>').appendTo('.img-list');
                    },
                    'Error': function(up, err, errTip) {
                        _this._error(up,err,errTip);
                           //上传出错时，处理相关的事情
                    },
                    'UploadComplete': function() {
                           //队列文件处理完毕后，处理相关的事情
                    }
                }
            });
            return uploader;
        },
        '_getfulldata' : function() {
            var self = this;
            var copy_data = $.extend(true,{},this.data);
            copy_data.list = _.map(copy_data.list,function(o,k) {
                var val = self.upload_list.find('input').eq(k).val();
                return {
                    'pic' : o.pic,
                    'key' : o.key,
                    'text' : val
                }
            });
            return copy_data;
        },
        '_getsimpledata' : function() {
            var return_data = _.map(this.data.list,function(o,k) {
                return {
                    'pic' : o.pic,
                    'key' : o.key
                };
            });
            return return_data;
        },
        //获取数据，包括封面数据
        'getdata' : function() {
            var type = this.options.type;
            var data = [];
            if(type == 0){
                data = this._getfulldata();
            }
            if(type == 1){
                data = this._getsimpledata();
            }
            return data;
        },
        //刷新
        'refresh' : function() {
            this._refresh();
            return this;
        }
    });

    $.widget('my.modareaselect',{
        'options' : {
            'upload' : null,
            'pics' : null
        },
        _create : function() {
            if(this.upload == undefined){
                return;
            }
            this.options.pics = this.options.pics || [];
            this._init();
        },
        '_init' : function() {
            this._initPicList();
            this._bindEvent();
            return this;
        },
        '_initPicList' : function() {
            var tpl = 'u-area-list-tpl';
            var data = this.options.pics;
            var html = template(tpl,{
                'pics' : data
            });
            this.element.find('.u-area-list-inner').html(html);
            return this;
        },
        'refresh' : function() {
            this._initPicList();
            return this;
        },
        '_bindEvent' : function() {
            var self = this;
            this.options.upload.bind('moduploaddelete',function(event,key) {
                self.cancel(key);
                self.refresh();
            });
            this._on(this.element,{
                'click .link' : function(e) {
                    var $pic = $(e.target).closest('li');
                    var key = $pic.data('key');
                    var pic = this.getPic(key);
                    if(pic.status == false){
                        this.select(key);
                        this.options.upload.modupload('add',pic);
                    }

                    this.refresh();
                }
            });
        },
        'getPic' : function(key) {
            var pic = _.find(this.options.pics,{
                'key' : key
            });
            return pic;
        },
        'select' : function(key) {
            var index = _.findIndex(this.options.pics,{
                'key' : key
            });
            this.options.pics[index]['status'] = true;
        },
        'cancel' : function(key) {
            var index = _.findIndex(this.options.pics,{
                'key' : key
            });
            this.options.pics[index]['status'] = false;
        }
    });



    //字数限制输入框
    $.widget('my.modlen',{
        'options' : {
            'max' : 40
        },
        '_create' : function() {
            var num = this.element.find('.num');
            var input = this.element.find('input');
            var max = this.options.max;
            input.on('keypress input',function(event) {
                var len = input.val().length;
                if(len > max) return false;
                var rest = max - len;
                num.text(rest);
            }).triggerHandler('keypress');
        }
    });

    var $j_validform = $('.j-validform');
    if($j_validform.length){
        Do('validform',function() {
            //表单校验
                $('.j-validform').Validform({
                    'datatype' : {
                        'max5' : function(gets,obj,curform,regexp) {
                            var max = 5;
                            var len = curform.find('input[name="' + obj.attr('name') + '"]:checked').length;
                            if(len > max){
                                return '最多选择' + max + '个';
                            }
                        }
                    },
                    'tiptype' : function(msg,o,cssctl) {
                        var $ipt = o.obj.closest('.ipt');
                        var $msg = $ipt.find('.errmsg');
                        if(o.type == 3){
                            if($msg.length == 0){
                                $msg = $('<span class="errmsg"/>');
                                $ipt.append($msg);
                            }
                            $msg.show();
                            cssctl($msg,o.type);
                            $msg.text(msg);
                        }
                        if(o.type == 2){
                            $msg.hide();
                        }
                    },
                    'beforeSubmit' : function() {
                        return false;
                    }
                });
        })
    }
    $('.j-limit-num').modlen();

    $('.j-confirm2').modconfirm({
        'title' : '确认全选么',
        'cancel' : function() {
            alert('关闭了');
        }
    });
    $('.j-confirm1').modconfirm({
        'title' : '确认删除么',
        'ok' : function() {
            alert('ok');
        }
    });

    if($('.j-ueditor').length){
        Do('ueditor',function() {
            $('.j-ueditor').modueditor();
        })
    }

    var $tips = $('.confirm-tips').modmsg();

    $.fn.msg = {
        'show' : function() {
            $tips.modmsg('show');
        }
    };

    $('.j-msg-ok,.j-msg-error').click(function() {
        $.fn.msg.show();
    });
    $('#test-select-1').click(function() {
        var val = $('.j-select').val();
        alert(val);
    });
    $('#test-select-2').click(function() {
        $('.j-select').modselect('option','value',2);
    });
    $('#test-select-3').click(function() {
        $('.j-select').html('<option value="cj">常州</option><option value="bj">北京</option><option value="tj">天津</option>')
        $('.j-select').modselect('refresh');
    });
    $('#test-select-4').click(function() {
        $('.j-select').modselect('destroy');
    });
    $('#test-select-5').click(function() {
        $('.j-select').modselect();
    });

    $('.j-editor-1').click(function() {
        var value = $('.j-ueditor').modueditor().modueditor('getValue');
        alert(value);
    });

    $('#j-get-radiovalue').click(function() {
        var val = $('[name="f1"]:checked').val();
        alert(val);
    });
    $('#j-get-checkboxvalue').click(function() {
        var arr = [];
        $('[name="f2"]:checked').each(function() {
            arr.push(this.value);
        });
        alert(arr);
    });

    //价格趋势插件
    $.widget('my.modhighcharts',{
        'options' : {},
        '_create' : function() {
            //价格趋势
            this.element.highcharts({
                title: {
                    text: 'Monthly Average Temperature',
                    x: -20 //center
                },
                subtitle: {
                    text: 'Source: WorldClimate.com',
                    x: -20
                },
                xAxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun','Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                },
                yAxis: {
                    title: {
                        text: 'Temperature (°C)'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                tooltip: {
                    valueSuffix: '°C'
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: [{
                    name: 'Tokyo',
                    data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
                }, {
                    name: 'New York',
                    data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
                }, {
                    name: 'Berlin',
                    data: [-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0]
                }, {
                    name: 'London',
                    data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
                }]
            });
        }
    });

    var $highcharts_container = $('#highcharts-container');
    if($highcharts_container.length){
        Do('highcharts',function() {
            $highcharts_container.modhighcharts();
        });
    }
    //百度地图插件
    $.widget('my.modbmap',{
        'options' : {
            'lat' : 0,
            'lng' : 0,
            'zoom' : 12,
            'kw' : ''
        },
        '_create' : function() {
            this.$lng = this.element.find('.map-lng');
            this.$lat = this.element.find('.map-lat');
            this.$zoom = this.element.find('.map-zoom');
            this.$kw = this.element.find('.map-kw');
            this.$map = this.element.find('#j-location-map-container');
            this.$search_btn = this.element.find('.location-btn');
            
            var data = this._getData();
            var id = this.$map.attr('id');
            var map = new BMap.Map(id,{
                'enableMapClick' : false
            });    // 创建Map实例
            this.map = map;
            map.disableDoubleClickZoom();
            if(data.lng != 0){
                var point = new BMap.Point(data.lng,data.lat);
                this._addmarker(point);
                map.centerAndZoom(new BMap.Point(data.lng, data.lat), data.zoom);  // 初始化地图,设置中心点坐标和地图级别
            }else{
                map.centerAndZoom(new BMap.Point(116.404, 39.915), 12);  // 初始化地图,设置中心点坐标和地图级别
                this._iplocation();
            }
            map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放
            this._initEvent();
            //this._iplocation();
        },
        //初始化事件
        '_initEvent' : function() {
            var self = this;
            this.map.addEventListener('click',function(e) {
                var zoom = self.map.getZoom();
                var point = e.point;
                var lat = point.lat;
                var lng = point.lng;
                var data = {
                    'lat' : lat,
                    'lng' : lng,
                    'zoom' : zoom
                };
                self._refresh(data);
                self._clearmarker()._addmarker(point);
            });

            this._on(this.$search_btn,{
                'click' : this._search
            });
        },
        '_refresh' : function(data) {
            this._setData(data);
            return this;
        },
        '_setData' : function(data) {
            this.$lng.val(data.lng);
            this.$lat.val(data.lat);
            this.$zoom.val(data.zoom);
            return this;
        },
        '_getData' : function() {
            return {
                'lat' : this.$lat.val(),
                'lng' : this.$lng.val(),
                'zoom' : this.$zoom.val()
            };
        },
        //ip定位地址
        '_iplocation' : function() {
            var geolocation = new BMap.Geolocation();
            var self = this;
            geolocation.getCurrentPosition(function(r){
                if(this.getStatus() == BMAP_STATUS_SUCCESS){
                    self.map.panTo(r.point);
                }
                else {
                    //alert('failed'+this.getStatus());
                }        
            },{enableHighAccuracy: true})
        },
        //搜索区域然后定位
        '_search' : function(e) {
            var myGeo = new BMap.Geocoder();
            var self = this;
            var address = this.$kw.val();
            // 将地址解析结果显示在地图上,并调整地图视野
            myGeo.getPoint(address , function(point){
                if (point) {
                    self.map.centerAndZoom(point, 16);
                }else{
                    alert("您选择地址没有解析到结果!");
                }
            }, "");
            return this;
        },
        //创造标注点
        '_addmarker' : function(point) {
            var marker = new BMap.Marker(point);
            this.map.addOverlay(marker);
            return this;
        },
        '_clearmarker' : function() {
            this.map.clearOverlays();
            return this;
        }
    });

    if($('.j-location').length){
        Do('BMap',function() {
            $('.j-location').modbmap();
        })
    }

    //superSlide切换
    $.widget('my.modslide',{
        'options' : {
            'trigger' : 'click',
            'delayTime' : 0
        },
        '_create' : function() {
            this.element.slide(this.options);
        }
    });
    if($('.j-superslide').length){
        Do('superslide',function() {
            $('.j-superslide').modslide();
        });
    }



    //插件测试
    //var t = countdown(new Date(2016,9,27,1,60,0),new Date(),countdown.MINUTES);
    //console.log(t);

    function extend_esy_yuye(){
        //时间间隔30分钟
        var time_space_minutes = 30;
        //选择时间
        var select_time = {
            'hour' : '',
            'minute' : ''
        };
        //所选时间列表
        var time_list = {};
        //模版
        var hourminutes_tpl = 'timehourminutes-tpl';


        //计算时间间距
        function cal_time_space(start_time,end_time){
            var start_time_date = new Date(2000,1,1,start_time.hour,start_time.minute,0);
            var end_time_date = new Date(2000,1,1,end_time.hour,end_time.minute,0);
            return countdown(start_time_date,end_time_date,countdown.MINUTES);
        }

        //判断是否满足预约条件
        function check_is_right_time(select_time){
            for(var h in time_list){
                for(m in time_list[h]){
                    var check_time = {
                        'hour' : h,
                        'minute' : m
                    };
                    var time_space = cal_time_space(check_time,select_time);
                    if(Math.abs(time_space.minutes) < 30){
                        return false;
                    }
                }
            }
            return true;
        }

        //将要添加当前时间进预约
        function add_time_toyuyue(select_time){
            var hour = select_time['hour'];
            var minute = select_time['minute'];
            time_list[hour] = time_list[hour] || {};
            time_list[hour][minute] = 1;
        }

        function cancel_time_toyuyue(select_time){
            var hour = select_time['hour'];
            var minute = select_time['minute'];
            time_list[hour] = time_list[hour] || {};
            delete time_list[hour][minute];
        }


        function is_select(select_time){
            var hour = select_time['hour'];
            var minute = select_time['minute'];
            if(time_list[hour]){
                return time_list[hour][minute] == true;
            }
            return false;
        }
        //获取所有时间列表
        function get_time_list(){
            return time_list;
        }


        //界面部分
        function ui(){
            var $yuyue = $('.ui-yuyue');
            var $timehourminutes_content = $yuyue.find('.ui-yuyue-timehourminutes');

            $yuyue.on('click','.ui-yuyue-timehour .time-hour',function() {
                var $self = $(this);
                var hour = $self.data('hour');
                $self.toggleClass('time-hour-on');
                if($self.hasClass('time-hour-on')){
                    time_list[hour] = [];
                }else{
                    delete time_list[hour];
                }
                var html = create_timehourminutes_html(time_list);
                $timehourminutes_content.html(html);
                add_time_minutes_on($timehourminutes_content.find('ul'));
            });
            $yuyue.on('click','.ui-yuyue-timehourminutes .time-minutes',function() {
                var $self = $(this);
                var hour = $self.data('hour');
                var minutes = $self.data('minutes');
                var select_time = {
                    'hour' : hour,
                    'minute' : minutes
                };
                //这里做判断
                if(is_select(select_time)){
                    cancel_time_toyuyue(select_time);
                    $self.removeClass('time-minutes-on')
                }else{
                    if(check_is_right_time(select_time)){
                        add_time_toyuyue(select_time);
                        $self.addClass('time-minutes-on')
                    }else{
                        alert('不是正确的时间');
                    }
                }
                return false;
            });

            function add_time_minutes_on(html){
                for(var h in time_list){
                    var list = time_list[h];
                    for(var i in list){
                        var dom = html.find('li.time-minutes[data-hour="' + h + '"][data-minutes="' + i + '"]');
                        dom.addClass('time-minutes-on');
                    }
                }
            }


            function create_timehourminutes_html(){
                return template('timehourminutes-tpl',{hours:time_list});
            }
        }

        ui();

        return {
            'get_data' : get_time_list
        };
    }

    if($('.ui-yuyue').length){
        Do('countdown',function() {
            window.api = extend_esy_yuye();

            $('.ui-yuyue-days').find('.days').click(function() {
                $(this).addClass('days-on').siblings().removeClass('days-on');
            });
        })
    }

    //显示确认框
    $.fn.showConfirm = function(options) {
        var title = options.title;
        var ok_fun = options.ok || function(){};
        var cancel_fun = options.cancel || function(){};

        var html = template('my-ui-dialog-tpl',{
            'title' : title
        });
        var dialog = art.dialog({
            content: html
        });
        $(dialog.content()).on('click','.ok',function() {
            ok_fun();
            dialog.close();
            $(dialog.content()).off('click');
        })
        .on('click','.cancel',function() {
            cancel_fun();
            dialog.close();
            $(dialog.content()).off('click');
        })
    };
    //消息提示框
    $.fn.showMsg = function(msg) {
        var html = template('my-ui-dialog-msg-tpl',{
            'msg' : msg
        });
        art.dialog({
            content: html,
            time : 2
        });
    }
    if($('.j-confirm-dialog,.j-msg-dialog').length){
        Do('dialog',function() {
            $('.j-confirm-dialog').click(function() {
                $.fn.showConfirm({
                    'title' : '您确定要下架吗？',
                    'ok' : function() {
                        alert(1);
                    },
                    'cancel' : function() {
                        alert(2);
                    }
                });
                return false;
            });
            $('.j-msg-dialog').click(function() {
                $.fn.showMsg('批量预约成功xx条失败xx条');
                return false;
            });
            //委托全局弹框关闭
            $('body').on('click','.my-ui-dialog-close',function() {
                var list = art.dialog.list;
                for (var i in list) {
                    list[i].close();
                };
            });
        })
    }



    //$.fn.showConfirm('您确定要下架吗？');
    
    //侧边栏导航切换
    $('.nav > .m-list > li').each(function() {
        var $self = $(this);
        $self.click(function() {
          $self.toggleClass('n1-hover');  
        })
    });

    if($('.j-my97').length){
        Do('datepicker');
    }

    $('input[type="radio"]').modradio();
    $('input[type="checkbox"]').modcheckbox();
    $('.j-select').each(function() {
        var $self = $(this);
        var classname = $self.data('class') || '';
        $(this).modselect({
            'classname' : classname
        });  
    })

    if($('.j-upload,.j-upload2,.j-upload-area').length){
        Do('plupload',function() {
            var origin_data = JSON.parse('{"list":[{"pic":"http://pic.huafangweiyuan.com/o_1b62tjq2ruu11jv11238jfi9gli.png","text":""},{"pic":"http://pic.huafangweiyuan.com/o_1b62tjq2r1sjfq0ck84jje18sej.png","text":""}],"current":1}');
            var imgupload = $('.j-upload').modupload({
                'max' : 3,
                'type' : 0,
                'w' : 120,
                'h' : 90,
                'data' : origin_data
            });

            $('#j-test-upload').click(function() {
                var data = imgupload.modupload('getdata');
                var json_data = (JSON.stringify(data));
                //console.log(json_data);
                alert(json_data);
            });


            $('.j-upload2').each(function() {
                var $self = $(this);
                var w = $self.data('w') || 150;
                var h = $self.data('h') || 150;

                var imgupload2 = $self.modupload({
                    'type' : 1,
                    'w' : w,
                    'h' : h
                });
            })

            $('#j-test-upload2').click(function() {
                var data = imgupload2.modupload('getdata');
                alert(JSON.stringify(data));
            });

            var areaPicList = [{
                'key' : './style/images/area-pic.jpg',
                'pic' : './style/images/area-pic.jpg',
                'status' : false
            },{
                'key' : './style/images/area-pic.jpg',
                'pic' : './style/images/area-pic.jpg',
                'status' : false
            },{
                'key' : './style/images/area-pic.jpg',
                'pic' : './style/images/area-pic.jpg',
                'status' : false
            }];

            var areaimgupload = $('.j-upload-area').modupload({
                'max' : 3,
                'type' : 0,
                'w' : 120,
                'h' : 90,
                'data' : origin_data
            });
            $('.u-area-list').modareaselect({
                'pics' : areaPicList,
                'upload' : areaimgupload
            });

            $('#j-test-upload-area').click(function() {
                var data = areaimgupload.modupload('getdata');
                var json_data = (JSON.stringify(data));
                //console.log(json_data);
                alert(json_data);
            });
        })
    }




});
