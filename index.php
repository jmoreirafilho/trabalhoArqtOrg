<html>
<meta charset="UTF-8">
	<head>
		<title>
			Setup Inicial
		</title>
		<link rel="stylesheet" href="styles/bootstrap.min.css">
		<link rel="stylesheet" href="styles/style.css">
	</head>
	<body>
		
		<div class="row top-bar">&emsp;</div>
		
		<div class="col-sm-10 col-sm-offset-1">
			
			<form action="scripts/inicio.php" method="post">
				<div class="panel panel-primary">
					<div class="panel-heading title">Tela de Parametrizações</div>
					<div class="panel-body">

						<div class="col-sm-4">
							<div class="form-group">
								<label for="largura">Largura do Barramento</label>
								<input name="largura" id="largura" type="text" class="form-control" placeholder="Informe apenas números inteiros" />
							</div>
						</div>

						<div class="col-sm-4">
							<div class="form-group">
								<label for="frequencia">Frequência</label>
								<input name="frequencia" id="frequencia" type="text" class="form-control" placeholder="Informe apenas números inteiros" />
							</div>
						</div>

						<div class="col-lg-4 col-sm-6">
							<div class="form-group">
								<label for="tamanho">Tamanho</label>
								<input name="tamanho" id="tamanho" type="text" class="form-control" placeholder="Informe apenas números inteiros" />
							</div>
						</div>

					</div>
					<div class="panel-footer align-right">
						<input type="submit" class="btn btn-primary" value="Salvar" />
						<input type="reset" class="btn btn-danger" value="Limpar" />
					</div>
				</div>
			</form>
		</div>
	
		<script src="styles/jquery.min.js"></script>
		<script src="styles/angular.min.js"></script>
	</body>
</html>