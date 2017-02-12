/**
 * Created by Administrator on 2016/11/1.
 */


Do(function () {
    $(function () {


        $(".search-box .search-input input").keyup(function () {

            if ($(this).val()) {
                // console.log($(this).val());
                var $searchWord = $(this).val();
                // console.log($searchWord);
                var $searchBox =  $(".search-list-box").show();

                $.ajax({
                    url: "http://hjhouse.hualongxiang.com/api/resoldwapapi/esfsearchajax",
                    type: "get",
                    aynce:"true",
                    data: $searchWord,
                    dataType: "json",
                    success: function (data) {
                        // console.log(data);
                        var result = data.data;
                        console.log(result);
                        var str = "";
                        for (var i = 0; i < result.length; i++){
                            str += '<li><a href="" data-id = '+result[i]["hid"]+'>'
                                +'<span>'+result[i]["name"]+'<em>'+result[i]["area"]+'</em></span>'
                                +'<span class="right">'+'约'+result[i]["num"]+'条房源'+'</span>'
                                +'</a></li>'
                        }
                       $searchBox.html("<ul>"+str+"</ul>");

                    }
                })


            } else {
                $(".search-list-box").hide();
            }


        });
    });
});


