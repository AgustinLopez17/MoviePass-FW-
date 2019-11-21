$(document).ready(function(){
    $( "#Alta" ).click(function() {
        $( ".alta" ).toggle(true);
        $( ".baja" ).toggle(false);
        $( ".mod" ).toggle(false);
    });
    $( "#Mod" ).click(function() {
        $( ".mod" ).toggle(true);
        $( ".alta" ).toggle(false);
        $( ".baja" ).toggle(false);
    });
    $( "#Baja" ).click(function() {
        $( ".baja" ).toggle(true);
        $( ".mod" ).toggle(false);
        $( ".alta" ).toggle(false);
    }); 
});