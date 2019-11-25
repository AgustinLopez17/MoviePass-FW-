$(document).ready(function(){
    $( "#button1" ).click(function() {
        $( ".div1" ).toggle(true);
        $( ".div2" ).toggle(false);
        $( ".div3" ).toggle(false);
        $( ".div4" ).toggle(false);
        $( ".div1-1" ).toggle(false);
        $( ".div1-2" ).toggle(false);
        $( ".div1-3" ).toggle(false);
    });
    $( "#button2" ).click(function() {
        $( ".div2" ).toggle(true);
        $( ".div1" ).toggle(false);
        $( ".div3" ).toggle(false);
        $( ".div4" ).toggle(false);
        $( ".div1-1" ).toggle(false);
        $( ".div1-2" ).toggle(false);
        $( ".div1-3" ).toggle(false);
    });
    $( "#button3" ).click(function() {
        $( ".div3" ).toggle(true);
        $( ".div2" ).toggle(false);
        $( ".div1" ).toggle(false);
        $( ".div4" ).toggle(false);
        $( ".div1-1" ).toggle(false);
        $( ".div1-2" ).toggle(false);
        $( ".div1-3" ).toggle(false);
    });    
    $( "#button4" ).click(function() {
        $( ".div4" ).toggle(true);
        $( ".div3" ).toggle(false);
        $( ".div2" ).toggle(false);
        $( ".div1" ).toggle(false);
        $( ".div1-1" ).toggle(false);
        $( ".div1-2" ).toggle(false);
        $( ".div1-3" ).toggle(false);
    }); 


    $( "#button1-1" ).click(function() {

        $( ".div1-1" ).toggle(true);
        $( ".div1-2" ).toggle(false);
        $( ".div1-3" ).toggle(false);

        $( ".div2" ).toggle(false);
        $( ".div1" ).toggle(false);
        $( ".div3" ).toggle(false);
        $( ".div4" ).toggle(false);
    });
    $( "#button1-2" ).click(function() {

        $( ".div1-1" ).toggle(false);
        $( ".div1-2" ).toggle(true);
        $( ".div1-3" ).toggle(false);

        $( ".div3" ).toggle(false);
        $( ".div2" ).toggle(false);
        $( ".div1" ).toggle(false);
        $( ".div4" ).toggle(false);
    });    
    $( "#button1-3" ).click(function() {

        $( ".div1-1" ).toggle(false);
        $( ".div1-2" ).toggle(false);
        $( ".div1-3" ).toggle(true);

        $( ".div4" ).toggle(false);
        $( ".div3" ).toggle(false);
        $( ".div2" ).toggle(false);
        $( ".div1" ).toggle(false);
    });

});

