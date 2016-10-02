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
		// lê arquivo e grava em $conteudo
		$this->EntradaSaida->lerArquivo();
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

		// envia o comando para a CPU processar
		$processamento = $this->CPU->processaComando($comando);

		// Grava o valor retornado na memoria Ram
		$this->MemoriaRam->memoria = $this->CPU->memoria;

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
				print_r($this->MemoriaRam->memoria);
				$this->CPU->defineCI($this->linhaAtual);
				$this->CPU->memoria = $this->MemoriaRam->memoria;
				break;
			}
		}
		self::processaComandoNaCpu($comando);
	}

}

new Barramento();
?>