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
    var valorSenhaCorreto;

    campoSenhaAtual.addEventListener('blur',function(){
        var ajax = new XMLHttpRequest();
        var endereco = '/'+window.location.pathname.split('/')[1]+'/perfil/verificarSenhaAtual'; // Varia, depende do objeto a ser removido
        var senhaAtual = document.getElementById('senhaAtual').value;
        var email = document.getElementById('email').value;

        ajax.open("POST",endereco,true);
        ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        if(document.getElementById('email').disabled){
            ajax.send('senhaAtual='+senhaAtual+'&'+'filtro=email'+'&'+'valor='+email);
        }else{
            ajax.send('senhaAtual='+senhaAtual+'&'+'filtro=tipoUsuario'+'&'+'valor=ADMINISTRADOR');
        }
        

        ajax.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                if(!this.response.success){
                    campoSenhaAtual.parentElement.classList.add('has-error'); //Executa alguma ação
                    if(campoVazio(campoSenhaAtual.value)){
                        campoSenhaAtual.parentElement.classList.remove('has-error');
                    }
                }else{
                    campoSenhaAtual.parentElement.classList.remove('has-error');
                    valorSenhaCorreto = senhaAtual;
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

        if(!campoVazio(campoNome.value) && !campoVazio(campoSobrenome.value)){
            if((valorSenhaCorreto !== undefined && tamanhoCorretoSenha(campoSenhaNova.value)) || (campoVazio(campoSenhaAtual.value) && campoVazio(campoSenhaNova.value))){
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
            var valor = document.createElement("input");
            valor.setAttribute("type", "hidden");
            valor.setAttribute("name", 'valor');
            valor.setAttribute("value", document.getElementById('email').value);

            var tipoFiltro = document.createElement("input");
            tipoFiltro.setAttribute("type", "hidden");
            tipoFiltro.setAttribute("name", 'filtro');
            tipoFiltro.setAttribute("value", "email");

            form.appendChild(valor);
            form.appendChild(tipoFiltro);
        }else{ // Se for admin
            var valor = document.createElement("input");
            valor.setAttribute("type", "hidden");
            valor.setAttribute("name", 'valor');
            valor.setAttribute("value", "ADMINISTRADOR");

            var tipoFiltro = document.createElement("input");
            tipoFiltro.setAttribute("type", "hidden");
            tipoFiltro.setAttribute("name", 'filtro');
            tipoFiltro.setAttribute("value", 'tipoUsuario');

            form.appendChild(valor);
            form.appendChild(tipoFiltro);
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


