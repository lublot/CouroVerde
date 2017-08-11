var pagAtual = 1;

$(document).ready(function () {    
    if(pagAtual == 1) {
        carregarPag();
    }

    $(".btn-mais").click(function () {
        pagAtual++;
        carregarPag();
    });

    var carregarPag = function() {
        alert('aaaaaaaaaaa');        
        var contImgs = 1;

        while(contImgs < 9) {
            alert("#img".concat(contImgs).concat("_").concat(pagAtual));
            $("#img".concat(contImgs).concat("_").concat(pagAtual)).prop('hidden', false);
            contImgs++;
        }

    }


});