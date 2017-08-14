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
        var endereco = '/'+window.location.pathname.split('/')[1]+'/funcionario/remover'; // Varia, depende do objeto a ser removido
        let matricula = document.getElementsByName('matricula')[0].value;
        let string = 'senhaAdmin='+senhaAdmin.value+'&'+'matriculaFuncionario='+matricula;
        

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
                    let mensagem = JSON.parse(this.response).erro;
                    configurarAlert(mensagem,'erro');
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

//Verifica se o cmapo é vazio
function campoVazio(texto){
    return texto.replace(/\s/g, "").length == 0;
}

});