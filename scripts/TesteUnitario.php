<?php 

include('MemoriaRam.php');

/**
* 
*/
class TesteUnitario
{
	
	private $MemoriaRam;

	function __construct()
	{
		self::testaMemoriaRam();
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
}

new TesteUnitario();
?>