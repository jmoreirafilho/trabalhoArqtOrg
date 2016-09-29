<?php 

include('scripts/EntradaSaida.php');
include('scripts/MemoriaRam.php');
include('scripts/CPU.php');

class Barramento {
	private $EntradaSaida;
	private $MemoriaRam;
	private $CPU;
	private $Unit;

	public $linhaAtual = 0;

	function __construct()
	{
		// Inicializa EntradaSaida para pegar o conteudo e "compilar"
		$this->EntradaSaida = new EntradaSaida();
		$this->MemoriaRam = new MemoriaRam();
		$this->CPU = new CPU();
		self::enviaBufferParaRam();
	}

	public function enviaBufferParaRam()
	{
		// pega o comando
		$comando = $this->EntradaSaida->buffer($this->linhaAtual);

		// joga o comando na RAM
		$this->MemoriaRam->recebeComando($comando);
	}
}

new Barramento();
?>