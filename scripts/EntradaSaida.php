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
		// não faz nada
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
			else if (preg_match("/^MOV\s+0X0(\w\w)\s*,\s*([ABCD])\s*$/i", strtoupper($linha), $acertos)) {
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
			else if (preg_match("/^MOV\s+([ABCD])\s*,\s*0X0(\w\w)\s*$/i", strtoupper($linha), $acertos)) {
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
			else if (preg_match("/^ADD\s+0X0(\w\w)\s*,\s*(\d+)\s*$/i", strtoupper($linha), $acertos)) {
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
			else if (preg_match("/^ADD\s+0X0(\w\w)\s*,\s*([ABCD])\s*$/i", strtoupper($linha), $acertos)) {
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
			else if (preg_match("/^ADD\s+([ABCD])\s*,\s*0X0(\w\w)\s*$/i", strtoupper($linha), $acertos)) {
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
			else if (preg_match("/^IMUL\s+0X0(\w\w)\s*,\s*(\d+),\s*(\d+)\s*$/i", strtoupper($linha), $acertos)) {
				/*
				* IMUL (posiçao na memoria), (numero), (numero)
				*/ 
				if(hexdec($acertos[1]) > 16){ // verifica se a posição informada é válida
					return [false, $i];
				}

				$i++;
				$numero = (hexdec($acertos[2]) + 16 + 5) * (-1);
				array_push($this->conteudo, [3, $numero, $acertos[2], $acertos[3]]);
				continue;
			}
			else if (preg_match("/^IMUL\s+(\d+)\s*,\s*(\d+),\s*(\d+)\s*$/i", strtoupper($linha), $acertos)) {
				/*
				* IMUL (registrador), (numero), (numero)
				*/ 
				$i++;
				array_push($this->conteudo, [3, $acertos[1], $acertos[2], -1]);
				continue;
			}
			else if (preg_match("/^INC\s+0X0(\w\w)\s*$/i", strtoupper($linha), $acertos)) { 
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