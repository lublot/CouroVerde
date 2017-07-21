window.addEventListener('load',function(){


var busca = document.getElementById('campoBusca');
busca.addEventListener('keyup',function(){
    listarPesquisas();
});


listarPesquisas(); // É executado para alimentar as informações da página
function listarPesquisas(){

    var ajax = new XMLHttpRequest();
        var endereco = '/'+window.location.pathname.split('/')[1]+'/pesquisa/listarTodasPesquisas'; // Varia, depende do objeto a ser removido
        
        ajax.open("POST",endereco,true);
        ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        if(!campoVazio(busca.value)){
            ajax.send("titulo="+busca.value);
        }else{
            ajax.send();
        }
        
        var campoResposta = document.getElementById('resposta');
        ajax.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                var resposta = JSON.parse(this.response);
                if(resposta.length > 0){
                    while (campoResposta.firstChild) {
                        campoResposta.removeChild(campoResposta.firstChild);
                    }
                    for(var i=0;i<resposta.length;i++){
                        let box = criarBox(resposta[i]); 
                        campoResposta.appendChild(box);     
                    }
                }else{
                    campoResposta.innerHTML = "<h5>Não foi encontrada nenhuma pesquisa com esse título</h5>"
                }
            }
        }
}

function criarBox(pesquisa){

    var containerPai = document.createElement('div');
    containerPai.setAttribute('class',"panel col-sm-12");
    containerPai.setAttribute('value',pesquisa.idPesquisa);
    
    var cabecalho = configurarCabecalho(pesquisa.tituloPesquisa);
    var corpo = configurarConteudo(pesquisa.estaAtiva,pesquisa.descricaoPesquisa);
    var btnToggle = criarBotaoToggle(pesquisa.estaAtiva);
    var btnEditar = criarBotaoEditar();
    var btnRemover = criarBotaoRemover();

    
    var divSeparadora = document.createElement('div');
    divSeparadora.setAttribute('class','col-sm-6');

    var containerBotoes = document.createElement('div');
    containerBotoes.setAttribute('class','pull-right');
    containerBotoes.appendChild(btnToggle);
    containerBotoes.appendChild(document.createTextNode(' '));
    containerBotoes.appendChild(btnEditar);
    containerBotoes.appendChild(document.createTextNode(' '));
    containerBotoes.appendChild(btnRemover);

    containerPai.appendChild(cabecalho);
    containerPai.appendChild(corpo);
    containerPai.appendChild(divSeparadora);
    containerPai.appendChild(containerBotoes);
    containerPai.appendChild(document.createElement('br'));
    containerPai.appendChild(document.createElement('br'));

    return containerPai;

}


function configurarCabecalho(titulo){

    var panelHead = document.createElement('div');
    panelHead.setAttribute('class',"panel-heading panel-default");

    var panelTitle = document.createElement('span');
    panelTitle.setAttribute('class','panel-title');
    panelTitle.appendChild(document.createTextNode(titulo));

    panelHead.appendChild(panelTitle);
    
    return panelHead;
}

function configurarConteudo(status,descricao){

    var panelBody = document.createElement('div');
    panelBody.setAttribute('class','panel-body');

    var spanDescricao = document.createElement('span');
    spanDescricao.setAttribute('class','panel-title');
    spanDescricao.appendChild(document.createTextNode(descricao));
    

    var spanStatus = document.createElement('span');
    var corTexto = status ? 'rgb(4,244,4)':'rgb(244,4,4)';
    status = status ? 'Ativa':'Desativada';

    spanStatus.setAttribute('class','panel-title');
    spanStatus.style.color = corTexto;
    spanStatus.appendChild(document.createTextNode(status));

    panelBody.appendChild(spanDescricao);
    panelBody.appendChild(document.createElement('br')) // Cria uma quebra de linha
    panelBody.appendChild(spanStatus);

    return panelBody;
}

function criarBotaoToggle(status){
    var btnToggle = document.createElement('button');
    
    status? btnToggle.setAttribute('class','btn btn-warning'):btnToggle.setAttribute('class','btn btn-success'); //Se for true aparece a opção de desabilitar
    
    btnToggle.setAttribute('type','button');

    var iconeToggle = document.createElement('i');
    status? iconeToggle.setAttribute('class','fa fa-stop'):iconeToggle.setAttribute('class','fa fa-play');
    iconeToggle.setAttribute('aria-hidden',true);

    btnToggle.appendChild(iconeToggle);
    status ? btnToggle.appendChild(document.createTextNode(' Desativar')):btnToggle.appendChild(document.createTextNode(' Ativar'));//Se for true aparece a opção de desabilitar

    btnToggle.addEventListener('click',function(){
        var valor = this.parentNode.parentElement.getAttribute('value');
        console.log(valor);
        toggle(valor,status);
    });

    return btnToggle;
}

function criarBotaoEditar(){
    var btnEditar = document.createElement('button');
    btnEditar.setAttribute('class','btn btn-primary');
    btnEditar.setAttribute('type','button');

    var iconeEditar = document.createElement('i');
    iconeEditar.setAttribute('class','fa fa-pencil');
    iconeEditar.setAttribute('aria-hidden',true);

    btnEditar.appendChild(iconeEditar);
    btnEditar.appendChild(document.createTextNode(' Editar'));

    btnEditar.onclick = function(){
        editar(this.parentNode.parentElement.getAttribute('value'));
    };

    return btnEditar;
}

function criarBotaoRemover(){

    /* Configura o botão de remoção */
    var btnRemover = document.createElement('button');
    btnRemover.setAttribute('class','btn btn-danger');
    btnRemover.setAttribute('type','button');

    var iconeRemover = document.createElement('i');
    iconeRemover.setAttribute('class','fa fa-trash-o');
    iconeRemover.setAttribute('aria-hidden',true);

    btnRemover.appendChild(iconeRemover);
    btnRemover.appendChild(document.createTextNode(' Remover'));

    btnRemover.addEventListener('click',function(e){
        $('#myModal').modal('show');
        var botaoConfirmaRemocao = document.getElementById('confirmaRemover');
        var senhaAdmin = document.getElementById('password');
        var valor = this.parentNode.parentElement.getAttribute('value');

        botaoConfirmaRemocao.onclick = function(){
            remover(valor);
        };    
    });

    return btnRemover;
}

function toggle(idPesquisa,estadoAtual){
    var ajax = new XMLHttpRequest();
    var endereco = '/'+window.location.pathname.split('/')[1]+'/pesquisa/toggle'; // Varia, depende do objeto a ser removido
    
    let string = 'idPesquisa='+idPesquisa+'&'+'estadoAtual='+estadoAtual;
    
    ajax.open("POST",endereco,true);
    ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    ajax.send(string);
    
    ajax.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            
            if(JSON.parse(this.response).success == true){
                listarPesquisas();
            }else{
                let mensagem = JSON.parse(this.response).erro;
                configurarAlert(mensagem,'erro');
            }
        }
    }
}

function editar(idPesquisa){
    
}

function remover(valor){
    
        
        var senhaAdmin = document.getElementById('password');
        
        
        if(!campoVazio(senhaAdmin.value) && senhaAdmin.value.length >= 8 && senhaAdmin.value.length <= 32){
            var ajax = new XMLHttpRequest();
            var endereco = '/'+window.location.pathname.split('/')[1]+'/pesquisa/remover'; // Varia, depende do objeto a ser removido
            
            let string = 'senhaAdmin='+senhaAdmin.value+'&'+'idPesquisa='+valor;
            

            ajax.open("POST",endereco,true);
            ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            ajax.send(string);
            
            ajax.onreadystatechange = function(){
                if (this.readyState == 4 && this.status == 200) {
                    
                    if(JSON.parse(this.response).success == true){
                        listarPesquisas();
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

function configurarAlert(mensagem,tipoErro){
    
    var alert = document.getElementById('alert');

    var aviso = document.createElement('div');
    aviso.setAttribute('role','alert');

    if(tipoErro == "erro"){
        aviso.setAttribute('class','alert alert-danger alert-dismissible')
    }else if(tipoErro == 'warning'){
        aviso.setAttribute('class','alert alert-warning alert-dismissible');
    }
    
    var btnFechar = document.createElement('button');
    btnFechar.setAttribute('type','button');
    btnFechar.setAttribute('class','close');
    btnFechar.setAttribute('data-dismiss','alert');
    btnFechar.setAttribute('aria-label','close');

    var iconeBtnFechar = document.createElement('span');
    iconeBtnFechar.setAttribute('aria-hidden',true);
    iconeBtnFechar.innerText = '×';
    
    btnFechar.appendChild(iconeBtnFechar);
    
    aviso.appendChild(btnFechar);
    aviso.appendChild(document.createTextNode(mensagem));

    alert.appendChild(aviso);
}
//Verifica se o cmapo é vazio
function campoVazio(texto){
    return texto.replace(/\s/g, "").length == 0;
}
});