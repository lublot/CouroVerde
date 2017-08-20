var pagAtual = 1;
var numTotalImgs = 0;

$(document).ready(function () {
    if(pagAtual == 1) {
        if(!$("#img".concat(1).concat("_").concat(pagAtual+1)).length) {
            $(".btn-voltar").prop("hidden", true);
            $(".btn-mais").attr('style', "display: none;");      
        }
        carregarPag();
    }
    
    $(".btn-mais").click(function () {
        if(!$("#img".concat(1).concat("_").concat(pagAtual+2)).length) {
            pagAtual++;
            carregarPag();
            $(".btn-voltar").removeAttr("style");
            $(".btn-mais").attr('style', "display: none;");
        } else {
            pagAtual++;
            carregarPag();
        }

    });

    var numPags = numTotalImgs/8;
});

var carregarPag = function() {
    var contImgs = 1;

    while(contImgs < 9 && $("#img".concat(contImgs).concat("_").concat(pagAtual)).length) {
        $("#img".concat(contImgs).concat("_").concat(pagAtual)).prop('hidden', false);
        contImgs++;
        numTotalImgs++;
    }
}


// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0; // For Chrome, Safari and Opera 
    document.documentElement.scrollTop = 0; // For IE and Firefox
}