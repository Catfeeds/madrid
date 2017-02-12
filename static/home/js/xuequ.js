Do(function(){
    $(".school-info .more").bind("click", function (e) {
        e.preventDefault();
        var self = $(this);
        self.siblings(".detail").toggleClass("limit");
        if (self.text() == "更多") {
            self.text("收起");
        } else {
            self.text("更多");
        }
    });
});
