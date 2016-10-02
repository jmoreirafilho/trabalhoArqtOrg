<?php 

include('MemoriaRam.php');
include('CPU.php');
include('EntradaSaida.php');

/**
* 
*/
class TesteUnitario
{
	
	private $MemoriaRam;
	private $CPU;
	private $EntradaSaida;

	function __construct()
	{
		// self::testaMemoriaRam();
		// self::testaCPU();
		self::testaEntradaSaida();
	}

	/**
	 * Chama e testa todos os metodos da classe MemoriaRam
	*/
	public function testaMemoriaRam()
	{
		$this->MemoriaRam = new MemoriaRam();
		print_r($this->MemoriaRam->possuiEspacoNaMemoria());
		print_r($this->MemoriaRam->recebeComando([2,3,14,-1]));
	}

	/**
	 * Chama e testa todos os metodos da classe CPU
	*/
	public function testaCPU()
	{
		$this->CPU = new CPU();
		print_r($this->CPU->processaComandoAdd([2, -2, -3, -1]));
	}

	public function testaEntradaSaida()
	{
		$this->EntradaSaida = new EntradaSaida();
		$this->EntradaSaida->conversorSinstatico(["mov 0X01, 5"]);
		print_r($this->EntradaSaida->conteudo);
	}
}

new TesteUnitario();
?>