//插件测试
//var t = countdown(new Date(2016,9,27,1,60,0),new Date(),countdown.MINUTES);
//console.log(t);

function extend_esy_yuye(){
    //时间间隔30分钟
    var time_space_minutes = time_interval;
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
                if(Math.abs(time_space.minutes) < time_space_minutes){
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
            $self.toggleClass('on');
            if($self.hasClass('on')){
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
                $self.removeClass('on')
            }else{
                if(check_is_right_time(select_time)){
                    add_time_toyuyue(select_time);
                    $self.addClass('on')
                }else{
                    alert('时间间隔不得小于'+time_space_minutes+'分钟');
                }
            }
            return false;
        });

        function add_time_minutes_on(html){
            for(var h in time_list){
                var list = time_list[h];
                for(var i in list){
                    var dom = html.find('li.time-minutes[data-hour="' + h + '"][data-minutes="' + i + '"]');
                    dom.addClass('on');
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

var api = extend_esy_yuye();
