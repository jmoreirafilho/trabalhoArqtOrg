<?php 

class EntradaSaida 
{
	/**
	 * DICIONARIO
	 * 1 = MOV
	 * 2 = ADD
	 * 3 = IMUL
	 * 4 = INC
	 * -1 = NULL
	 * -2 = A
	 * -3 = B
	 * -4 = C
	 * -5 = D
	*/

	public $conteudo = [];

	/**
	 * Chama o metodo para ler o arquivo
	*/
	function __construct()
	{
		self::lerArquivo();
	}

	/**
	 * Valida o conteudo recebido através de regex e converte os valores, adicionando
	 * no array de conteudo
	 * 
	 * @param string $conteudo Linha do código ASM para ser validada.
	 * @return Retorna um Array, caso não haja erro, retorna true, caso haja, retorna false e o numero da linha
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

	/**
	 * Pega arquivo, quebra as linhas em um array e chama a função para validar
	 * a sintaxe. Exibe o erro, caso a validação falhe.
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

	/**
	 * Recebe um id e retorna o conteudo dessa linha.
	 * 
	 * @param int $linhaAtual Id da linha no array de conteudo.
	 * @return Conteudo na posição informada do array de conteudo.
	*/
	public function buffer($linhaAtual)
	{
		return $this->conteudo[$linhaAtual];
	}

}

?>