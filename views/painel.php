
<div class="panel">
<div class="panel-heading text-center">
  <h4 class="panel-title">
    <a data-toggle="collapse" id="obras" data-parent="#accordion2" href="#submenu-obra" class="collapsed" onclick="selecionar(obras)">
      <span class="glyphicon glyphicon-camera"></span> Obras
    </a>
    <div id="submenu-obra" class="panel-collapse collapse">
        <div class="panel-body">
            <a href=<?php echo ROOT_URL.'obra/cadastrar' ?> class="link">• Cadastrar Obra</a><br><br>
            <a href=<?php echo ROOT_URL.'obra/' ?> class="link">• Gerenciar Obras</a>
            
        </div>
    </div>
  </h4>
  <br>
  <h4 class="panel-title">
    <a data-toggle="collapse" data-parent="#accordion2" href="#submenu-noticias" class="collapsed">
      <span class="glyphicon glyphicon-list-alt"></span> Notícias
    </a>
    <div id="submenu-noticias" class="panel-collapse collapse">
        <div class="panel-body">
            <a href=<?php echo ROOT_URL.'noticia/cadastrar' ?> class="link">• Cadastrar Notícia</a><br><br>
            <a href=<?php echo ROOT_URL.'noticia/' ?> class="link">• Gerenciar Notícias</a>
        </div>
    </div>
  </h4>
  <br>
  <h4 class="panel-title">
    <a data-toggle="collapse"  data-parent="#accordion2" href="#submenu-funcionario" class="collapsed">
      <span class="glyphicon glyphicon-thumbs-up"></span> Pesquisas
    </a>
    <div id="submenu-funcionario" class="panel-collapse collapse ">
        <div class="panel-body">
            <a href=<?php echo ROOT_URL.'pesquisa/cadastrar'?> class="link" >• Criar Pesquisa</a><br><br>
            <a href=<?php echo ROOT_URL.'pesquisa/' ?> class="link" >• Gerenciar Pesquisas</a>
        </div>
    </div>
  </h4>
  <br>
  <h4 class="panel-title">
    <a data-toggle="collapse" data-parent="#accordion2" href="#submenu-relatorios" class="collapsed">
      <span class="glyphicon glyphicon-align-left"></span> Relatórios
    </a>
    <div id="submenu-relatorios" class="panel-collapse collapse">
        <div class="panel-body">
            <a href="#" class="link" >• Relatório de Acesso</a><br><br>
            <a href="#" class="link" >• Relatórios do Sistema</a>
        </div>
    </div>
  </h4>
  <br>
  <h4 class="panel-title">
    <a data-toggle="collapse" data-parent="#accordion2" href="#submenu-funcionarios" class="collapsed">
      <span class="glyphicon glyphicon-user"></span> Funcionários
    </a>
    <div id="submenu-funcionarios" class="panel-collapse collapse">
        <div class="panel-body">
            <a href=<?php echo ROOT_URL.'funcionario/cadastrar'?> class="link" >• Cadastrar Funcionário</a><br><br>
            <a href=<?php echo ROOT_URL.'funcionario/'?> class="link" >• Gerenciar Funcionários</a>
        </div>
    </div>
  </h4>
  <br>
  <h4 class="panel-title">
    <a data-toggle="collapse" data-parent="#accordion2" href="#submenu-backup" class="collapsed">
      <span class="glyphicon glyphicon-floppy-disk"></span> Backup
    </a>
    <div id="submenu-backup" class="panel-collapse collapse">
        <div class="panel-body">
            <a href="#" class="link">• Realizar Backup</a><br><br>
        </div>
    </div>
  </h4>
</div>
</div>
