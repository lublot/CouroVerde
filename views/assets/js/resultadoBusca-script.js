window.addEventListener('load',function(){

var urlRaiz = window.location.origin+'/'+window.location.pathname.split('/')[1];
var p = 0;
var btnCarregar;

carregar();

function carregar(pagina=0,filtros=0){
    var ajax = new XMLHttpRequest();
    var busca = window.location.href.split('?').pop();
    var endereco = '/'+window.location.pathname.split('/')[1]+'/busca/pesquisar/?'+busca+'&p='+pagina;
    
    if(filtros == 'colecao'){
        endereco = '/'+window.location.pathname.split('/')[1]+'/busca/pesquisarColecao/?'+busca+'&p='+pagina;
    }else if(filtros == 'classificacao'){
        endereco = '/'+window.location.pathname.split('/')[1]+'/busca/pesquisarClassificacao/?'+busca+'&p='+pagina;
    }else if(filtros !=0){
        endereco = endereco+'&filtros='+filtros;
    }

    ajax.open("POST",endereco,true);
    ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    ajax.send();

    ajax.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            
            if(Object.keys(JSON.parse(this.response)).length > 0){
                var mensagem = JSON.parse(this.responseText);
                while (document.getElementById('pagina').firstChild) {
                    document.getElementById('pagina').removeChild(document.getElementById('pagina').firstChild);
                }
                Object.keys(mensagem).forEach(function(k,i){
                    document.getElementById('pagina').appendChild(criarBox(mensagem[k]));
                });

                document.getElementById('pagina').appendChild(criarBotao());
                
                btnCarregar = document.getElementById('carregarMais');
                btnCarregar.addEventListener('click',function(){
                    carregar(++p);
                });
            }else{
                if(pagina==0){
                    while (document.getElementById('pagina').firstChild) {
                        document.getElementById('pagina').removeChild(document.getElementById('pagina').firstChild);
                    }
                    let h4 = document.createElement('h4');
                    h4.appendChild(document.createTextNode('A busca não retornou resultados'));
                    document.getElementById('pagina').appendChild(h4);
                }else if(filtros != 0){
                    while (document.getElementById('pagina').firstChild) {
                        document.getElementById('pagina').removeChild(document.getElementById('pagina').firstChild);
                    }
                    let h4 = document.createElement('h4');
                    h4.appendChild(document.createTextNode('A busca não retornou resultados'));
                    document.getElementById('pagina').appendChild(h4);
                }else{
                    btnCarregar = document.getElementById('carregarMais');
                    btnCarregar.style.display = 'none';
                }
                
            }
        }
    }
}
function criarBox(dados){

    let link = document.createElement('a');
    link.setAttribute('href',urlRaiz+'/obra/visualizar/'+dados.numeroInventario);

    let row = document.createElement('div');
    row.setAttribute('class','row');

    let box = document.createElement('div');
    box.setAttribute('class','col-xs-6 col-md-3');

    let info = document.createElement('div');
    info.setAttribute('class','pull-left text-left');

    let titulo = document.createElement('h4');
    titulo.appendChild(document.createTextNode(dados.titulo));
    
    let descricao = document.createElement('h6');
    descricao.appendChild(document.createTextNode(dados.descricao));

    let thumbnail = document.createElement('div');
    thumbnail.setAttribute('class','thumbnail');

    let imagem = document.createElement('div');
    imagem.setAttribute('style',"height:80px;background:url("+dados.caminhoImagem1+");background-size:contain;background-repeat:no-repeat;background-position:center");
    
    thumbnail.appendChild(imagem);
    info.appendChild(titulo);
    info.appendChild(descricao);
    box.appendChild(thumbnail);
    row.appendChild(box);
    row.appendChild(info);
    link.appendChild(row);

    return link;
}

function criarBotao(){
    let botao = document.createElement('div');
    botao.setAttribute('class','row text-center');

    let btn = document.createElement('button');
    btn.setAttribute('id','carregarMais');
    btn.setAttribute('type','button');
    btn.setAttribute('class','btn btn-sm btn-danger');
    btn.appendChild(document.createTextNode('Carregar mais'));
    botao.appendChild(btn);

    return botao;
}

var autor = document.getElementById('autor');
autor.onclick = function(){
    carregar(p,'autor');
}

var tag = document.getElementById('tag');
tag.onclick = function(){
    carregar(p,'tag');
}

var titulo = document.getElementById('titulo');
titulo.onclick = function(){
    carregar(p,'titulo');
}

var classificacao = document.getElementById('classificacao');
classificacao.onclick = function(){
    carregar(p,'classificacao');
}

var colecao = document.getElementById('colecao');
colecao.onclick = function(){
    carregar(p,'colecao');
}
});