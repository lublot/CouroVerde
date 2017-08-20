function atualizarPagina(){
    window.history.back();
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

function ativarBotao(){
    document.formCad.btnCadNoticia.disabled = false;
}

function submitenter(myfield,e){
    var keycode;
    if (window.event) keycode = window.event.keyCode;
    else if (e) keycode = e.which;
    else return true;

    if (keycode == 13){
        myfield.form.submit();
        return false;
    }
    else{
        return true;
    }
}