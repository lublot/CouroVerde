window.addEventListener('load',function(){


var busca = document.getElementById('campoBusca');
busca.addEventListener('keyup',function(){
    listarNoticias();
});


listarNoticias(); // É executado para alimentar as informações da página
function listarNoticias(){

    var ajax = new XMLHttpRequest();
        var endereco = '/'+window.location.pathname.split('/')[1]+'/noticias/listarTodasNoticias'; // Varia, depende do objeto a ser removido
        
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
                    campoResposta.innerHTML = "<h5>Não foi encontrada nenhuma notícia</h5>"
                }
            }
        }

}
function criarBox(dados){
    var caixa = document.createElement('div');
    caixa.setAttribute('class','caixa-funcionario col-lg-4 col-md-4 col-sm-4 col-xs-6');
    var link = configurarLink(dados);
    var icone = document.createElement('i');
    icone.setAttribute('class','fa fa-newspaper-o fa-3x');
    icone.setAttribute('aria-hidden','true');  
    var info = configurarInfo(dados);

    link.appendChild(icone);
    link.appendChild(info);
    caixa.appendChild(link);

    return caixa;  
}

function configurarLink(dados){
    var link = document.createElement('a');
    let url = window.location.href;
    if(url.substr(-1) != '/'){
        url = url+'/gerenciar/'+dados.idNoticia;
    }else{
        url = url+'gerenciar/'+dados.idNoticia
    }
    link.setAttribute('href',url);
    link.setAttribute('class','text-center');
    return link;
}
function configurarInfo(dados){
    var info = document.createElement('div');
    info.appendChild(document.createElement("h5").appendChild(document.createTextNode("Titulo: "+dados.titulo)));
    info.appendChild(document.createElement('br'));
    info.appendChild(document.createElement("h6").appendChild(document.createTextNode("ID: "+dados.idNoticia)));
    return info;
}

//Verifica se o cmapo é vazio
function campoVazio(texto){
    return texto.replace(/\s/g, "").length == 0;
}
});