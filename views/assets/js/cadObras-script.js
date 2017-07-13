// Inteiro para armazenar a página atual do usuário
var pagAtual = 1;
// Inteiro para armazenar o número limite de páginas disponíveis
var pagMax = 5;

function atualizarTextoBotao() {
    if(pagAtual == pagMax) {
        $("#btn-confirmar").html('Confirmar');
    } 
    else {
        $("#btn-confirmar").html('Próximo');        
    }
    if(pagAtual > 1) {
        $("#btn-cancelar").html('Retroceder');
    }
    else {
        $("#btn-cancelar").html('Cancelar');
    }
}

// Função responsável para passar para a próxima página
function avancarPag() {
    console.log(pagAtual);
    // Verifica se a página atual do usuário excedeu o número limite máximo de páginas
    if (pagAtual < pagMax) {
        // String para concatenar o ID da página do HTML com a variável que armazena a página atual
        var pageOld = "#page_" + pagAtual;
        // Atualiza a visualização da tela atual para "nenhum"
        $(pageOld).css("display", "none");

        // Incrementa a variável para avançar a página
        pagAtual++;
        // String para concatenar o ID da página do HTML com a variável que armazena a próxima página
        var pageNew = "#page_" + pagAtual;
        // Atualiza a visualização da próxima tela para exibir com um Fade In
        $(pageNew).fadeIn(750);
    }
}

function voltarPag() {
    console.log(pagAtual);
    // Verifica se a página atual do usuário excedeu o número limite mínimo de páginas
    if (pagAtual > 1) {
        // String para concatenar o ID da página do HTML com a variável que armazena a página atual
        var pageOld = "#page_" + pagAtual;
        // Atualiza a visualização da tela atual para "nenhum"
        $(pageOld).css("display", "none");

        // Diminui a variável para retornar a página
        pagAtual--;
        // String para concatenar o ID da página do HTML com a variável que armazena a página anterior
        var pageNew = "#page_" + pagAtual;
        // Atualiza a visualização da tela anterior para exibir com um Fade In
        $(pageNew).fadeIn(750);
    }
}

