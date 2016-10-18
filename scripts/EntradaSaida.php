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
		echo ">> ".Componente::$barramento->pegaTamanho()."<br />";
		Componente::$barramento->defineTamanho(30);
		echo ">> ".Componente::$barramento->tamanho."<br />";
		// echo Barramento\Barramento::setTamanho();
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
			if (preg_match("/^MOV\s+([ABCD])\s*,\s*(\d+)\s*$/i", strtoupper($linha), $acertos)) {
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
			else if (preg_match("/^MOV\s+0X0*(\w\w)\s*,\s*(\d+)\s*$/i", strtoupper($linha), $acertos)) {
				/*
				* MOV (posiçao da memoria), numero
				*/
				$numero = (hexdec($acertos[1]) + 16 + 5) * (-1);
				if($numero > 16){ // verifica se a posição informada é válida
					return [false, $i];
				}
				$i++;
				array_push($this->conteudo, [1, $numero, $acertos[2], -1]);
			}
			else if (preg_match("/^MOV\s+0X0*(\w\w)\s*,\s*([ABCD])\s*$/i", strtoupper($linha), $acertos)) {
				/*
				* MOV (posição da memoria), (registrador)
				*/

				if(hexdec($acertos[1]) > 16){ // verifica se a posição informada é válida
					return [false, $i];
				}

				$i++;

				$numero = (hexdec($acertos[1]) + 16 + 5) * (-1);
				switch(strtoupper($acertos[2])){
					case 'A':
						array_push($this->conteudo, [1, $numero, -2, -1]);
					break;
					case 'B':
						array_push($this->conteudo, [1, $numero, -3, -1]);
					break;
					case 'C':
						array_push($this->conteudo, [1, $numero, -4, -1]);
					break;
					case 'D': 
						array_push($this->conteudo, [1, $numero, -5, -1]);
					break;
				}
			}
			else if (preg_match("/^MOV\s+0X0*(\w\w)\s*,\s*0X0*(\w\w)\s*$/i", strtoupper($linha), $acertos)) {
				/*
				* MOV (posiçao da memoria), numero
				*/
				$numero1 = (hexdec($acertos[1]) + 16 + 5) * (-1);
				if($numero1 > 16){ // verifica se a posição informada é válida
					return [false, $i];
				}

				$numero2 = (hexdec($acertos[2]) + 16 + 5) * (-1);
				if($numero2 > 16){ // verifica se a posição informada é válida
					return [false, $i];
				}
				$i++;
				array_push($this->conteudo, [1, $numero1, $numero2, -1]);
			}
			else if (preg_match("/^MOV\s+0X0*(\w\w)\s*,\s*([ABCD])\s*$/i", strtoupper($linha), $acertos)) {
				/*
				* MOV (posição da memoria), (registrador)
				*/

				if(hexdec($acertos[1]) > 16){ // verifica se a posição informada é válida
					return [false, $i];
				}

				$i++;

				$numero = (hexdec($acertos[1]) + 16 + 5) * (-1);
				switch(strtoupper($acertos[2])){
					case 'A':
						array_push($this->conteudo, [1, $numero, -2, -1]);
					break;
					case 'B':
						array_push($this->conteudo, [1, $numero, -3, -1]);
					break;
					case 'C':
						array_push($this->conteudo, [1, $numero, -4, -1]);
					break;
					case 'D': 
						array_push($this->conteudo, [1, $numero, -5, -1]);
					break;
				}
			}
			else if (preg_match("/^MOV\s+([ABCD])\s*,\s*0X0*(\w\w)\s*$/i", strtoupper($linha), $acertos)) {
				/*
				* MOV (registrador), (posição da memoria)
				*/

				if(hexdec($acertos[2]) > 16){ // verifica se a posição informada é válida
					return [false, $i];
				}

				$i++;
				
				$numero = (hexdec($acertos[2]) + 16 + 5) * (-1);
				switch(strtoupper($acertos[1])){
					case 'A':
						array_push($this->conteudo, [1, -2, $numero, -1]);
					break;
					case 'B':
						array_push($this->conteudo, [1, -3, $numero, -1]);
					break;
					case 'C':
						array_push($this->conteudo, [1, -4, $numero, -1]);
					break;
					case 'D': 
						array_push($this->conteudo, [1, -5, $numero, -1]);
					break;
				}
			}
			else if (preg_match("/^MOV\s+([ABCD])\s*,\s*([ABCD])\s*$/i", strtoupper($linha), $acertos)) {
				/*
				* MOV (registrador), (posição da memoria)
				*/
				$numero;
				switch ($acertos[2]) {
					case 'A':
						$numero = -2;
					break;
					case 'B':
						$numero = -3;
					break;
					case 'C':
						$numero = -4;
					break;
					case 'D': 
						$numero = -5;
					break;
				}
				$i++;
				
				switch(strtoupper($acertos[1])){
					case 'A':
						array_push($this->conteudo, [1, -2, $numero, -1]);
					break;
					case 'B':
						array_push($this->conteudo, [1, -3, $numero, -1]);
					break;
					case 'C':
						array_push($this->conteudo, [1, -4, $numero, -1]);
					break;
					case 'D': 
						array_push($this->conteudo, [1, -5, $numero, -1]);
					break;
				}
			}
			else if (preg_match("/^ADD\s+([ABCD])\s*,\s*(\d+)\s*$/i", strtoupper($linha), $acertos)) {
				/*
				* ADD (registrador), (numero)
				*/
				$i++;
				
				switch(strtoupper($acertos[1])){
					case 'A':
						array_push($this->conteudo, [2, -2, $acertos[2], -1]);
					break;
					case 'B':
						array_push($this->conteudo, [2, -3, $acertos[2], -1]);
					break;
					case 'C':
						array_push($this->conteudo, [2, -4, $acertos[2], -1]);
					break;
					case 'D': 
						array_push($this->conteudo, [2, -5, $acertos[2], -1]);
					break;
				}
				continue;
			}
			else if (preg_match("/^ADD\s+(\d+)\s*,\s*(\d+)\s*$/i", strtoupper($linha), $acertos)) {
				/*
				* ADD (numero), (numero)
				*/
				$i++;
				
				array_push($this->conteudo, [2, $acertos[1], $acertos[2], -1]);
				continue;
			}
			else if (preg_match("/^ADD\s+0X0*(\w\w)\s*,\s*(\d+)\s*$/i", strtoupper($linha), $acertos)) {
				/*
				* ADD (posição da memoria), (numero)
				*/
				if(hexdec($acertos[1]) > 16){ // verifica se a posição informada é válida
					return [false, $i];
				}

				$i++;

				$numero = (hexdec($acertos[1]) + 16 + 5) * (-1);
				array_push($this->conteudo, [2, $numero, $acertos[2], -1]);
				continue;
			}
			else if (preg_match("/^ADD\s+0X0*(\w\w)\s*,\s*([ABCD])\s*$/i", strtoupper($linha), $acertos)) {
				/*
				* ADD (posição da memoria), (registrador)
				*/
				if(hexdec($acertos[1]) > 16){ // verifica se a posição informada é válida
					return [false, $i];
				}

				$i++;
				
				$numero = (hexdec($acertos[1]) + 16 + 5) * (-1);
				switch(strtoupper($acertos[2])){
					case 'A':
						array_push($this->conteudo, [2, $numero, -2, -1]);
					break;
					case 'B':
						array_push($this->conteudo, [2, $numero, -3, -1]);
					break;
					case 'C':
						array_push($this->conteudo, [2, $numero, -4, -1]);
					break;
					case 'D': 
						array_push($this->conteudo, [2, $numero, -5, -1]);
					break;
				}
				array_push($this->conteudo, [2, $acertos[1], $acertos[2], -1]);
				continue;
			}
			else if (preg_match("/^ADD\s+([ABCD])\s*,\s*0X0*(\w\w)\s*$/i", strtoupper($linha), $acertos)) {
				/*
				* ADD (registrador), (posição da memoria)
				*/
				if(hexdec($acertos[2]) > 16){ // verifica se a posição informada é válida
					return [false, $i];
				}

				$i++;
				
				$numero = (hexdec($acertos[2]) + 16 + 5) * (-1);
				switch(strtoupper($acertos[1])){
					case 'A':
						array_push($this->conteudo, [2, -2, $numero, -1]);
					break;
					case 'B':
						array_push($this->conteudo, [2, -3, $numero, -1]);
					break;
					case 'C':
						array_push($this->conteudo, [2, -4, $numero, -1]);
					break;
					case 'D': 
						array_push($this->conteudo, [2, -5, $numero, -1]);
					break;
				}
				continue;
			}
			else if (preg_match("/^IMUL\s+(\w+)\s*,\s*(\w+)\s*,\s*(\w+)\s*$/i", strtoupper($linha), $acertos)) {
				/*
				* IMUL (X), (Y), (Z)
				*/
				$pos1 = $acertos[1];
				if(substr($acertos[1], 0, 2) == "0X" && hexdec($acertos[1]) > 16){ // verifica se a posição informada é válida
					return [false, $i];
				} else if (substr($acertos[1], 0, 2) == "0X" && hexdec($acertos[1]) <= 16){
					if(preg_match("/0X0*(\w+)/i", strtoupper($acertos[1]), $acerto)){
						$pos1 = (hexdec($acerto[1]) + 16 + 5) * (-1);
					} else {
						return [false, $i];
					}
				} else if ($acertos[1] < 'A' || $acertos[1] < 'B' || $acertos[1] < 'C' || $acertos[1] < 'D'){
					switch ($acertos[1]) {
						case 'A':
							$pos1 = -2;
						break;
						case 'B':
							$pos1 = -3;
						break;
						case 'C':
							$pos1 = -4;
						break;
						case 'D': 
							$pos1 = -5;
						break;
					}
				}

				$pos2 = $acertos[2];
				if(substr($acertos[2], 0, 2) == "0X" && hexdec($acertos[2]) > 16){ // verifica se a posição informada é válida
					return [false, $i];
				} else if (substr($acertos[2], 0, 2) == "0X" && hexdec($acertos[2]) <= 16){
					$pos2 = (hexdec($acertos[2]) + 16 + 5) * (-1);
				} else if ($acertos[2] < 'A' || $acertos[2] < 'B' || $acertos[2] < 'C' || $acertos[2] < 'D'){
					switch ($acertos[2]) {
						case 'A':
							$pos2 = -2;
						break;
						case 'B':
							$pos2 = -3;
						break;
						case 'C':
							$pos2 = -4;
						break;
						case 'D': 
							$pos2 = -5;
						break;
					}
				}

				$pos3 = $acertos[3];
				if(substr($acertos[3], 0, 2) == "0X" && hexdec($acertos[3]) > 16){ // verifica se a posição informada é válida
					return [false, $i];
				} else if (substr($acertos[3], 0, 2) == "0X" && hexdec($acertos[3]) <= 16){
					$pos3 = (hexdec($acertos[3]) + 16 + 5) * (-1);
				} else if ($acertos[3] < 'A' || $acertos[3] < 'B' || $acertos[3] < 'C' || $acertos[3] < 'D'){
					switch ($acertos[3]) {
						case 'A':
							$pos3 = -2;
						break;
						case 'B':
							$pos3 = -3;
						break;
						case 'C':
							$pos3 = -4;
						break;
						case 'D': 
							$pos3 = -5;
						break;
					}
				}

				$i++;

				array_push($this->conteudo, [3, $pos1, $pos2, $pos3]);
				continue;
			}
			else if (preg_match("/^INC\s+0X0*(\w\w)\s*$/i", strtoupper($linha), $acertos)) { 
				/*
				* INC (posião na memória)
				*/
				$i++;
				array_push($this->conteudo, [4, $acertos[1], -1, -1]);
				continue;
			}
			else if (preg_match("/^INC\s+([ABCD])\s*$/i", strtoupper($linha), $acertos)) { 
				/*
				* INC (registrador)
				*/
				$i++;
				switch(strtoupper($acertos[1])){
					case 'A':
						array_push($this->conteudo, [4, -2, -1, -1]);
					break;
					case 'B':
						array_push($this->conteudo, [4, -3, -1, -1]);
					break;
					case 'C':
						array_push($this->conteudo, [4, -4, -1, -1]);
					break;
					case 'D': 
						array_push($this->conteudo, [4, -5, -1, -1]);
					break;
				}
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
	// function lerArquivo()
	// {
	// 	$local = "asm.txt";
	// 	$arquivo = fopen($local, 'r');
	// 	$conteudo = explode("\n", fread($arquivo, filesize($local)));
	// 	fclose($arquivo);
	// 	$analisador = self::conversorSinstatico($conteudo);
	// 	if(!$analisador[0]){
	// 		echo "Você possui erros em sua sintaxe. Linha: ".$analisador[1]." - <strong>".$conteudo[$analisador[1] - 1]."</strong>";
	// 		$this->conteudo = [];
	// 	}
	// }

	/**
	 * Recebe um id e retorna o conteudo dessa linha.
	 * 
	 * @param int $linhaAtual Id da linha no array de conteudo.
	 * @return Conteudo na posição informada do array de conteudo.
	*/
	// public function buffer($linhaAtual)
	// {
	// 	if($linhaAtual == (count($this->conteudo) - 1)){
	// 		return -1;
	// 	}
	// 	return $this->conteudo[$linhaAtual];
	// }

}

?>