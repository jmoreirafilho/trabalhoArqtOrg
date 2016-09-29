<?php 

class MemoriaRam 
{
	public $posicaoDaMemoria = 0;
	public $memoria = [
		-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,
		-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1
	];

	function __construct()
	{
		// não faz nada
	}

	/**
	 * Verifica se possui espaço nos 16 primeiros bits da memoria
	 * 
	 * @return Retorna true se possuir espaço, false caso contrário.
	*/
	public function possuiEspacoNaMemoria()
	{
		for($i = 0; $i < 12; $i+=4){
			if($this->memoria[$i] == -1){
				return true;
			}
		}
		return false;
	}

	/**
	 * Percorre os primeiro 16 bits, em grupos de 4 em 4, procurando qual o primeiro
	 * valor ocupado. Remove esses 4 bits.
	*/
	public function esvaziaMemoria()
	{
		$posicao = $this->posicaoDaMemoria;
		$posicao += 4;

	}

	/**
	 * Recebe um comando e grava na memória, sem validações.
	 * 
	 * @param Array $comando Comando trazido direto do buffer.
	*/

	public function adicionaNaMemoria($comando)
	{
		# code...
	}

	/**
	 * Recebe um comando, valida e grava na memória ou retorna exceção.
	 * 
	 * @param Array $comando Comando trazido direto do buffer.
	 * @return Retorna true se tiver espaço, false caso contrário.
	*/
	public function recebeComando($comando)
	{
		if(!self::possuiEspacoNaMemoria()){
			self::esvaziaMemoria();
			return true;
		}
		self::adicionaNaMemoria($comando);
		return false;
	}

}
	

?>