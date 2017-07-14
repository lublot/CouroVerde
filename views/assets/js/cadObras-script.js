// Inteiro para armazenar a página atual do usuário
var pagAtual = 1;
// Inteiro para armazenar o número limite de páginas disponíveis
var pagMax = 5;

// Função responsável por atualizar a mensagem contida nos botões "Próximo" e "Retroceder" para "Confirmar" e "Cancelar" na ocasião adequada
function atualizarTextoBotao() {
    // Caso o usuário esteja na última página do cadastro
    if (pagAtual == pagMax) {
        //Atualiza o texto do botão direito para "Confirmar"
        $("#btn-confirmar").html('Confirmar');
    }
    //Caso contrário
    else {
        // Deixa o texto "Próximo"
        $("#btn-confirmar").html('Próximo');
    }
    //Caso o usuário não esteja na primeira página
    if (pagAtual > 1) {
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

//Função responsável por cadastrar uma nova coleção na lista de coleções da página de Identificação do Objeto
function cadastroColecao() {
    //Verificação para checar se a opção "Adicionar nova opção..." foi selecionada
    if (document.getElementById('select-colecao').value == "add-col") {
        //Pergunta o nome da nova coleção ao usuário e armazena numa variável novaColeção
        var novaColecao = prompt("Insira o nome da nova coleção para ser cadastrada");
        //Caso o usuário tenha deixado o campo vazio 
        if (novaColecao == null || novaColecao == "") {
            //Exibe uma mensagem informando o cancelamento
            alert("Cadastro cancelado pelo usuário");
        }
        //Caso contário
        else {
            //Cria um elemento HTML do tipo "option" e salva ele numa variável chamada opcao
            var opcao = document.createElement("option");
            //Atualiza o texto da opção para o nome da nova coleção informado pelo usuário
            opcao.text = novaColecao;
            //Salva a penúltima posição da lista numa variável
            ultimaPosicao = document.getElementById('select-colecao').length - 1;
            //Adiciona a nova opção na penúltima opção da lista
            document.getElementById('select-colecao').add(opcao, ultimaPosicao);
            //Deixa selecionada automaticamente a nova opção que o usuário acabou de cadastrar
            document.getElementById('select-colecao').selectedIndex = ultimaPosicao;
            //Informa ao usuário que a operação ocorreu com sucesso
            alert("Cadastro efetuado com sucesso!");
        }
    }
}

//Função responsável por cadastrar uma nova classificação na lista de classificações da página de Identificação do Objeto
function cadastroClassificacao() {
    //Verificação para checar se a opção "Adicionar nova opção..." foi selecionada
    if (document.getElementById('select-classificacao').value == "add-cla") {
        //Pergunta o nome da nova classificação ao usuário e armazena numa variável novaClassificacao
        var novaClassificacao = prompt("Insira o nome da nova classificação para ser cadastrada");
        //Caso o usuário tenha deixado o campo vazio 
        if (novaClassificacao == null || novaClassificacao == "") {
            //Exibe uma mensagem informando o cancelamento
            alert("Cadastro cancelado pelo usuário");
        }
        //Caso contário
        else {
            //Cria um elemento HTML do tipo "option" e salva ele numa variável chamada opcao
            var opcao = document.createElement("option");
            //Atualiza o texto da opção para o nome da nova classificação informado pelo usuário
            opcao.text = novaClassificacao;
            //Salva a penúltima posição da lista numa variável
            ultimaPosicao = document.getElementById('select-classificacao').length - 1;
            //Adiciona a nova opção na penúltima opção da lista
            document.getElementById('select-classificacao').add(opcao, ultimaPosicao);
            //Deixa selecionada automaticamente a nova opção que o usuário acabou de cadastrar
            document.getElementById('select-classificacao').selectedIndex = ultimaPosicao;
            //Informa ao usuário que a operação ocorreu com sucesso
            alert("Cadastro efetuado com sucesso!");
        }
    }
}