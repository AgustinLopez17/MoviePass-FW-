$(document).ready(function(){
    const buttonSignUp = document.getElementById('register');
    buttonSignUp.onclick = function () {
        
    document.getElementById('html').scrollTop += 580;
    };

    const buttonBack = document.getElementById('back');
    buttonBack.onclick = function () {
        
    document.getElementById('html').scrollTop -= 580;
    };
});