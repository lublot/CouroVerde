window.addEventListener('load',function(){

    var urlRaiz = window.location.origin+'/'+window.location.pathname.split('/')[1];
    var campo = document.getElementById('busca');
    campo.addEventListener('keydown',function(e){
        if(e.keyCode == 13){
            window.location.href = urlRaiz+'/busca?q='+campo.value;
        }
    });
});