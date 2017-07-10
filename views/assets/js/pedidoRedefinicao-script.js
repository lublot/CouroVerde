window.addEventListener('load',function(){
    var btnProx = document.getElementById('btn-proximo');
    btnProx.addEventListener('click',function(){
        document.getElementById('form').submit();
    });
});