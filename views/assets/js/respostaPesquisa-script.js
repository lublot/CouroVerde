window.addEventListener('load',function(){

carregar();

function carregar(){
    var ajax = new XMLHttpRequest();
    
    // var endereco = '/'+window.location.pathname.split('/')[1]+'/pesquisa/buscar/'+idPesquisa; // Varia, depende do objeto a ser removido
    var endereco = '/'+window.location.pathname.split('/')[1]+'/pesquisa/buscarAtiva/';
    

    ajax.open("POST",endereco,true);
    ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    ajax.send();

    ajax.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            
            if(Object.keys(JSON.parse(this.response)).length >= 3){
                var mensagem = JSON.parse(this.responseText);
                carregarPesquisa(mensagem);
            }else{
                document.getElementById('#descricaoErro').innerText = JSON.parse(this.response).erro;
                $('#modalWarning').modal('show');
            }
        }
    }
}

function carregarPesquisa(pesquisa){

    var form = document.getElementById('pesquisa');
    var idPesquisa = pesquisa.idPesquisa;
    var descricaoPesquisa = pesquisa.descricaoPesquisa;
    var tituloPesquisa = pesquisa.tituloPesquisa;
    var botaoEnvio = document.createElement('button');
    form.appendChild(configuraTituloPesquisa(idPesquisa,tituloPesquisa));
    
    delete pesquisa.descricaoPesquisa;
    delete pesquisa.idPesquisa;
    delete pesquisa.tituloPesquisa;

    
    Object.keys(pesquisa).forEach(function(k,i){
        if(pesquisa[i].Pergunta.tipo == 'ABERTA'){
            form.appendChild(configuraPerguntaAberta(pesquisa[i].Pergunta));
        }else if(pesquisa[i].Pergunta.tipo == 'MULTIPLA ESCOLHA'){
            form.appendChild(configuraPerguntaMultiplaEscolha(pesquisa[i].Pergunta,pesquisa[i].Opcao));
        }else if(pesquisa[i].Pergunta.tipo == 'UNICA ESCOLHA'){
            form.appendChild(configuraPerguntaUnicaEscolha(pesquisa[i].Pergunta,pesquisa[i].Opcao));
        }
    });

    botaoEnvio.setAttribute('class','btn btn-primary');
    botaoEnvio.setAttribute('type','button');
    botaoEnvio.setAttribute('id','botaoEnvio');

    form.appendChild(document.createElement('br'));
    form.appendChild(document.createTextNode('(*) Respostas Obrigatórias'));
    form.appendChild(document.createElement('br'));
    form.appendChild(document.createElement('br'));

    botaoEnvio.addEventListener('click',function(){

        if(verificarCamposPreenchidos()){
            var ajax = new XMLHttpRequest();
            var envio = prepararJson();
            var endereco = '/'+window.location.pathname.split('/')[1]+'/pesquisa/guardarResposta/';
            

            ajax.open("POST",endereco,true);
            ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            ajax.send('json='+envio+'&idPesquisa='+idPesquisa);

            ajax.onreadystatechange = function(){
                if (this.readyState == 4 && this.status == 200) {
                    
                    if(JSON.parse(this.response).success == true){
                        window.location.href = '/'+window.location.pathname.split('/')[1]+'/';
                    }else{
                        document.getElementById('#descricaoErro').innerText = JSON.parse(this.response).erro;
                        $('#modalWarning').modal('show');
                    }
                }
            }
            
        }else{
            document.getElementById('descricaoErro').innerText = "Por favor, responda à todas as perguntas obrigatórias.";
            $('#modalWarning').modal('show');
        }

        
        
    });

    botaoEnvio.appendChild(document.createTextNode('Enviar Resposta'));

    form.appendChild(botaoEnvio);
    
}

function configuraTituloPesquisa(idPesquisa,titulo){

    var divTitulo = document.createElement('div'); //Cria a div do título
    divTitulo.setAttribute('class','panel-heading');//Configura a classe da div
    divTitulo.setAttribute('idPesquisa',idPesquisa);
    var h3 = document.createElement('h3');//Cria um elemento H3
    h3.appendChild(document.createTextNode(titulo.toString()));//Adiciona o título ao H3
    divTitulo.appendChild(h3);//Adiciona o H3 à Div
    
    return divTitulo;
}

function configuraTituloPergunta(pergunta){
    var h4 = document.createElement('h4');//Cria um h4
    
    if(pergunta.opcional == 1){//Verifica se a pergunta é opcional, se não for, adiciona um asterisco na string
        h4.appendChild(document.createTextNode(pergunta.titulo));
    }else{ 
        h4.appendChild(document.createTextNode(pergunta.titulo+"*")); 
    }

    return h4;
}


function configuraPerguntaAberta(pergunta){

    var divPergunta = document.createElement('div');//Cria uma div
    var h4 = configuraTituloPergunta(pergunta);//Cria um h4
    var input = document.createElement('input');//Cria um input

    divPergunta.setAttribute('idpergunta',pergunta.idPergunta);
    divPergunta.setAttribute('class','perguntaAberta');//Define a classe da div
    input.setAttribute('type','text');//Define o tipo do input
    input.setAttribute('class','form-control');//Define a classe do input
    
    if(pergunta.opcional == 1){     
        divPergunta.setAttribute('class','perguntaAberta');
    }else{
        divPergunta.setAttribute('class','perguntaAberta obrigatorio');
    }

    divPergunta.appendChild(h4);
    divPergunta.appendChild(input);    
    return divPergunta;
}

function configuraPerguntaMultiplaEscolha(pergunta,opcoes){
    
    var divPergunta = document.createElement('div');//Cria uma div
    var h4 = configuraTituloPergunta(pergunta)//Cria um h4

    divPergunta.setAttribute('idpergunta',pergunta.idPergunta);
    divPergunta.appendChild(h4);

    if(pergunta.opcional == 1){
        divPergunta.setAttribute('class','perguntaMultiplaEscolha');
    }else{
        divPergunta.setAttribute('class','perguntaMultiplaEscolha obrigatorio');//Define a classe da div
    }


    Object.keys(opcoes).forEach(function(k,i){
        var input = document.createElement('input');//Cria um input
        input.setAttribute('type','checkbox');//Define o tipo do input
        input.setAttribute('class','icheckbox_flat');//Define a classe do input
        input.setAttribute('name',pergunta.titulo+'[]');
        input.setAttribute('value',opcoes[i].descricao);
        input.setAttribute('idopcao',opcoes[i].idOpcao);
        divPergunta.appendChild(input);
        let texto = opcoes[i].descricao;
        let span = document.createElement('span');
        span.appendChild(document.createTextNode(' '+texto));
        span.style.fontSize = '13pt';
        span.style.verticalAlign = 'middle';
        divPergunta.appendChild(span);
        divPergunta.appendChild(document.createElement('br'));
    });    

    return divPergunta;
}

function configuraPerguntaUnicaEscolha(pergunta,opcoes){
    
    var divPergunta = document.createElement('div');//Cria uma div
    var h4 = configuraTituloPergunta(pergunta)//Cria um h4
    var input = document.createElement('input');//Cria um input

    divPergunta.setAttribute('idpergunta',pergunta.idPergunta);
    divPergunta.appendChild(h4);
    
    if(pergunta.opcional == 1){
        divPergunta.setAttribute('class','perguntaUnicaEscolha');
    }else{
        divPergunta.setAttribute('class','perguntaUnicaEscolha obrigatorio');//Define a classe da div
    }
    
    Object.keys(opcoes).forEach(function(k,i){
        var input = document.createElement('input');//Cria um input
        input.setAttribute('type','radio');//Define o tipo do input
        input.setAttribute('class','iradio_flat');//Define a classe do input
        input.setAttribute('name',pergunta.titulo);
        input.setAttribute('value',opcoes[i].descricao);
        input.setAttribute('idopcao',opcoes[i].idOpcao);
        divPergunta.appendChild(input);
        let texto = opcoes[i].descricao;
        let span = document.createElement('span');
        span.appendChild(document.createTextNode(' '+texto));
        span.style.fontSize = '13pt';
        span.style.verticalAlign = 'middle';
        divPergunta.appendChild(span);
        divPergunta.appendChild(document.createElement('br'));
    });    

    return divPergunta;
}

//Verifica se o cmapo é vazio
function campoVazio(texto){
    return texto.replace(/\s/g, "").length == 0;
}

function prepararJson(){

    var jsonCompleto ='[';
    var perguntasAbertas = document.getElementsByClassName('perguntaAberta');
    for(let i=0;i<perguntasAbertas.length;i++){
        let idPergunta = perguntasAbertas[i].getAttribute('idpergunta');
        let tituloPergunta = perguntasAbertas[i].querySelector('h4').innerText;
        let respostaPergunta = perguntasAbertas[i].querySelector('input').value;
        jsonCompleto +='[{"tituloPergunta":'+'"'+tituloPergunta+'","respostaPergunta":'+'"'+respostaPergunta+'","idPergunta":'+'"'+idPergunta+'","tipoPergunta":"ABERTA"}],';
    }

    var perguntasMultiplaEscolha = document.getElementsByClassName('perguntaMultiplaEscolha');
    for(let i=0;i<perguntasMultiplaEscolha.length;i++){
        let idPergunta = perguntasMultiplaEscolha[i].getAttribute('idpergunta');
        let tituloPergunta = perguntasMultiplaEscolha[i].querySelector('h4').innerText;
        let perguntas = perguntasMultiplaEscolha[i].querySelectorAll('.icheckbox_flat');
        var opcoesSelecionadas = [];
        for(let j=0;j<perguntas.length;j++){
                if(perguntas[j].checked){
                    opcoesSelecionadas.push('"'+perguntas[j].getAttribute('idOpcao')+'"');
                }
            
        }
        jsonCompleto +='[{"tituloPergunta":'+'"'+tituloPergunta+'"'+',"idPergunta":'+'"'+idPergunta+'","opcoesSelecionadas":['+opcoesSelecionadas+'],"tipoPergunta":"MULTIPLA ESCOLHA"}],';
    }

    var perguntasUnicaEscolha = document.getElementsByClassName('perguntaUnicaEscolha');
    for(let i=0;i<perguntasUnicaEscolha.length;i++){
        let idPergunta = perguntasUnicaEscolha[i].getAttribute('idpergunta');
        let tituloPergunta = perguntasUnicaEscolha[i].querySelector('h4').innerText;
        let perguntas = perguntasUnicaEscolha[i].querySelectorAll('.iradio_flat');
        var opcaoSelecionada;
        for(let j=0;j<perguntas.length;j++){
                if(perguntas[j].checked){
                    opcaoSelecionada = perguntas[j].getAttribute('idopcao');
                }
            
        }
        jsonCompleto +='[{"tituloPergunta":'+'"'+tituloPergunta+'"'+',"idPergunta":'+'"'+idPergunta+'","opcaoSelecionada":"'+opcaoSelecionada+'","tipoPergunta":"UNICA ESCOLHA"}],';
    }

    jsonCompleto = jsonCompleto.substring(0,jsonCompleto.length-1)+']';//Retira a vírgula do fim e concatena a chave do fim do json.
    return jsonCompleto;
}


//Este método verifica se os dados obrigatórios da pesquisa foram respondidas.
function verificarCamposPreenchidos(){

    //Este bloco verifica se as perguntas de múltipla escolha obrigatórias foram respondidas
    var perguntasMultiplaEscolhaObrigatorias = document.getElementsByClassName('perguntaMultiplaEscolha obrigatorio');
    var qtdMarcados = 0;
    if(perguntasMultiplaEscolhaObrigatorias.length == 0){
        qtdMarcados++;
    }
    for(let i=0;i<perguntasMultiplaEscolhaObrigatorias.length;i++){
        let perguntas = perguntasMultiplaEscolhaObrigatorias[i].querySelectorAll('.icheckbox_flat');
        for(let j=0;j<perguntas.length;j++){
                if(perguntas[j].checked){
                qtdMarcados++;
            }
            
        }
    }
    console.log(qtdMarcados);
    if(qtdMarcados == 0){
        return false;
    }

    //Este bloco verifica se as perguntas de única escolha obrigatórias foram respondidas
    qtdMarcados = 0;
    var perguntasUnicaEscolhaObrigatorias = document.getElementsByClassName('perguntaUnicaEscolha obrigatorio');
    if(perguntasUnicaEscolhaObrigatorias.length == 0){
        qtdMarcados++;
    }
    for(let i=0;i<perguntasUnicaEscolhaObrigatorias.length;i++){
        let perguntas = perguntasUnicaEscolhaObrigatorias[i].querySelectorAll('.iradio_flat');
        for(let j=0;j<perguntas.length;j++){
            if(perguntas[j].checked){
                qtdMarcados++;
            }
        }
    }
    
    if(qtdMarcados == 0){
        return false;
    }

    //Este bloco verifica se as perguntas abertas obrigatórias foram respondidas
    qtdMarcados = 0;
    var perguntasAbertasObrigatorias = document.getElementsByClassName('perguntaAberta obrigatorio');
    if(perguntasAbertasObrigatorias.length == 0){
        qtdMarcados++;
    }
    for(let i=0;i<perguntasAbertasObrigatorias.length;i++){
        let perguntas = perguntasAbertasObrigatorias[i].querySelector('input');
            if(!campoVazio(perguntas.value)){
                qtdMarcados++;
            }
        
    }
    
    if(qtdMarcados == 0){
        return false;
    }

    return true;
}

});