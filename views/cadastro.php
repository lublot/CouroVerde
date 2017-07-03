<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta name="description" content="Setour" />
	<meta name=viewport content="width=device-width, initial-scale=1, user-scalable=no" />
	<title>Cadastro</title>

	<link rel="stylesheet" href=<?php $this->path('assets/css/bootstrap-theme.css');?>>
	<link rel="stylesheet" href=<?php $this->path('assets/css/estilo.css');?>>
	<link rel="stylesheet" href=<?php $this->path('assets/css/bootstrap-social.css');?>>
	<link rel="stylesheet" href=<?php $this->path('assets/css/datepicker.css');?>>
	<link rel="stylesheet" href=<?php $this->path('assets/css/bootstrap.css');?>>
	<link rel="stylesheet" href=<?php $this->path('assets/css/site.css');?>>
	<link rel="stylesheet" href=<?php $this->path('assets/css/site.min.css');?>>

	<script src=<?php $this->path('assets/js/jquery-3.2.1.min.js');?>></script>
	<script src=<?php $this->path('assets/js/bootstrap-datepicker.js');?>></script>
	<script src=<?php $this->path('assets/js/moment.js');?>></script>
	<script src=<?php $this->path('assets/js/cadastro-script.js');?>></script>
	<!--<script>
		$(function () {
			$('.datepicker').datepicker({
				format: 'dd/mm/yyyy',
			});
		});
	</script>-->
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<h2>Inscreva-se. É simples! </h2>
				<form method="POST">
					<div class="row">
						<div class="form-group col-xs-6">
							<label for="nome">Nome</label>
							<input type="text" class="form-control" id="nome" name="nome"required />
						</div>

						<div class="form-group col-xs-6">
							<label for="sobrenome">Sobrenome</label>
							<input type="text" class="form-control" id="sobrenome" name="sobrenome"required />
						</div>
					</div>

					<div class="row">
						<div class="form-group col-xs-12">
							<label for="email">Email</label>
							<input type="email" class="form-control" id="email" name="email" required/>
						</div>
					</div>

					<div class="row">
						<div class="form-group col-xs-12">
							<label for="senha">Senha</label>
							<input type="password" class="form-control" id="senha" name="senha" required/>
						</div>
					</div>

					<!--<div class="row">
						<div class="form-group">
							<label for="date">Aniversário</label>
							<input class="datepicker" type="text" id="date" name="dataNascimento" required>
						</div>
					</div>-->
					
					<!--ESSE TRECHO AQUI VAI MOSTRAR UMA EXCEPTION DO BACK-END TU VÊ ONDE COLOCA AÍ-->
					<?php if(isset($this->dados['exception']) && !empty($this->dados['exception'])){
							echo $this->dados['exception'];
						  }
					?>
					<div class="row">
						<div class="form-group">
							<button type="submit" class="btn btn-default btn-md center">Cadastrar</button>
						</div>
					</div>	
				</form>
			</div>
		</div>
	</div>

</body>

</html>