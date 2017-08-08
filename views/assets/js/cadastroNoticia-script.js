function atualizarPagina(){
    window.location.reload();
}

function verificarImagem(){
    var extensoesOk = ",.jpg,.jpeg,.png,.gif,";
    var extensao	= "," + document.formCad.imagem.value.substr( document.form.logomarca.value.length - 4 ).toLowerCase() + ",";
    if (document.form.logomarca.value == ""){
        alert("O campo do endereço da imagem está vazio!!");
        document.formCad.imagem.reload();
    }
    if( extensoesOk.indexOf( extensao ) == -1 ){
        alert( document.form.logomarca.value + "\nNão possui uma extensão válida" );
        document.formCad.imagem.reload();
    }
}