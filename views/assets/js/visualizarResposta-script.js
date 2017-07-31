window.addEventListener('load',function(){

carregar();
function carregar(){
    var ajax = new XMLHttpRequest();
    
    // var endereco = '/'+window.location.pathname.split('/')[1]+'/pesquisa/buscar/'+idPesquisa; // Varia, depende do objeto a ser removido
    var endereco = '/'+window.location.pathname.split('/')[1]+'/pesquisa/resgatarRespostas/';
    var idPesquisa = window.location.href.split('/').pop();

    ajax.open("POST",endereco,true);
    ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    ajax.send('idPesquisa='+idPesquisa);

    ajax.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            
            if(JSON.parse(this.response).erro != undefined){
              document.getElementById('descricaoErro').innerText = JSON.parse(this.response).erro;
              document.getElementById('alerta').innerText = JSON.parse(this.response).erro;
              $('#modalWarning').modal('show');
            }else if(JSON.parse(this.response).alerta != undefined){
              document.getElementById('alerta').innerText = JSON.parse(this.response).alerta;
            }else{
              var mensagem = JSON.parse(this.responseText);
              carregarTela(mensagem);
            }
        }
    }
}

function carregarTela(dados){
  var container = document.getElementById('pesquisa');

  var tituloPesquisa = carregarTituloPesquisa(dados.tituloPesquisa);
  delete dados.tituloPesquisa;

  container.appendChild(tituloPesquisa);

  Object.keys(dados).forEach(function(k,i) {
    Object.keys(dados[k]).forEach(function(j,p){
      
      if(dados[k] != undefined){
        if(dados[k][j].tipoPergunta != "ABERTA"){
          let c = dados[k];
          var campo = carregarRespostaFechada(c);
          container.appendChild(campo);
          let idContainer = campo.getAttribute('id');
          plotar(c,idContainer);
          delete dados[k];
        }else{
          let c = dados[k];
          container.appendChild(carregarRespostaAberta(c));
          delete dados[k];
        }
      }
    });
  });
  
}


function carregarTituloPesquisa(titulo){
  let div = document.createElement('div');

  let h3 = document.createElement('h3');
  h3.appendChild(document.createTextNode(titulo));
  div.appendChild(h3)
           
  return div;

}

function carregarRespostaAberta(dados){

  var containerExterno = document.createElement('div');
  var h4 = document.createElement('h4');
  var titulo;
  var containerInterno = document.createElement('div');
  containerInterno.setAttribute('class','panel');
  containerInterno.style = "overflow-y:scroll;max-height:30vh";

  Object.keys(dados).forEach(function (k,i){

    containerInterno.appendChild(configurarRespostaAberta(dados[k]));
    titulo = dados[k].tituloPergunta;
  });
  
  h4.appendChild(document.createTextNode(titulo));
  containerExterno.appendChild(h4);
  containerExterno.appendChild(containerInterno);

  return containerExterno;
  
}

function configurarRespostaAberta(dado){
  var label = document.createElement('div');
  label.setAttribute('class','panel-heading');
  label.style = "border-bottom-color:grey";

  label.innerText = dado.resposta;
  return label;
}

function carregarRespostaFechada(dados){
  var container = document.createElement('div');
  container.setAttribute('class','panel');
  var h4 = document.createElement('h4');
  h4.appendChild(document.createTextNode(dados[0].tituloPergunta));
  container.appendChild(h4);
  container.setAttribute('id','idPergunta'+dados[0].idPergunta);
  return container;
}

function plotar(dados,idContainer){

// margin
var margin = {top: 20, right: 20, bottom: 20, left: 20},
    width = 400 - margin.right - margin.left,
    height = 400 - margin.top - margin.bottom,
    radius = width/2;

// color range
var color = d3.scaleOrdinal()
    .range(["#BBDEFB", "#90CAF9", "#64B5F6", "#42A5F5", "#2196F3", "#1E88E5", "#1976D2"]);

// pie chart arc. Need to create arcs before generating pie
var arc = d3.arc()
    .outerRadius(radius - 10)
    .innerRadius(0);

// arc for the labels position
var labelArc = d3.arc()
    .outerRadius(radius - 70)
    .innerRadius(radius - 40);

// generate pie chart and donut chart
var pie = d3.pie()
    .sort(null)
    .value(function(d) { return d.qtdRespostas; });

// define the svg for pie chart

var svg = d3.select("#"+idContainer).append("svg")
    .attr("width", width)
    .attr("height", height)
    .append("g")
    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");
    

// import data 
//d3.json(JSON.parse('[{"count":"5","fruit":"banana"},{"count":"2","fruit":"jaca"}]'), function(error, data) {
  //if (error) throw error;
    var data = dados;
    
    // parse data
    data.forEach(function(d) {
        d.qtdRespostas = +d.qtdRespostas;
        d.resposta = d.resposta;
    })

  // "g element is a container used to group other SVG elements"
  var g = svg.selectAll(".arc")
      .data(pie(data))
    .enter().append("g")
      .attr("class", "arc");

  // append path 
  g.append("path")
      .attr("d", arc)
      .style("fill", function(d) { return color(d.data.resposta); })
    // transition 
    .transition()
      .ease(d3.easeLinear)
      .duration(1800)
      .attrTween("d", tweenPie);
        
  // append text
  g.append("text")
    .transition()
      .ease(d3.easeLinear)
      .duration(2000)
    .attr("transform", function(d) { return "translate(" + labelArc.centroid(d) + ")"; })
      .attr("dy", ".35em")
      .text(function(d) { return d.data.resposta });
    
// Helper function for animation of pie chart and donut chart
function tweenPie(b) {
  b.innerRadius = 0;
  var i = d3.interpolate({startAngle: 0, endAngle: 0}, b);
  return function(t) { return arc(i(t)); };
}

}
});