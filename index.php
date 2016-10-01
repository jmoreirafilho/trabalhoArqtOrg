<?php 

include('scripts/EntradaSaida.php');
include('scripts/MemoriaRam.php');
include('scripts/CPU.php');

class Barramento {
	private $EntradaSaida;
	private $MemoriaRam;
	private $CPU;

	public $linhaAtual = 0;

	function __construct()
	{
		// chama classe EntradaSaida
		$this->EntradaSaida = new EntradaSaida();
		// chama classe MemoriaRam
		$this->MemoriaRam = new MemoriaRam();
		// chama classe CPU
		$this->CPU = new CPU();
		
		if(count($this->EntradaSaida->conteudo) > 0){
			self::enviaBufferParaRam();
		}
	}

	/**
	 * Recebe um comando e envia para a CPU, fica esperando ser processado. Quando
	 * for processado, passa para a próxima linha do codigo ASM e enviaBuffer da nova linha
	 * 
	 * @param Array $comando Comando trazido direto do buffer.
	*/
	public function processaComandoNaCpu($comando)
	{

		// envia o comando para a CPU processar, retornando um valor
		// que deverá ser armazenado no buffer
		$processamento = $this->CPU->processaComando($comando);

		// Grava o valor retornado na memoria Ram

		// Passa para a próxima linha do código
		$this->linhaAtual++;
	}

	/**
	 * Chama as classes EntradaSaida e MemoriaRam e pega o comando em Buffer,
	 * de acordo com a linhaAtual. Joga esse comando na MemoriaRam e fica esperando
	 * o comando ser gravado na memória, quando for gravado envia pra cpu.
	*/
	public function enviaBufferParaRam()
	{
		// pega o comando
		$comando = $this->EntradaSaida->buffer($this->linhaAtual);

		// joga o comando na RAM
		$this->MemoriaRam->recebeComando($comando);

		// Fica perguntando se o comando foi gravado na memória
		while(true){
			if($this->MemoriaRam->gravouNaMemoria){
				break;
			}
		}
		self::processaComandoNaCpu($comando);
	}

}

new Barramento();
?>