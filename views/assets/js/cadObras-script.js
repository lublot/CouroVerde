// Inteiro para armazenar a página atual do usuário
var pagAtual = 1;
// Inteiro para armazenar o número limite de páginas disponíveis
var pagMax = 5;

// Função responsável por atualizar a mensagem contida nos botões "Próximo" e "Retroceder" para "Confirmar" e "Cancelar" na ocasião adequada
function atualizarTextoBotao() {
    // Caso o usuário esteja na última página do cadastro
    if(pagAtual == pagMax) {
        //Atualiza o texto do botão direito para "Confirmar"
        $("#btn-confirmar").html('Confirmar');
    } 
    //Caso contrário
    else {
        // Deixa o texto "Próximo"
        $("#btn-confirmar").html('Próximo');        
    }
    //Caso o usuário não esteja na primeira página
    if(pagAtual > 1) {
        //Atualiza o texto do botão esquerdo para "Retroceder"
        $("#btn-cancelar").html('Retroceder');
    }
    //Caso contrário
    else {
        //Deixa o texto "Cancelar"
        $("#btn-cancelar").html('Cancelar');
    }
}

// Função responsável para passar para a próxima página
function avancarPag() {
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

