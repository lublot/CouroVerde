window.addEventListener('load',function(){

carregar();
function carregar(){
    var ajax = new XMLHttpRequest();
    // var endereco = '/'+window.location.pathname.split('/')[1]+'/pesquisa/buscar/'+idPesquisa; // Varia, depende do objeto a ser removido
   var endereco = '/'+window.location.pathname.split('/')[1]+'/relatorioSistema/listarTodosRelatorios/';

    ajax.open("POST",endereco,true);
    ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    ajax.send();

    ajax.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {

            alert(this.response);

            if(Object.keys(JSON.parse(this.response)).length > 0){
                var mensagem = JSON.parse(this.responseText);
                document.getElementById('pagina').appendChild(criarTabela(mensagem));
                
            }else{
                document.getElementById('principal').style.visibility='hidden';//Executa outra ação
                document.getElementById('aviso').innerText = JSON.parse(this.response).erro;
                document.getElementById('alerta').style.display ='block';
            }
        }
    }
}

function criarTabela(dados){
    let tabela = document.createElement('table');
    tabela.setAttribute('class','table table-striped table-condensed');
    let linha = document.createElement('tr');
    let coluna1 = document.createElement('th');
    let coluna2 = document.createElement('th');
    let coluna3 = document.createElement('th');

    coluna1.appendChild(document.createTextNode('Nº de Matrícula'));
    coluna2.appendChild(document.createTextNode('Ação'));
    coluna3.appendChild(document.createTextNode('Horário'));
    linha.appendChild(coluna1);
    linha.appendChild(coluna2);
    linha.appendChild(coluna3);

    tabela.appendChild(linha);
    let body = document.createElement('tbody');
    Object.keys(dados).forEach(function(k,i){
        body.appendChild(criarLinha(dados[k]));
    });

    tabela.appendChild(body);
    return tabela;
}

function criarLinha(dados){
    let linha = document.createElement('tr');
    let coluna1 = document.createElement('td');
    let coluna2 = document.createElement('td');
    let coluna3 = document.createElement('td');
    
    let frase = dados.acao+' '+dados.tipoAlvo+' '+dados.nomeAlvo;
    coluna1.appendChild(document.createTextNode(dados.autor));
    coluna2.appendChild(document.createTextNode(frase));
    coluna3.appendChild(document.createTextNode(dados.horario));
    linha.appendChild(coluna1);
    linha.appendChild(coluna2);
    linha.appendChild(coluna3);

    return linha;
}
});