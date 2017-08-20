
<div class="panel">
<div class="panel-heading text-center">
  <h4 class="panel-title">
    <a data-toggle="collapse" id="obras" data-parent="#accordion2" href="#submenu-obra" class="collapsed" onclick="selecionar(obras)">
      <img src="../views/assets/glyphicons_free/glyphicons/png/glyphicons-12-camera.png" height="14px" length="14px"/>
        Obras
    </a>
    <div id="submenu-obra" class="panel-collapse collapse">
        <div class="panel-body">
            <a href=<?php echo ROOT_URL.'obra/cadastro' ?> class="link" style="color: rgb(67, 74, 84)">• Cadastrar Obra</a><br><br>
            <a href=<?php echo ROOT_URL.'obra/gerenciar' ?> class="link" style="color: rgb(67, 74, 84)">• Gerenciar Obras</a>
            
        </div>
    </div>
  </h4>
  <br>
  <h4 class="panel-title">
    <a data-toggle="collapse" data-parent="#accordion2" href="#submenu-noticias" class="collapsed">
    <img src="../views/assets/glyphicons_free/glyphicons/png/glyphicons-530-list-alt.png" height="14px" length="14px"/>            
      Notícias
    </a>
    <div id="submenu-noticias" class="panel-collapse collapse">
        <div class="panel-body">
            <a href=<?php echo ROOT_URL.'noticias/cadastrar' ?> class="link" style="color: rgb(67, 74, 84)">• Cadastrar Notícia</a><br><br>
            <a href=<?php echo ROOT_URL.'noticias/' ?> class="link" style="color: rgb(67, 74, 84)">• Gerenciar Notícias</a>
        </div>
    </div>
  </h4>
  <br>
  <h4 class="panel-title">
    <a data-toggle="collapse"  data-parent="#accordion2" href="#submenu-funcionario" class="collapsed">
      <img src="../views/assets/glyphicons_free/glyphicons/png/glyphicons-344-thumbs-up.png" height="14px" length="14px"/>      
      Pesquisas
    </a>
    <div id="submenu-funcionario" class="panel-collapse collapse ">
        <div class="panel-body">
            <a href=<?php echo ROOT_URL.'pesquisa/cadastrar'?> class="link" style="color: rgb(67, 74, 84)">• Criar Pesquisa</a><br><br>
            <a href=<?php echo ROOT_URL.'pesquisa/' ?> class="link" style="color: rgb(67, 74, 84)">• Gerenciar Pesquisas</a>
        </div>
    </div>
  </h4>
  <br>
  <h4 class="panel-title">
    <a data-toggle="collapse" data-parent="#accordion2" href="#submenu-relatorios" class="collapsed">
      <img src="../views/assets/glyphicons_free/glyphicons/png/glyphicons-111-align-left.png" height="14px" length="14px"/>            
      Relatórios
    </a>
    <div id="submenu-relatorios" class="panel-collapse collapse">
        <div class="panel-body">
            <a href="#" class="link" >• Relatório de Acesso</a><br><br>
            <a href="<?php echo ROOT_URL.'relatorios/sistema'?>" class="link" style="color: rgb(67, 74, 84)" style="color: rgb(67, 74, 84)">• Relatórios do Sistema</a>
        </div>
    </div>
  </h4>
  <br>
  <h4 class="panel-title">
    <a data-toggle="collapse" data-parent="#accordion2" href="#submenu-funcionarios" class="collapsed">
      <img src="../views/assets/glyphicons_free/glyphicons/png/glyphicons-4-user.png" height="14px" length="14px"/>            
      Funcionários
    </a>
    <div id="submenu-funcionarios" class="panel-collapse collapse">
        <div class="panel-body">
            <a href=<?php echo ROOT_URL.'funcionario/cadastrar'?> class="link" style="color: rgb(67, 74, 84)">• Cadastrar Funcionário</a><br><br>
            <a href=<?php echo ROOT_URL.'funcionario/'?> class="link" style="color: rgb(67, 74, 84)">• Gerenciar Funcionários</a>
        </div>
    </div>
  </h4>
  <br>
  <h4 class="panel-title">
    <a data-toggle="collapse" data-parent="#accordion2" href="#submenu-backup" class="collapsed">
      <img src="../views/assets/glyphicons_free/glyphicons/png/glyphicons-444-floppy-disk.png" height="14px" length="14px"/>
      Backup
    </a>
    <div id="submenu-backup" class="panel-collapse collapse">
        <div class="panel-body">
            <a href=<?php echo ROOT_URL.'backup/'?> class="link" style="color: rgb(67, 74, 84)">• Realizar Backup</a><br><br>
        </div>
    </div>
  </h4>
</div>
</div>
