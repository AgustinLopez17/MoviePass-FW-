$(document).ready(function(){
    $( "#Alta" ).click(function() {
        $( ".alta" ).toggle(true);
        $( ".baja" ).toggle(false);
        $( ".mod" ).toggle(false);
        $( ".cinemas" ).toggle(false);
    });
    $( "#Mod" ).click(function() {
        $( ".mod" ).toggle(true);
        $( ".alta" ).toggle(false);
        $( ".baja" ).toggle(false);
        $( ".cinemas" ).toggle(false);
    });
    $( "#Baja" ).click(function() {
        $( ".baja" ).toggle(true);
        $( ".mod" ).toggle(false);
        $( ".alta" ).toggle(false);
        $( ".cinemas" ).toggle(false);
    });    
    $( "#Cinemas" ).click(function() {
        $( ".cinemas" ).toggle(true);
        $( ".baja" ).toggle(false);
        $( ".mod" ).toggle(false);
        $( ".alta" ).toggle(false);
    }); 



});

