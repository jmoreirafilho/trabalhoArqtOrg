<?php 

include('scripts/EntradaSaida.php');
include('scripts/MemoriaRam.php');
include('scripts/CPU.php');

class Barramento {
	private $EntradaSaida;
	private $MemoriaRam;
	private $CPU;

	public $linhaAtual = 1;

	function __construct()
	{
		// Inicializa EntradaSaida para pegar o conteudo e "compilar"
		$this->EntradaSaida = new EntradaSaida();
		$this->MemoriaRam = new MemoriaRam();
		$this->CPU = new CPU();
		self::buffer();
	}

	function buffer()
	{
		$linha = $this->EntradaSaida->pegaLinha($linhaAtual);
		print_r($linha);
	}
	
}

new Barramento();
?>