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
		self::enviaBufferParaRam();
	}

	/**
	 * Chama as classes EntradaSaida e MemoriaRam e pega o comando em Buffer,
	 * de acordo com a linhaAtual
	*/
	public function enviaBufferParaRam()
	{
		// chama classe EntradaSaida
		$this->EntradaSaida = new EntradaSaida();
		// pega o comando
		$comando = $this->EntradaSaida->buffer($this->linhaAtual);

		// chama classe MemoriaRam
		$this->MemoriaRam = new MemoriaRam();
		// joga o comando na RAM
		$this->MemoriaRam->recebeComando($comando);

		// Passa para a próxima linha do código
		$this->linhaAtual++;
	}
}

new Barramento();
?>