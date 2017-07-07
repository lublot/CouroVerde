window.addEventListener('load',function(){
    var btnProx = document.getElementById('btn-proximo');
    btnProx.addEventListener('click',function(){
        document.getElementById('form').submit();
    });

    var btnReset = document.getElementById('btn-cancelar');
    btnReset.addEventListener('click',function(){
        document.getElementById('form').reset();
    });

});