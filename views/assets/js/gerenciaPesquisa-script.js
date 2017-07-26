window.addEventListener('load',function(){
var body = document.getElementsByTagName('body')[0];
body.style.visibility = 'visible';
var botaoEnvio = document.getElementById('botaoEnvio');
botaoEnvio.addEventListener('click',function(){
    enviar();
});
carregar();
function carregar(){
    var ajax = new XMLHttpRequest();
    var idPesquisa = window.location.href.split('/').pop();
    // var endereco = '/'+window.location.pathname.split('/')[1]+'/pesquisa/buscar/'+idPesquisa; // Varia, depende do objeto a ser removido
    var endereco = '/'+window.location.pathname.split('/')[1]+'/pesquisa/buscar/'+idPesquisa;

    ajax.open("POST",endereco,true);
    ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    ajax.send();

    ajax.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            
            if(Object.keys(JSON.parse(this.response)).length >= 3){
                var mensagem = JSON.parse(this.responseText);
                configurarTela(separarInformacoes(mensagem));
            }else{
                document.getElementById('principal').style.visibility='hidden';//Executa outra ação
                document.getElementById('aviso').innerText = JSON.parse(this.response).erro;
                document.getElementById('alerta').style.display ='block';
            }
        }
    }
}


/* ######################### Métodos responsáveis por carregar os itens já cadastrados ###############################*/


function separarInformacoes(mensagem){
    var pesquisa = [];

    pesquisa['idPesquisa'] = mensagem.idPesquisa;
    pesquisa['tituloPesquisa'] = mensagem.tituloPesquisa;
    pesquisa['descricaoPesquisa'] = mensagem.descricaoPesquisa;

    delete mensagem.tituloPesquisa;
    delete mensagem.descricaoPesquisa;
    delete mensagem.idPesquisa;

    
    Object.keys(mensagem).forEach(function(k,i){
        let pergunta = mensagem[i]['Pergunta'];
        let opcao = mensagem[i]['Opcao'];
        pesquisa[i] = parsePerguntas(pergunta,opcao);
    });

    return pesquisa;
}

function parsePerguntas(pergunta,opcao){
    var arrayPergunta = [];

    arrayPergunta['idPergunta'] = pergunta.idPergunta;
    arrayPergunta['tituloPergunta'] = pergunta.titulo;
    arrayPergunta['tipoPergunta'] = pergunta.tipo;
    arrayPergunta['opcional'] = (pergunta.opcional=='1')? true:false;
    arrayPergunta['opcoes'] = opcao;

    return arrayPergunta;
}


function configurarTela(pesquisa){
    document.getElementById('tituloPesquisa').setAttribute('idPesquisa',pesquisa['idPesquisa']);
    document.getElementById('tituloPesquisa').value = pesquisa['tituloPesquisa'];
    document.getElementById('descricaoPesquisa').value = pesquisa['descricaoPesquisa'];
    delete pesquisa['tituloPesquisa'];
    delete pesquisa['descricaoPesquisa'];
    delete pesquisa['idPesquisa'];

    for(var i=0;i<pesquisa.length;i++){
        carregarPerguntas(pesquisa[i]);
    }
    
}

//Este método carrega as perguntas recebidas
function carregarPerguntas(perguntaRecebida){
    var divPergunta = document.createElement('div');
        
     //Configura atributos
     divPergunta.setAttribute('class','form-group');
     divPergunta.setAttribute('name','Pergunta');
     divPergunta.setAttribute('tipo',perguntaRecebida['tipoPergunta']);
     divPergunta.setAttribute('idPergunta',perguntaRecebida['idPergunta']);

    //Configura o contéudo da div
    var pergunta = configuraPerguntaRecebida(perguntaRecebida['tituloPergunta']);
    var icone = configuraIconeRemover();
    var obrigatorio = carregarObrigacao(perguntaRecebida['opcional']);
    var titulo = document.createTextNode(' Resposta Obrigatória');

    if(perguntaRecebida.opcional==1){
        divPergunta.setAttribute('obrigatorio',false);
    }else{ 
        divPergunta.setAttribute('obrigatorio',true);
    }
    //Adiciona os elementos ao DOM
    divPergunta.appendChild(pergunta);
    divPergunta.appendChild(document.createTextNode(' '));//Adiciona um espaço
    divPergunta.appendChild(icone);
    divPergunta.appendChild(document.createElement('br'));
    divPergunta.appendChild(obrigatorio);
    divPergunta.appendChild(titulo);
    
    //Verifica se a pergunta é fechada
    if(pergunta['tipoPergunta'] != 'ABERTA'){
        var opt = perguntaRecebida['opcoes'];
        // var opt = carregarOpcoes(perguntaRecebida['opcoes']);
        for(var i=0; i<opt.length;i++){
            divPergunta.appendChild(carregarOpcoes(opt[i]));
        }
        divPergunta.appendChild(configuraBotaoCriarOpcao());
    }

    //Insere o elemento configurado antes do "guia pergunta"
    document.getElementById('guia-pergunta').parentNode.insertBefore(divPergunta,document.getElementById('guia-pergunta'));
}

// Configura o conteúdo da pergunta
function configuraPerguntaRecebida(titulo){
    var pergunta = document.createElement('input');

    pergunta.setAttribute('value',titulo); //Configura o titulo 
    pergunta.setAttribute('contenteditable',true);
    
    botaoEnvio.setAttribute('disabled',true);//Desabilita o botão

    if((pergunta.value.length + 1) * 8 > 200){
        pergunta.style.width = ((pergunta.value.length + 1) * 8) + 'px';
    }
    pergunta.addEventListener('blur',function(){
        if(campoVazio(this.value)){ // Se o campo for vazio, torna o botão de envio inacessível
            this.style.borderBottomColor = 'rgb(244,3,3)';
            botaoEnvio.setAttribute('disabled',true);
        }else{ // Caso contrário, torna o botão de envio acessível
            if(!campoVazio(tituloPesquisa.value)){
                this.style.borderBottomColor = 'rgb(3,244,3)';
                botaoEnvio.removeAttribute('disabled');
            }
        }
    });

    pergunta.addEventListener('keydown',function(e){
        if((this.value.length + 1) * 8 > 200){
            this.style.width = ((this.value.length + 1) * 8) + 'px';
        } 
    });

    //Configura o CSS da pergunta
    pergunta.style.minWidth = '200px';
    pergunta.style.maxWidth = '95%';
    pergunta.style.paddingLeft = '3px';
    pergunta.style.fontWeight = 'bold';
    pergunta.style.borderRight = "none";
    pergunta.style.borderTop = "none";
    pergunta.style.borderLeft = "none";
    pergunta.placeholder = "Insira o título da pergunta";
    pergunta.style.marginTop = "4px";

    return pergunta;
}

function carregarObrigacao(opcional){
    var checkbox = document.createElement('input');
    checkbox.setAttribute('type','checkbox')
    checkbox.setAttribute('class','icheckbox_flat');

    //Marca ou desmarca a checkbox

    if(opcional){
        checkbox.checked = false;
    }else{
        checkbox.checked = true;
    }

    checkbox.addEventListener('click',function(){
        if(this.checked){//Se não for opcional
            this.parentElement.setAttribute('obrigatorio',true);
        }else{
            this.parentElement.setAttribute('obrigatorio',false);
        }
    });

    return checkbox;
}

//Este método carrega as opções cadastradas
function carregarOpcoes(opcoes){
    var divOpcao = document.createElement('div');
    
    // var arrayOpcoes = [];
    // for(var i=0;i<opcoes.length;i++){
        var opcao = carregarOpcao(opcoes);
        var icone = configuraIconeRemover();
        // divOpcao.setAttribute('idOpcao',opcoes[i].idOpcao);
        divOpcao.appendChild(opcao);
        divOpcao.appendChild(document.createTextNode(' '));
        divOpcao.appendChild(icone);
        divOpcao.appendChild(document.createElement('br'));
        //arrayOpcoes.push(divOpcao);
    // }
    
    return divOpcao;
}

// Carrega o conteúdo da opção da pergunta já cadastrada
function carregarOpcao(opcaoRecebida){
    var opcao = document.createElement('input');
    opcao.setAttribute('class','opcao');
    opcao.setAttribute('idOpcao',opcaoRecebida.idOpcao);
    opcao.setAttribute('contenteditable',true);

    (opcaoRecebida != undefined)? opcao.setAttribute('value',opcaoRecebida.descricao):opcao.setAttribute('value','');
    
    if((opcao.value.length + 1) * 8 > 200){
        opcao.style.width = ((opcao.value.length + 1) * 8) + 'px';
    }

    opcao.addEventListener('blur',function(){
        if((this.value.length)==0 || campoVazio(this.value)){
            this.style.borderBottomColor = 'rgb(244,3,3)';
            botaoEnvio.setAttribute('disabled',true);
        }else{
            if(!campoVazio(tituloPesquisa.value) && !campoVazio(descricaoPesquisa.value)){
                this.style.borderBottomColor = 'rgb(3,244,3)';
                botaoEnvio.removeAttribute('disabled');
            }
        }
    });

    opcao.addEventListener('keydown',function(){
        if((this.value.length + 1) * 8 > 200){
            this.style.width = ((this.value.length + 1) * 8) + 'px';
        } 
    });

    //Configura o CSS da pergunta
    opcao.style.fontWeight = 'medium';
    opcao.style.borderRight = "none";
    opcao.style.borderTop = "none";
    opcao.style.borderLeft = "none";
    opcao.placeholder = "Insira a opção aqui";
    opcao.style.marginTop = "4px";

    return opcao;
}


/*########################### Métodos usados por itens antigos e novos ###############################*/
//Configura o ícone/botão de remoção
function configuraIconeRemover(){
    var icone = document.createElement('span');
    icone.setAttribute('class','fa fa-minus-circle fa-lg');
    icone.setAttribute('aria-hidden',true);

    icone.style.color = "red";
    icone.style.cursor = 'pointer';
    
    icone.addEventListener('click',function(){
        this.parentNode.parentNode.removeChild(this.parentNode);
        var listaPerguntas = document.getElementsByName('Pergunta');
        
        if(listaPerguntas.length == 0){
            botaoEnvio.setAttribute('disabled',true);
        }
    });
    return icone;
}


function configuraBotaoCriarOpcao(){

    var botao = document.createElement('div');
    var espaco = document.createTextNode(' ');
    var quebraLinha = document.createElement('br');
    var titulo = document.createTextNode('Adicionar uma opção');
    var icone = configuraIconeAdicionarOpcao();

    botao.appendChild(quebraLinha);
    botao.appendChild(titulo);
    botao.appendChild(espaco);
    botao.appendChild(icone);

    return botao;
}

function configuraIconeAdicionarOpcao(){
    var icone = document.createElement('span');
    var classe = document.createAttribute('class');
    classe.value = 'fa fa-plus-circle fa-lg';

    var ariahidden = document.createAttribute('aria-hidden');
    ariahidden.value = true;
    
    icone.style.color = "green";
    icone.style.cursor = 'pointer';
    icone.setAttributeNode(classe);
    icone.setAttributeNode(ariahidden);

    
    icone.addEventListener('click',function(){
        addOpcao(this);
    });
    return icone;
}

//Verifica se o campo é vazio
function campoVazio(texto){
    return texto.replace(/\s/g, "").length == 0;
}

/* ############### Métodos usados por itens novos  ################# */

//Adiciona um event listener que ativa o modal
var btnAddPergunta = document.getElementById('addPergunta');
btnAddPergunta.addEventListener('click',function(){
    $('#modal').modal('show');
});


//Adiciona um event listener e inicia a configuração de uma pergunta
var btnConfirmaAddPergunta = document.getElementById('confirmaAddPergunta');
btnConfirmaAddPergunta.addEventListener('click',function(){
    var tipoSelecionado;
    var campos = document.getElementsByName('tipoPergunta');
    for(var i=0;i<campos.length;i++){ // Procura a opção selecionada
        if(campos[i].checked){
            tipoSelecionado = campos[i].value;
            addPergunta(tipoSelecionado);
        }
    }
});

//Este método cria a DIV da pergunta
function addPergunta(tipo){
    var divPergunta = document.createElement('div');
    var quebraLinha = document.createElement('br');
    var espaco = document.createTextNode(' ');
    var classeDiv = document.createAttribute('class');
    classeDiv.value = "form-group";

    var name = document.createAttribute('name');
    name.value = "Pergunta";

    var tipoPergunta = document.createAttribute('tipo');
    tipoPergunta.value = tipo;

    //Configura atributos
    divPergunta.setAttributeNode(classeDiv);
    divPergunta.setAttributeNode(tipoPergunta);
    divPergunta.setAttributeNode(name);

    //Configura o contéudo da div
    var pergunta = configuraPergunta();
    var icone = configuraIconeRemover();
    var obrigatorio = configuraObrigacao();
    var titulo = document.createTextNode(' Resposta Obrigatória');
    console.log(tipo);
    //Adiciona os elementos ao DOM
    divPergunta.appendChild(pergunta);
    divPergunta.appendChild(espaco);
    divPergunta.appendChild(icone);
    divPergunta.appendChild(quebraLinha);
    divPergunta.appendChild(obrigatorio);
    divPergunta.appendChild(titulo);
    
    //Verifica se a pergunta é fechada
    if(tipo != 'ABERTA' && tipo !='Aberta'){
        divPergunta.appendChild(configuraBotaoCriarOpcao());
    }

    //Insere o elemento configurado antes do "guia pergunta"
    document.getElementById('guia-pergunta').parentNode.insertBefore(divPergunta,document.getElementById('guia-pergunta'));
}

// Configura o conteúdo da pergunta
function configuraPergunta(){
    var pergunta = document.createElement('input');
    
    var isEditable = document.createAttribute('contenteditable');
    isEditable.value = true;
    pergunta.setAttributeNode(isEditable);
    
    botaoEnvio.setAttribute('disabled',true);
    pergunta.addEventListener('blur',function(){
        if(campoVazio(this.value)){ // Se o campo for vazio, torna o botão de envio inacessível
            this.style.borderBottomColor = 'rgb(244,3,3)';
            botaoEnvio.setAttribute('disabled',true);
        }else{ // Caso contrário, torna o botão de envio acessível
            if(!campoVazio(tituloPesquisa.value)){
                this.style.borderBottomColor = 'rgb(3,244,3)';
                botaoEnvio.removeAttribute('disabled');
            }
        }
    });

    pergunta.addEventListener('keydown',function(e){
        if((this.value.length + 1) * 8 > 200){
            this.style.width = ((this.value.length + 1) * 8) + 'px';
        } 
    });

    //Configura o CSS da pergunta
    pergunta.style.minWidth = '200px';
    pergunta.style.maxWidth = '95%';
    pergunta.style.paddingLeft = '3px';
    pergunta.style.fontWeight = 'bold';
    pergunta.style.borderRight = "none";
    pergunta.style.borderTop = "none";
    pergunta.style.borderLeft = "none";
    pergunta.placeholder = "Insira o título da pergunta";
    pergunta.style.marginTop = "4px";

    return pergunta;
}

//Configura o checkbox que indica se a pergunta tem resposta obrigatória
function configuraObrigacao(){
    var checkbox = document.createElement('input');
    var tipo = document.createAttribute('type');
    tipo.value = "checkbox";
    var classe = document.createAttribute('class');
    classe.value = "icheckbox_flat";

    checkbox.setAttributeNode(tipo);
    
    checkbox.addEventListener('click',function(){
        if(this.checked){
            this.parentElement.setAttribute('obrigatorio',true);
        }else{
            this.parentElement.setAttribute('obrigatorio',false);
        }
    });

    return checkbox;
}

//Este método cria a DIV da opção
function addOpcao(guia){
    var divOpcao = document.createElement('div');
    var espaco = document.createTextNode(' ');

    var opcao = configuraOpcao();
    var icone = configuraIconeRemover();

    divOpcao.appendChild(opcao);
    divOpcao.appendChild(espaco);
    divOpcao.appendChild(icone);
    
    guia.parentNode.parentNode.insertBefore(divOpcao,guia.parentNode);
}

// Configura o conteúdo da opção da pergunta
function configuraOpcao(){
    var opcao = document.createElement('input');
    opcao.setAttribute('class','opcao');
    var isEditable = document.createAttribute('contenteditable');
    isEditable.value = true;

    opcao.addEventListener('blur',function(){
        if((this.value.length)==0 || campoVazio(this.value)){
            this.style.borderBottomColor = 'rgb(244,3,3)';
            botaoEnvio.setAttribute('disabled',true);
        }else{
            if(!campoVazio(tituloPesquisa.value) && !campoVazio(descricaoPesquisa.value)){
                this.style.borderBottomColor = 'rgb(3,244,3)';
                botaoEnvio.removeAttribute('disabled');
            }
        }
    });

    opcao.addEventListener('keydown',function(){
        if((this.value.length + 1) * 8 > 200){
            this.style.width = ((this.value.length + 1) * 8) + 'px';
        } 
    });

    //Configura o CSS da pergunta
    opcao.setAttributeNode(isEditable);
    opcao.style.fontWeight = 'medium';
    opcao.style.borderRight = "none";
    opcao.style.borderTop = "none";
    opcao.style.borderLeft = "none";
    opcao.placeholder = "Insira a opção aqui";
    opcao.style.marginTop = "4px";

    return opcao;
}

/* Enviar para o servidor */

function enviar(){

    var json = prepararJSON();
    var ajax = new XMLHttpRequest();
    var idPesquisa = document.getElementById('tituloPesquisa').getAttribute('idPesquisa');
    // var endereco = '/'+window.location.pathname.split('/')[1]+'/pesquisa/buscar/'+idPesquisa; // Varia, depende do objeto a ser removido
    var endereco = '/'+window.location.pathname.split('/')[1]+'/pesquisa/alterar/';
    ajax.open("POST",endereco,true);
    ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    ajax.send('idPesquisa='+idPesquisa+'&'+'json='+json);

    ajax.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            if(JSON.parse(this.response).success == true){
               window.location.href = '/'+window.location.pathname.split('/')[1]+'/pesquisa/';
            }else{
                document.getElementById('descricaoErro').innerHTML = JSON.parse(this.response).erro;
                $('#modalError').modal('show'); //Executa outra ação
            }
        }
    }

}
    //Prepara o JSON a ser enviado para o servidor
function prepararJSON(){
    var JSONCompleto = "{";

    var tituloPesquisa = document.getElementsByName('tituloPesquisa')[0].value;
    var descricaoPesquisa = document.getElementsByName('descricaoPesquisa')[0].value;
    
    JSONCompleto += '"tituloPesquisa":"'+tituloPesquisa+'","descricaoPesquisa":"'+descricaoPesquisa+'"';
    
    var listaPerguntas = document.getElementsByName('Pergunta');
    for(var i=0;i<listaPerguntas.length;i++){
        var tipoPergunta = listaPerguntas[i].getAttribute('tipo');
        
        var idPergunta = listaPerguntas[i].getAttribute('idPergunta');
        idPergunta = (idPergunta != null)? idPergunta:'nulo';
        var obrigatorio = listaPerguntas[i].getAttribute('obrigatorio');
        var tituloPergunta = listaPerguntas[i].childNodes[0].value;

        if(obrigatorio == null){
            obrigatorio = "false";
        }
        var tituloOpcoes = [];
        let opcoes = listaPerguntas[i].querySelectorAll('.opcao');

        for(var j=0; j < opcoes.length;j++){
            let idOpcao = opcoes[j].getAttribute('idOpcao');
            idOpcao = (idOpcao != null) ? idOpcao:"nulo";
            let titulo = opcoes[j].value;
            let valor = '{"idOpcao":"'+idOpcao+'","titulo":"'+titulo+'"}';
            tituloOpcoes.push(valor);
        }

        var pergunta;
        var chave = "Pergunta"+i;
        if(tipoPergunta != 'ABERTA'){
            pergunta = ',"'+chave+'":[{"idPergunta":"'+idPergunta+'","tituloPergunta":"'+tituloPergunta+'","tipoPergunta":"'+tipoPergunta+'","obrigatorio":"'+obrigatorio+'","opcoes":['+tituloOpcoes+']}]';
        }else{
            pergunta = ',"'+chave+'":[{"idPergunta":"'+idPergunta+'","tituloPergunta":"'+tituloPergunta+'","tipoPergunta":"'+tipoPergunta+'","obrigatorio":"'+obrigatorio+'"}]';
        }
        JSONCompleto += pergunta; 
    }
    JSONCompleto += '}';
    console.log(JSONCompleto);
    return JSONCompleto;
}


});

