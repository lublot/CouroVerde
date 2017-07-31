window.addEventListener("load",function(){

    var btnRemover = document.getElementById("btn-remover");
    btnRemover.addEventListener("click",function(){
        var ajax = new XMLHttpRequest();
        var endereco = '/'+window.location.pathname.split('/')[1]+'/admin/removerFuncionario'; // Varia, depende do objeto a ser removido
        var senhaAdmin = document.getElementById('senhaAdmin').value;
        var idObjeto = document.getElementById('idObjeto').value;
        
        ajax.open("POST",endereco,true);
        ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        ajax.send('senhaAdmin='+senhaAdmin+'&'+'idObjeto='+idObjeto);

        ajax.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                if(this.responseText == 1){
                    alert("Usuario Removido Com Sucesso"); //Executa alguma ação
                }else{
                    alert("Erro ao remover"); //Executa outra ação
                }
            }
        }
    });

});