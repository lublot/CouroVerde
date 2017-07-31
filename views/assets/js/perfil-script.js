window.addEventListener('load',function(){

    var expandir = document.getElementById('expandir');
    expandir.addEventListener('click',function(){
        document.getElementById('senhaAtual').classList.remove('hidden');
        document.getElementById('senhaNova').classList.remove('hidden');
        expandir.classList.add('hidden');        
    });

    var campoNome = document.getElementById('nome');
    campoNome.addEventListener('blur',function(){
        if(contemNumero(campoNome.value) || campoVazio(campoNome.value)){
            campoNome.parentElement.classList.add('has-error');
        }else{
            campoNome.parentElement.classList.remove('has-error');
        }
    });

    var campoSobrenome = document.getElementById('sobrenome');
    campoSobrenome.addEventListener('blur',function(){
        if(contemNumero(campoSobrenome.value) || campoVazio(campoSobrenome.value)){
            campoSobrenome.parentElement.classList.add('has-error');
        }else{
            campoSobrenome.parentElement.classList.remove('has-error');
        }
    });

    var campoSenhaAtual = document.getElementById('senhaAtual');
    var emailSenhaCorreto;

    campoSenhaAtual.addEventListener('blur',function(){
        var ajax = new XMLHttpRequest();
        var endereco = '/'+window.location.pathname.split('/')[1]+'/perfil/verificarSenhaAtual'; // Varia, depende do objeto a ser removido
        var senhaAtual = document.getElementById('senhaAtual').value;
        var email = document.getElementById('email').value;

        ajax.open("POST",endereco,true);
        ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        if(document.getElementById('email').disabled){
            ajax.send('senhaAtual='+senhaAtual+'&'+'email='+email);
        }
        

        ajax.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                if(!JSON.parse(this.response).success){ // Se a senha estiver incorreta
                    campoSenhaAtual.parentElement.classList.add('has-error'); //Executa alguma ação
                    document.getElementById('botaoEnviar').classList.add('disabled');
                    if(campoVazio(campoSenhaAtual.value)){
                        campoSenhaAtual.parentElement.classList.remove('has-error');
                    }
                }else{
                    campoSenhaAtual.parentElement.classList.remove('has-error');
                    emailSenhaCorreto = senhaAtual;  
                }
            }
        }

        
    });
    
    var campoSenhaNova = document.getElementById('senhaNova');
    campoSenhaNova.addEventListener('blur',function(){
        if(!tamanhoCorretoSenha(campoSenhaNova.value)){
            campoSenhaNova.parentElement.classList.add('has-error');
            if(campoVazio(campoSenhaNova.value)){
                campoSenhaNova.parentElement.classList.remove('has-error');
            }
        }else{
            campoSenhaNova.parentElement.classList.remove('has-error');
        }
    });

    var form = document.getElementById('form');
    form.addEventListener('keyup',function(){

        if(campoVazio(campoSenhaAtual.value)){
            campoSenhaAtual.parentElement.classList.remove('has-error');
        }

        if((!campoVazio(campoNome.value) && !campoVazio(campoSobrenome.value)) && (!contemNumero(campoNome.value) && !contemNumero(campoSobrenome.value))){
            if((emailSenhaCorreto !== undefined && tamanhoCorretoSenha(campoSenhaNova.value)) || (campoVazio(campoSenhaAtual.value) && campoVazio(campoSenhaNova.value))){
                botaoEnvio.classList.remove('disabled');
                botaoEnvio.classList.add('btn-success');
            }else{
                botaoEnvio.classList.remove('btn-success');
                botaoEnvio.classList.add('disabled');
            }    
        }else{
            botaoEnvio.classList.remove('btn-success');
            botaoEnvio.classList.add('disabled');
        }
    });

    var botaoEnvio = document.getElementById('botaoEnviar');
    botaoEnvio.addEventListener('click',function(){
        if(document.getElementById('email').disabled){ //Verifica se o usuário não é admin
            var email = document.createElement("input");
            email.setAttribute("type", "hidden");
            email.setAttribute("name", 'email');
            email.setAttribute("value", document.getElementById('email').value);
            form.appendChild(email);
        }
        
        form.submit();        
    });

    function contemNumero(texto){
        var pattern = new RegExp('\\d');
        return pattern.test(texto);
    }

    function campoVazio(texto){
        return texto.replace(/\s/g, "").length == 0;
    }

    function tamanhoCorretoSenha(senha){
        return senha.length >= 8 && senha.length <= 32;
    }
    
});


