<?php 

class EntradaSaida 
{
	/*
		1 -> MOV
		2 -> ADD
		3 -> IMUL
		4 -> INC
		--------------
		-1 -> NULL
		-2 -> A
		-3 -> B
		-4 -> C
		-5 -> D
	*/


	public $conteudo = [];

	/*
		Inicia o leitor de arquivo
	*/
	function __construct()
	{
		self::lerArquivo();
	}

	/*
		Recebe o conteudo e valida a sintaxe para saber se tem algum erro
	*/
	function conversorSinstatico($conteudo)
	{
		$i = 1;
		foreach($conteudo AS $linha) {
			if (preg_match("/^mov\s+([ABCD])\s*,\s*(\d+)$/i", strtoupper($linha), $acertos)) {
				/*
				* MOV (registrador), numero
				*/
				$i++;
				switch(strtoupper($acertos[1])){
					case 'A':
						array_push($this->conteudo, [1, -2, $acertos[2], -1]);
					break;
					case 'B':
						array_push($this->conteudo, [1, -3, $acertos[2], -1]);
					break;
					case 'C':
						array_push($this->conteudo, [1, -4, $acertos[2], -1]);
					break;
					case 'D':
						array_push($this->conteudo, [1, -5, $acertos[2], -1]);
					break;
				}
				continue;
			}
			else if (preg_match("/^mov\s+0X0*(\w\w)\s*,\s*(\d+)$/i", strtoupper($linha), $acertos)) {
				/*
				* MOV (posiçao da memoria), numero
				*/
				$numero = hexdec($acertos[1]);
				if($numero > 16){ // verifica se a posição informada é válida
					return [false, $i];
				}
				array_push($this->conteudo, [1, hexdec($acertos[1]), $acertos[2], -1]);
			}
			else if (preg_match("/^mov\s+0X0(\w\w)\s*,\s*(\d+)$/i", strtoupper($linha), $acertos)) {
				/*
				* MOV (posição da memoria), (registrador)
				*/
				$numero = hexdec($acertos[1]);
				if($numero > 16){ // verifica se a posição informada é válida
					return [false, $i];
				}
				array_push($this->conteudo, [1, hexdec($acertos[1]), $acertos[2], -1]);
			}
			else if (preg_match("/^add\s+([ABCD])\s*,\s*(\d+)$/i", strtoupper($linha), $acertos)) {
				/*
				* ADD ([ABCD]]), (numero)
				*/
				$i++;
				array_push($this->conteudo, [2, $acertos[1], $acertos[2], -1]);
				continue;
			}
			else if (preg_match("/^add\s+(\d+)\s*,\s*(\d+)$/i", strtoupper($linha), $acertos)) {
				/*
				* ADD (numero), (numero)
				*/
				$i++;
				array_push($this->conteudo, [2, $acertos[1], $acertos[2], -1]);
				continue;
			}
			else if (preg_match("/^imul\s+(\d+)\s*,\s*(\d+),\s*(\d+)$/i", strtoupper($linha), $acertos)) {
				/*
				* IMUL (numero), (numero), (numero)
				*/ 
				$i++;
				array_push($this->conteudo, [3, $acertos[1], $acertos[2], -1]);
				continue;
			}
			else if (preg_match("/^inc\s+(\dX\d+)$/i", strtoupper($linha), $acertos)) { 
				/*
				* INC (posião na memória)
				*/
				$i++;
				array_push($this->conteudo, [3, $acertos[1], -1, -1]);
				continue;
			}
			else if (preg_match("/^inc\s+(\w)$/i", strtoupper($linha), $acertos)) { 
				/*
				* INC (registrador)
				*/
				$i++;
				array_push($this->conteudo, [3, $acertos[1], -1, -1]);
				continue;
			}
			else {
				return [false, $i];
			}
		}
		return [true];
	}

	/*
		Pega arquivo, quebra as linhas em um array e chama a função para validar a sintaxe
		Caso seja valido, grava na variavel global
		Caso não seja valido, exibe o erro
	*/
	function lerArquivo()
	{
		$local = "asm.txt";
		$arquivo = fopen($local, 'r');
		$conteudo = explode("\n", fread($arquivo, filesize($local)));
		fclose($arquivo);
		$analisador = self::conversorSinstatico($conteudo);
		if(!$analisador[0]){
			$this->conteudo = [];
			echo "Você possui erros em sua sintaxe. Linha: ".($analisador[1]);
		}
	}

	public function buffer($linhaAtual)
	{
		return $this->conteudo[$linhaAtual];
	}

}

?>