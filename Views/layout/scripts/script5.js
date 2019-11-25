$(document).ready(function(){
    $( "#Button1" ).click(function() {
        $( ".div1" ).toggle(true);
        $( ".div2" ).toggle(false);
    });
    $( "#Button2" ).click(function() {
        $( ".div2" ).toggle(true);
        $( ".div1" ).toggle(false);
    });
});