$("html,body").animate({
    scrollTop: 860
}, 3300);

$(document).ready(function(){

    var flag=false;
    var scroll;
    $(window).scroll(function(){
        
        scroll=$(window).scrollTop();
        if(scroll > 450){
            if(!flag){
                $("#logo").css({"margin-top":"-5px","width":"92px","height":"92px","filter":"grayscale(100%) brightness(300%) drop-shadow(15px 15px 15px rgb(0, 0, 0))"});
                $("header").css({"background-color":"black"});
                flag = true;
            }
        }else{
            if(flag){
                $("#logo").css({"margin-top":"160px","width":"350px","height":"350px","filter":"none"});
                $("header").css({"background-color":"rgba(255, 255, 255, 0.103)"});
                flag = false;
            }
        }
    });

    const slider = document.querySelector('#container');
    let isDown = false;
    let startX;
    let scrollLeft;

    slider.addEventListener('mousedown', (e) => {
        isDown = true;
        slider.classList.add('active');
        startX = e.pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
    });
    slider.addEventListener('mouseleave', () => {
        isDown = false;
        slider.classList.remove('active');
    });
    slider.addEventListener('mouseup', () => {
        isDown = false;
        slider.classList.remove('active');
    });
    slider.addEventListener('mousemove', (e) => {
        if(!isDown) return;
        e.preventDefault();
        const x = e.pageX - slider.offsetLeft;
        const walk = (x - startX) * 3; //scroll-fast
        slider.scrollLeft = scrollLeft - walk;
        console.log(walk);
    });


    $( document ).ready( function() {
        $( "#searchByDate" ).click( function() {
            $( "#FORM_ID_DATE" ).toggle( );
        });
    });


});

$('#startBuy').click(function(){
    $.ajax({
        url: 'buyController.php',
        type:  'POST',
        data: $('#FormBuy').serialize(),
        success: function(res){
            $('#response').html(res);
        }
    });
});