$(document).ready(function(){
  $('body, html').animate({scrollTop:0}, 'slow');  
  
    window.fbAsyncInit = function() {
        FB.init({
          appId      : '680454735697047',
          cookie     : true,
          xfbml      : true,
          version    : 'v4.0'
        });
          
        FB.AppEvents.logPageView();   
          
      };
    
      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "https://connect.facebook.net/en_US/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));


    const buttonSignUp = document.getElementById('register');
    buttonSignUp.onclick = function () {
    document.getElementById('html').scrollTop += 580;
    };
    const buttonBack = document.getElementById('back');
    buttonBack.onclick = function () {
    document.getElementById('html').scrollTop -= 580;
    };


});