$(document).ready(function(){
    $( "#Alta" ).click(function() {
        $( ".addShow" ).toggle(true);
        $( ".shows" ).toggle(false);
    });
    $( "#SeeShows" ).click(function() {
        $( ".shows" ).toggle(true);
        $( ".addShow" ).toggle(false);
    });
});