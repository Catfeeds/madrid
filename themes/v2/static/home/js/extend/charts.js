if($('.piece-box').length >0 ){
        var $piecebox = $('.piece-box');
        var name = $piecebox.data('plot-name');
        var area_name= $piecebox.data('area-name');
        var city_name = $piecebox.data('city-name');
        var month = $piecebox.data('month').split(',');
        var area = $piecebox.data('area').split(',');
        var city = $piecebox.data('city').split(',');
        var plot =$piecebox.data('plot').split(',');
        var categories = month;

        $.each(plot,function(i){
            plot[i] = parseInt(plot[i]);
        });
        $.each(city,function(i){
            city[i] = parseInt(city[i]);
        });
        $.each(area,function(i){
            area[i] = parseInt(area[i]);
        });
        Modernizr.load([
            {
                load:[basedir + 'extend/highcharts/highcharts.min.js'],
                complete:function() {
                    $('.piece-box').highcharts({
                        credits:{
                            text: ''
                        },
                        title: {
                            text: null
                        },
                        subtitle: {
                            text:null
                        },
                        xAxis: {
                            categories: categories
                        },
                        yAxis: {
                            title: {
                                text: '价格'
                            },
                            plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080'
                            }],
                            min:0
                        },
                        tooltip: {
                            valueSuffix: '元'
                        },
                        legend: {
                            layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle',
                            borderWidth: 0
                        },
                        series: [{
                            name: name,
                            data: plot
                        }, {
                            name: area_name,
                            data: area
                        }, {
                            name: city_name,
                            data: city
                        }]
                    });
                }
            }
        ]);
}
