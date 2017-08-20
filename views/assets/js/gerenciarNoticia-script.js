window.addEventListener('load',function(){

var btnRemover = document.getElementById('remover');
btnRemover.addEventListener('click',function(){
    $('#myModal').modal('show');
});


var btnConcluirRemocao = document.getElementById('confirmaRemover');
btnConcluirRemocao.addEventListener('click',function(){
    remover();
});

function remover(){
    var senhaAdmin = document.getElementById('password');

    if(!campoVazio(senhaAdmin.value) && senhaAdmin.value.length >= 8 && senhaAdmin.value.length <= 32){
        var ajax = new XMLHttpRequest();
        var endereco = '/'+window.location.pathname.split('/')[1]+'/noticias/remover'; // Varia, depende do objeto a ser removido
        let idNoticia = document.getElementById('idNoticia').value;
        let string = 'senhaAdmin='+senhaAdmin.value+'&'+'idNoticia='+idNoticia;
        

        ajax.open("POST",endereco,true);
        ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        ajax.send(string);
        
        ajax.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                
                if(JSON.parse(this.response).success == true){
                    let url = window.location.origin;
                    let pasta = window.location.pathname.split('/')[1];
                    let controller = window.location.pathname.split('/')[2];
                    window.location.href = url+"/"+pasta+"/"+controller;
                }else{
                }
            }
        }
    }else{
        configurarAlert('Por favor, digite uma senha válida','warning');
    }

    document.getElementById('password').value = ""; //Limpa o campo da senha do "cache"
}

function configurarAlert(texto){
    var campo = document.getElementById('notify');
    let h6 = document.createElement('h6');
    h6.setAttribute('class',"text-danger text-center");
    h6.appendChild(document.createTextNode(texto));
    campo.appendChild(h6);
}


var btnEnviar = document.getElementById("confirmar");
btnEnviar.addEventListener('click',function(){
    enviar();
});

function enviar(){
    var ajax = new XMLHttpRequest();
    var endereco = '/'+window.location.pathname.split('/')[1]+'/noticias/gerenciarNoticia'; // Varia, depende do objeto a ser removido
    
    let idNoticia = document.getElementById('idNoticia').value;    
    let titulo = document.getElementsByName('titulo')[0].value;
    let descricao = document.getElementsByName('descricao')[0].value;
    let subtitulo = document.getElementsByName('subtitulo')[0].value;


    ajax.open("POST",endereco,true);
    ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    ajax.send(
            'idNoticia='+idNoticia+'&titulo='+titulo+'&descricao='+descricao+'&subtitulo='+subtitulo
        );
    
    ajax.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            
            if(JSON.parse(this.response).success == true){
                let url = window.location.origin;
                let pasta = window.location.pathname.split('/')[1];
                let controller = window.location.pathname.split('/')[2];
                window.location.href = url+"/"+pasta+"/"+controller;
            }else{
                let mensagem = JSON.parse(this.response).erro;
                
            }
        }
    }
}

//Verifica se o cmapo é vazio
function campoVazio(texto){
    return texto.replace(/\s/g, "").length == 0;
}

});