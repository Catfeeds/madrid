var $scroll = $('#scroller');
if($scroll.length){
    $scroll.width($scroll.find('ul').width());
    var myScroll;
    window.onload = function() {
        myScroll = new IScroll('#wrapper', { scrollX: true, scrollY: false, mouseWheel: true,tap:true ,click:true});
    }
    var wrapper = document.getElementById('wrapper');
    wrapper.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
}
