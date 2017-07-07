<!DOCTYPE html>
<html lang="pt-BR">

<head>
	<!--Codificação dos caracteres: UTF-8-->
	<meta charset="utf-8" />
	<!--Descrição da página: Sertour-->
	<meta name="description" content="Setour" />
	<!--Regulando a visão da tela para a largura relativa à tela utilizada-->
	<meta name=viewport content="width=device-width, initial-scale=1" />

	<title>Redefinição de Senha</title>

	<!--Importação do CSS do Bootstrap-->
	<?php $this->carregarDependencias(); ?>
	<script type="text/javascript" src=<?php $this->path('assets/js/pedidoRedefinicao-script.js');?>></script>

</head>

<body style="background-color: rgb(241, 242, 246);">

	<!--Container geral para inserir da página-->
	<div class="container">
    <?php ?>
		<!--Título da caixa-->
		<div id="titulo">
			<h4 class="text-center">Redefinição de Senha</h4>
 		</div>
		 <!--Fim do título da caixa-->

		<!--Div com o contorno e organização dos elementos no centro-->
		<div id="contorno">

			<div>
			<!--Section com os elementos agrupados no centro-->
			<section id="caixa">

				<span> Digite seu e-mail no campo abaixo para que possamos te enviar uma nova senha</span>
				<br>
                <br>
				<!--Formulário de envio do e-mail-->
				<form method="POST" id='form'>
					<!--Campo do formulário-->
					<fieldset>

						<!--Linha 1-->
						<div class="row">
							<!--Tamanho dos campos é definido pelo bootstrap. O campo deve ter 6 blocos de largura-->
							<div class="col-lg-6">
								<div class="form-group">
									<!--Text: Email-->
									<input class="form-control" type="email" name="email" placeholder="E-mail">
								</div>
							</div>
						</div>

					</fieldset>
					<!--Fim dos campos do formulário-->
				</form>
				<!--Fim do formulário-->


			</section>
			<!--Fim da seção com os campos do cadastro-->

				<div class="modal-footer" style="border-top: 0; margin-right: 15px;">
					<div class="form-group">
						<button type="reset" class="btn btn-default" id="btn-cancelar">Cancelar</button>
						<button type="submit" class="btn btn-success" id='btn-proximo'>Próximo</button>
					</div>
				</div>

			</div>
			
		</div>
		<!--Fim da div contorno-->
		
	</div>
	<!--Fim da div geral-->

	<!-- Footer -->
	<?php $this->carregarRodape();?>

</body>

</html>