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
	 * Verifica se possui espaço nos 16 primeiros bits da memoria.
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
	 * Avança posição da memória para o próximo grupo de 4 bits, dentro dos 16 primeiros.
	*/
	public function avancaPosicaoDaMemoria()
	{
		$this->posicaoDaMemoria += 4;

		if($this->posicaoDaMemoria == 16){
			$this->posicaoDaMemoria = 0;
		}
	}

	/**
	 * Pula para a próxima posição, dentro dos 16 primeiros bits. Setando os 4 bits
	 * desse grupo para -1 e seta a posição da memória para a posição esvaziada.
	*/
	public function esvaziaMemoria()
	{
		// seta posicao da memoria para a proxima disponivel
		self::avancaPosicaoDaMemoria();

		// esvazia o grupo dessa posição
		$this->memoria[$this->posicaoDaMemoria] = -1;
		$this->memoria[$this->posicaoDaMemoria + 1] = -1;
		$this->memoria[$this->posicaoDaMemoria + 2] = -1;
		$this->memoria[$this->posicaoDaMemoria + 3] = -1;
	}

	/**
	 * Recebe um comando e grava na memória, sem validações.
	 * 
	 * @param Array $comando Comando trazido direto do buffer.
	*/

	public function adicionaNaMemoria($comando)
	{
		// seta os comando na memoria atual, que deve estar vazia
		$this->memoria[$this->posicaoDaMemoria] = $comando[0];
		$this->memoria[$this->posicaoDaMemoria + 1] = $comando[1];
		$this->memoria[$this->posicaoDaMemoria + 2] = $comando[2];
		$this->memoria[$this->posicaoDaMemoria + 3] = $comando[3];

		// seta posicao da memoria para a proxima disponivel
		self::avancaPosicaoDaMemoria();

		// processa dados na CPU
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
		}
		self::adicionaNaMemoria($comando);
	}

}
	

?>