window.addEventListener('load',function(){


    var btnAddPergunta = document.getElementById('addPergunta');
    btnAddPergunta.addEventListener('click',function(){
        $('#modal').modal('show');
    });

    var btnConfirmaAddPergunta = document.getElementById('confirmaAddPergunta');
    btnConfirmaAddPergunta.addEventListener('click',function(){
        var tipoSelecionado;
        var campos = document.getElementsByName('tipoPergunta');
        for(var i=0;i<campos.length;i++){
            if(campos[i].checked){
                tipoSelecionado = campos[i].value;
                addPergunta(tipoSelecionado);

            }
        }
    });


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

        divPergunta.setAttributeNode(classeDiv);
        divPergunta.setAttributeNode(tipoPergunta);
        divPergunta.setAttributeNode(name);
 
        var pergunta = configuraPergunta();
        var icone = configuraIconeRemover();
        var obrigatorio = configuraObrigacao();
        var titulo = document.createTextNode(' Resposta Obrigatória');

        divPergunta.appendChild(pergunta);
        divPergunta.appendChild(espaco);
        divPergunta.appendChild(icone);
        divPergunta.appendChild(quebraLinha);
        divPergunta.appendChild(obrigatorio);
        divPergunta.appendChild(titulo);
        
        if(tipo != 'Aberta'){
            divPergunta.appendChild(configuraBotaoCriarOpcao());
        }
        document.getElementById('guia-pergunta').parentNode.insertBefore(divPergunta,document.getElementById('guia-pergunta'));
    }

    function configuraPergunta(){
        var pergunta = document.createElement('input');
        
        var isEditable = document.createAttribute('contenteditable');
        isEditable.value = true;

        pergunta.setAttributeNode(isEditable);
        pergunta.style.fontWeight = 'bold';
        pergunta.style.borderRight = "none";
        pergunta.style.borderTop = "none";
        pergunta.style.borderLeft = "none";
        pergunta.placeholder = "Insira a opção aqui";
        pergunta.style.marginTop = "4px";

        return pergunta;
    }

    function configuraObrigacao(){
        var checkbox = document.createElement('input');
        
        var tipo = document.createAttribute('type');
        tipo.value = "checkbox";


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

    function configuraOpcao(){
        var opcao = document.createElement('input');
        var isEditable = document.createAttribute('contenteditable');
        isEditable.value = true;

        opcao.setAttributeNode(isEditable);
        opcao.style.fontWeight = 'medium';
        opcao.style.borderRight = "none";
        opcao.style.borderTop = "none";
        opcao.style.borderLeft = "none";
        opcao.placeholder = "Insira a opção aqui";
        opcao.style.marginTop = "4px";

        return opcao;
    }


    var botaoEnvio = document.getElementById('botaoEnvio');
    botaoEnvio.addEventListener('click',function(){
        var msg = prepararJSON();

        var ajax = new XMLHttpRequest();
        var endereco = '/'+window.location.pathname.split('/')[1]+'/pesquisa/criar'; // Varia, depende do objeto a ser removido


        ajax.open("POST",endereco,true);
        ajax.setRequestHeader('Content-Type', 'application/json');
        ajax.send('json='+msg);

        ajax.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                
            }
        }

        
    });

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
            if(tipoPergunta != 'Aberta'){
                pergunta = ',"'+chave+'":[{"tituloPergunta":"'+tituloPergunta+'","tipoPergunta":"'+tipoPergunta+'","obrigatorio":"'+obrigatorio+'","opcoes":['+tituloOpcoes+']}]';
            }else{
                pergunta = ',"'+chave+'":[{"tituloPergunta":"'+tituloPergunta+'","tipoPergunta":"'+tipoPergunta+'","obrigatorio":"'+obrigatorio+'"}]';
            }
            JSONCompleto += pergunta; 
        }
        JSONCompleto += '}';
        
        return JSONCompleto;
    }


    var form = document.getElementById('principal');
    form.addEventListener('click',function(){
        var tituloPesquisa = document.getElementsByName('tituloPesquisa')[0].value;
        var descricaoPesquisa = document.getElementsByName('descricaoPesquisa')[0].value;
        var listaPerguntas = document.getElementsByName('Pergunta');
        var botaoEnvio = document.getElementById('botaoEnvio');
        let opcoes = document.querySelectorAll('.opcao');
        if(!campoVazio(tituloPesquisa) && !campoVazio(descricaoPesquisa)){
            if(listaPerguntas.length > 0){
                botaoEnvio.removeAttribute('disabled');
            }else{
                botaoEnvio.setAttribute('disabled',true);
            }
        }
        
    });

    function campoVazio(texto){
        return texto.replace(/\s/g, "").length == 0;
    }
});