// Inteiro para armazenar a página atual do usuário
var pagAtual = 1;
// Inteiro para armazenar o número limite de páginas disponíveis
var pagMax = 5;

var uploadFeito = false;

$(document).ready(function () {
    var dropzone_img = document.getElementById('dropzone_img');
    var dropzone_3d = document.getElementById('dropzone_3d');

    var displayUploads = function (data) {
        var uploads = document.getElementById('uploads'),
            anchor,
            x;

        for (x = 0; x < data.length; x = x + 1) {
            anchor = document.createElement('a');
            anchor.href = data[x].file;
            anchor.innerText = data[x].name;

            uploads.appendChild(anchor);
        }
    }

    var upload = function (files) {
        var formData = new FormData(),
            xhr = new XMLHttpRequest(),
            x;

        if (files.length > 5) {
            alert('Apenas 5 imagens podem ser carregadas!');
            return;
        }

        for (x = 0; x < files.length; x = x + 1) {
            var re = /(\.jpg|\.jpeg|\.bmp|\.gif|\.png)$/i;
            if (!re.exec(files[x].name)) {
                alert("Apenas imagens dos formatos jpg, jpeg, bmp, gif e png podem ser carregadas!");
                return;
            }
        }

        for (x = 0; x < files.length; x = x + 1) {
            formData.append('file[]', files[x]);
        }

        xhr.onload = function () {
            var data = JSON.parse(this.responseText);

            displayUploads(data);
        }

        uploadFeito = true;

        //Altera o botão para o tipo submit, que serve para finalizar o form
        $("#btn-confirmar").attr('type', 'submit');

        $("#btn-confirmar").click(function () {
            if (pagAtual == 5) { //what the fuck
                $("#form-obra").submit(function (event) {
                    $(this).attr('action', '../obra/cadastrarObra');
                });

                xhr.open('post', 'upload.php?inv=' + document.getElementById("inventario").value);
                xhr.send(formData);
                uploadFeito = false;
            }
        });
    }

    // Dropzone Imagem

    dropzone_img.ondrop = function (e) {
        e.preventDefault();
        this.className = 'dropzone';
        upload(e.dataTransfer.files);
    };

    dropzone_img.ondragover = function () {
        this.className = 'dropzone dragover';
        dropzone_img.innerHTML = 'Solte suas imagens <span class="glyphicon glyphicon-camera"></span> aqui para carregá-las';
        return false;
    };

    dropzone_img.ondragleave = function () {
        this.className = 'dropzone';
        dropzone_img.innerHTML = 'Arraste suas imagens <span class="glyphicon glyphicon-camera"></span> aqui para carregá-las';
        return false;
    };

    //

    //Dropzone 3D

        dropzone_3d.ondrop = function (e) {
        e.preventDefault();
        this.className = 'dropzone';
        upload(e.dataTransfer.files);
    };

    dropzone_3d.ondragover = function () {
        this.className = 'dropzone dragover';
        dropzone_3d.innerHTML = 'Solte seus arquivos referentes ao modelo 3D <span class="glyphicon glyphicon-road"></span> aqui se desejar carregá-los também';
        return false;
    };

    dropzone_3d.ondragleave = function () {
        this.className = 'dropzone';
        dropzone_3d.innerHTML = 'Arraste seus arquivos referentes ao modelo 3D <span class="glyphicon glyphicon-road"></span> aqui se desejar carregá-los também';
        return false;
    };

    //
})

window.addEventListener("load", init, false);

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
        //Altera o botão para o tipo reset, que serve para cancelar o form
        document.getElementById('btn-cancelar').setAttribute('type', 'reset');
    }
}

// Função responsável para passar para a próxima página
function avancarPag() {
    // Caso o usuário esteja na última página do cadastro
    if (pagAtual == pagMax && !uploadFeito) {
        alert("Você deve carregar ao menos uma imagem!");
    }
    // Verifica se a página atual do usuário excedeu o número limite máximo de páginas
    if (pagAtual < pagMax) {
        // String para concatenar o ID da página do HTML com a variável que armazena a página atual
        var pageOld = "#page_" + pagAtual;
        // Atualiza a visualização da tela atual para "nenhum"
        $(pageOld).css("display", "none");
        console.log("Página atual antes:" + pagAtual);

        // Incrementa a variável para avançar a página
        pagAtual++;
        console.log("Página atual depois:" + pageNew);
        // String para concatenar o ID da página do HTML com a variável que armazena a próxima página
        var pageNew = "#page_" + pagAtual;
        //Caso esteja na última página e fotografia tenha sido selecionada como classificação
        if (pagAtual == 5 && document.getElementById('select-classificacao').value == "FOTOGRAFIA") {
            //Exibe a página especial de fotografias (Documentação Fotográfica)
            $("#page_6").fadeIn(750);
        }
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