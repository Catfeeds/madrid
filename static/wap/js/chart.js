if($('.price-box').length >0 ){
        var $piecebox = $('.price-box');
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
        
        $('.price-box').highcharts({
            chart:{
                style:{
                }
            },
            credits:{
                text: ''
            },
            title: {
                text:'111',
                style:{
                    color:'#fff'
                }
            },
            subtitle: {
                text:null
            },
            xAxis: {
                categories: categories,
                labels:{
                    style:{
                        fontSize:'24px'
                    }
                }
            },
            yAxis: {
                title: {
                    text: null
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }],
                labels:{
                    style:{
                        fontSize:'24px'
                    },
                    formatter:function() {
                        return this.value + '元';
                    }
                },
                min:0
            },
            tooltip: {
                valueSuffix: '元',
                style:{
                    fontSize:'18px'
                },
                enabled:false
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0,
                enabled:false
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

