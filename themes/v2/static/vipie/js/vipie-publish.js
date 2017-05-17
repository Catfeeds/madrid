Do('plupload','placeholder','jqueryui','underscore','template','json2',function() {
   var t = $('.j-plot-search').autocomplete({
        source: plot_url,
        focus : function ( event , ui) {
            $('.j-plot-search').val(ui.item.label);
            return false;
        },
        select: function( event, ui ) {
            $('.j-plot-search').val(ui.item.label);
            $('#plot_id').val(ui.item.value);
/*            $.ajax({
                'url' : plot_info_url,
                'type' : 'get',
                'data' : {'hid':ui.item.value},
                'dataType' : 'json',
                'success' : function( data ) {
                    $('#plot_address').val(data.address);
/!*
                    $('.u-area-list').modareaselect({
                        'pics' : data.images,
                        'upload' : imgupload
                    });*!/
                }
            });
            // show_pics(origin_data,ui.item.value);*/
            // if($('#plot_id').val() == '0') {
            //     $('#plot_id').val(ui.item.value);
            // }
            show_pics(origin_data,ui.item.value);  
            return false;
      },
      _renderItem : function( ul, item ) {
        return $( "<li>" )
            .append( "<a>" + item.label + "</a>" )
            .appendTo( ul );
      }
    });

    function show_pics(origin_data,hid){
        if(hid != '') {
            $.ajax({
                'url' : plot_info_url,
                'type' : 'get',
                'data' : {'hid':hid,'infoId':info_id,'modelName':model_name},
                'dataType' : 'json',
                'success' : function( data ) {
                    $('#plot_address').val(data.address);

                    $('.u-area-list').modareaselect({
                        'pics' : data.images,
                        'upload' : imgupload
                    });
                }

            });
        }
        var imgupload = $('.j-upload-1').modupload({
            'max' : 28,
            'type' : 0,
            'w' : 120,
            'h' : 90,
            'data' : origin_data
        });    
        window.imgupload = imgupload;
    }

    $(document).ready(function(){
        if(typeof origin_data != 'undefined'){
            show_pics(origin_data,origin_hid);
        }
    });

    $('form').submit(function() {
        var img = imgupload.modupload('getdata');
        var list = img.list; 
        if(img.current == '')
            img.current = 0;
        if(list.length > 0) {
            for (var i = 0; i < list.length; i++) {
                html = '<input type="hidden" name="images[]" value="'+list[i].key+'"></input>';
                htmldes = '<input type="hidden" name="image_des[]" value="'+list[i].text+'"></input>';
                $('#sub-btn').after(html);
                $('#sub-btn').after(htmldes);
                if(i == img.current) {
                    html = '<input type="hidden" name="'+model_name+'[image]" value="'+list[i].key+'"></input>';

                    $('#sub-btn').after(html);
                }
            }
        }
        // return false;
    });
});