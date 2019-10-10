$("#scroller").animate({
    scrollTop: 1850
}, 2200);


$(document).ready(function(){
    const buttonSignUp = document.getElementById('register');
    buttonSignUp.onclick = function () {
        
    document.getElementById('html').scrollTop += 418;
    };

    const buttonBack = document.getElementById('back');
    buttonBack.onclick = function () {
        
    document.getElementById('html').scrollTop -= 418;
    };
});