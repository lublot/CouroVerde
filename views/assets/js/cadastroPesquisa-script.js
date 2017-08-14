window.addEventListener('load',function(){

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
            tipoSelecionado = campos[i].getAttribute('tipo');
            if(tipoSelecionado == 'Aberta'){
                tipoSelecionado = "ABERTA";
            }else if(tipoSelecionado == 'Múltipla Escolha'){
                tipoSelecionado = "MULTIPLA ESCOLHA";
            }else if(tipoSelecionado == 'Única Escolha'){
                tipoSelecionado = "UNICA ESCOLHA";
            }
            addPergunta(tipoSelecionado);
        }
    }
});


var tituloPesquisa = document.getElementById('tituloPesquisa'); // Seleciona o título da pesquisa
var descricaoPesquisa = document.getElementById('descricaoPesquisa'); // Seleciona o título da descrição


var botaoEnvio = document.getElementById('botaoEnvio');
botaoEnvio.addEventListener('click',function(){
    if(!campoVazio(tituloPesquisa.value)){
        var msg = prepararJSON();

        var ajax = new XMLHttpRequest();
        var endereco = '/'+window.location.pathname.split('/')[1]+'/pesquisa/criar'; // Varia, depende do objeto a ser removido

        ajax.open("POST",endereco,true);
        ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        ajax.send('json='+msg);

        ajax.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                if(JSON.parse(this.response).success == true){
                    window.location.href = '/'+window.location.pathname.split('/')[1]+'/pesquisa/';
                }else{
                    document.getElementById('descricaoErro').innerHTML = JSON.parse(this.response).erro;
                    $('#modalError').modal('show');
                }
            }
        } 
    }else{
        document.getElementById('descricaoErro').innerHTML = "Por favor, insira um título para a pesquisa.";
        $('#modalError').modal('show');
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

    //Adiciona os elementos ao DOM
    divPergunta.appendChild(pergunta);
    divPergunta.appendChild(espaco);
    divPergunta.appendChild(icone);
    divPergunta.appendChild(quebraLinha);
    divPergunta.appendChild(obrigatorio);
    divPergunta.appendChild(titulo);
    
    //Verifica se a pergunta é fechada
    if(tipo != 'ABERTA'){
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

//Configura o ícone/botão de remoção
function configuraIconeRemover(){
    var icone = document.createElement('span');
    var classe = document.createAttribute('class');
    var ariahidden = document.createAttribute('aria-hidden');
    ariahidden.value = true;
    classe.value = 'fa fa-minus-circle fa-lg';

    icone.style.color = "red";
    icone.style.cursor = 'pointer';
    icone.setAttributeNode(classe);
    icone.setAttributeNode(ariahidden);
    
    icone.addEventListener('click',function(){
        this.parentNode.parentNode.removeChild(this.parentNode) // Remove o pai do elemento atual
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


//Este método cria a DIV da opção
function addOpcao(guia){
    var divOpcao = document.createElement('div');
    var espaco = document.createTextNode(' ');

    var name = document.createAttribute('class');
    name.value = "opcao";
    divOpcao.setAttributeNode(name);

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

//Prepara o JSON a ser enviado para o servidor
function prepararJSON(){
    var JSONCompleto = "{";

    var tituloPesquisa = document.getElementsByName('tituloPesquisa')[0].value;
    var descricaoPesquisa = document.getElementsByName('descricaoPesquisa')[0].value;
    
    JSONCompleto += '"tituloPesquisa":"'+tituloPesquisa+'","descricaoPesquisa":"'+descricaoPesquisa+'"';
    
    var listaPerguntas = document.getElementsByName('Pergunta');
    for(var i=0;i<listaPerguntas.length;i++){
        var tipoPergunta = listaPerguntas[i].getAttribute('tipo');
        var pergunta;
        var obrigatorio = listaPerguntas[i].getAttribute('obrigatorio');
        var tituloPergunta = listaPerguntas[i].childNodes[0].value;

        if(obrigatorio == null){
            obrigatorio = "false";
        }
        var tituloOpcoes = [];
        let opcoes = listaPerguntas[i].querySelectorAll('.opcao');
        
        for(var j=0; j < opcoes.length;j++){
            tituloOpcoes.push('"'+opcoes[j].childNodes[0].value+'"');
        }
        var chave = "Pergunta"+i;
        if(tipoPergunta != 'ABERTA'){
            pergunta = ',"'+chave+'":[{"tituloPergunta":"'+tituloPergunta+'","tipoPergunta":"'+tipoPergunta+'","obrigatorio":"'+obrigatorio+'","opcoes":['+tituloOpcoes+']}]';
        }else{
            pergunta = ',"'+chave+'":[{"tituloPergunta":"'+tituloPergunta+'","tipoPergunta":"'+tipoPergunta+'","obrigatorio":"'+obrigatorio+'"}]';
        }
        JSONCompleto += pergunta; 
    }
    JSONCompleto += '}';
    
    return JSONCompleto;
}

//Verifica se o campo é vazio
function campoVazio(texto){
    return texto.replace(/\s/g, "").length == 0;
}
});