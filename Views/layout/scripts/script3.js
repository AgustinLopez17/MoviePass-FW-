$(document).ready(function(){
    $( "#Alta" ).click(function() {
        $( ".alta" ).toggle(true);
        $( ".baja" ).toggle(false);
        $( ".mod" ).toggle(false);
        $( ".addShow" ).toggle(false);
        $( ".addShowHour" ).toggle(false);
    });
    $( "#Mod" ).click(function() {
        $( ".mod" ).toggle(true);
        $( ".alta" ).toggle(false);
        $( ".baja" ).toggle(false);
        $( ".addShow" ).toggle(false);
        $( ".addShowHour" ).toggle(false);
    });
    $( "#Baja" ).click(function() {
        $( ".baja" ).toggle(true);
        $( ".mod" ).toggle(false);
        $( ".alta" ).toggle(false);
        $( ".addShow" ).toggle(false);
        $( ".addShowHour" ).toggle(false);
    });    
    $( "#AddShow" ).click(function() {
        $( ".addShow" ).toggle(true);
        $( ".baja" ).toggle(false);
        $( ".mod" ).toggle(false);
        $( ".alta" ).toggle(false);
        $( ".addShowHour" ).toggle(false);
    });
     
    function addHour(){
        $( ".addShowHour" ).toggle(true);
        $( ".baja" ).toggle(false);
        $( ".mod" ).toggle(false);
        $( ".alta" ).toggle(false);
        $( ".addShow" ).toggle(false);
    };


});

