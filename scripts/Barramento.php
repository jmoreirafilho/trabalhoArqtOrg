<?php 

namespace Barramento;

class Barramento {

	public $abertoParaRam;
	public $abertoParaCpu;
	public $abertoParaES;

	public $linhaAtual;
	public $tamanho = 5;
	public $frequencia;
	public $largura;

	public $comando = [];

	function __construct()
	{
		$this->abertoParaRam = false;
		$this->abertoParaCpu = false;
		$this->abertoParaES = false;

		self::habilitaParaES();
	}

	public function habilitaParaRam()
	{
		$this->abertoParaRam = true;
		$this->abertoParaCpu = false;
		$this->abertoParaES = false;
	}

	public function habilitaParaCpu()
	{
		$this->abertoParaRam = false;
		$this->abertoParaCpu = true;
		$this->abertoParaES = false;
	}

	public function habilitaParaES()
	{
		$this->abertoParaRam = false;
		$this->abertoParaCpu = false;
		$this->abertoParaES = true;
	}


	/**
	 * Pega tamanho da memória RAM, parametrizado
	 * @return int Tamanho da memória Ram
	 */
	public function pegaTamanho()
	{
		return $this->tamanho;
	}

	/**
	 * Define tamanho da memória Ram, parametrizado
	 * @param int $value 
	 */
	public function defineTamanho($value)
	{
		echo Barramento->tamanho;
		// Barramento\Barramento::tamanho = $value;
	}


	/**
	 * Pega a frequencia de comandos que passam pelo barramento, parametrizado
	 * @return int Frequencia de comandos que passam pelo barramento
	 */
	public function pegaFrequencia()
	{
		return $this->frequencia;
	}

	/**
	 * Define a frequencia de comandos que passam pelo barramento, parametrizado
	 * @param int $value
	 */
	public function defineFrequencia($value)
	{
		$this->frequencia = $value;
	}


	/**
	 * Pega a largura do barramento, parametrizada
	 * @return int Largura do barramento
	 */
	public function pegaLargura()
	{
		return $this->largura;
	}

	/**
	 * Dfine a largura do barramento, parametrizado
	 * @param int $value
	 */
	public function defineLargura($value)
	{
		$this->largura = $value;
	}


	/**
	 * Pega o comando no barramento, enviado pela EntradaSaida
	 * @return Array
	 */
	public function pegaComando()
	{
		return $this->comando;
	}

	/**
	 * Define o comando, enviado pela EntradaSaida
	 * @param Array $value 
	 */
	public function defineComando($value)
	{
		$this->comando = $value;
	}







	// OLD

	/**
	 * Recebe um comando e envia para a CPU, fica esperando ser processado. Quando
	 * for processado, passa para a próxima linha do codigo ASM e enviaBuffer da nova linha
	 * 
	 * @param Array $comando Comando trazido direto do buffer.
	*/
	public function processaComandoNaCpu($comando)
	{
		// define status de processado para false
		$this->CPU->processouComando = false;

		// envia o comando para a CPU processar
		$processamento = $this->CPU->processaComando($comando);

		// Fica perguntando se o comando ja foi processado
		while(true){
			// Grava o valor retornado na memoria Ram
			if($this->CPU->processouComando){
				$this->MemoriaRam->memoria = $this->CPU->memoria;
				break;
			}
		}

		// Passa para a próxima linha do código
		$this->linhaAtual++;

		// EXIBIR MEMORIA
		print_r($this->MemoriaRam->memoria);
		echo "<br />";

		// Envia próximo comando do buffer para a RAM
		self::enviaBufferParaRam();
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

		if($comando < 0){
			echo "Fim!";
			return;
		} else {
			// define status de gravação na memoria RAM para false
			$this->MemoriaRam->gravouNaMemoria = false;
			// joga o comando na RAM
			$this->MemoriaRam->recebeComando($comando);

			// Fica perguntando se o comando foi gravado na memória
			while(true){
				if($this->MemoriaRam->gravouNaMemoria){
					$this->CPU->defineCI($this->linhaAtual);
					$this->CPU->memoria = $this->MemoriaRam->memoria;
					break;
				}
			}
			self::processaComandoNaCpu($comando);
		}
	}

}
?>