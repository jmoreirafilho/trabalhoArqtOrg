<?php 

class CPU extends MemoriaRam
{

	public $registradorA = -1;
	public $registradorB = -1;
	public $registradorC = -1;
	public $registradorD = -1;
	public $CI = -1;
	public $memoria = [];
	public $processouComando = false;
	
	function __construct()
	{
		// não faz nada
	}

	/**
	 * Define a instrução que está sendo executada.
	 * 
	 * @param int $instrucao Numero da instrução que esta sendo executada.
	 */
	public function defineCI($instrucao)
	{
		$this->CI = $instrucao;
	}

	/**
	 * Função padrão para pegar valor do Registrador A.
	 * 
	 * @return Retorna o valor do registrador A.
	 */
	public function pegaRegistradorA()
	{
		return $this->registradorA;
	}

	/**
	 * Função padrão para atribuir um valor ao registrador A.
	 * 
	 * @param int $valor Valor para atribuir ao registrador A.
	 */
	public function defineRegistradorA($valor)
	{
		$this->registradorA = $valor;
	}

	/**
	 * Função padrão para pegar valor do Registrador B.
	 * 
	 * @return Retorna o valor do registrador B.
	 */
	public function pegaRegistradorB()
	{
		return $this->registradorB;
	}

	/**
	 * Função padrão para atribuir um valor ao registrador B.
	 * 
	 * @param int $valor Valor para atribuir ao registrador B.
	 */
	public function defineRegistradorB($valor)
	{
		$this->registradorB = $valor;
	}

	/**
	 * Função padrão para pegar valor do Registrador C.
	 * 
	 * @return Retorna o valor do registrador C.
	 */
	public function pegaRegistradorC()
	{
		return $this->registradorC;
	}

	/**
	 * Função padrão para atribuir um valor ao registrador C.
	 * 
	 * @param int $valor Valor para atribuir ao registrador C.
	 */
	public function defineRegistradorC($valor)
	{
		$this->registradorC = $valor;
	}

	/**
	 * Função padrão para pegar valor do Registrador D.
	 * 
	 * @return Retorna o valor do registrador D.
	 */
	public function pegaRegistradorD()
	{
		return $this->registradorD;
	}

	/**
	 * Função padrão para atribuir um valor ao registrador D.
	 * 
	 * @param int $valor Valor para atribuir ao registrador D.
	 */
	public function defineRegistradorD($valor)
	{
		$this->registradorD = $valor;
	}

	/**
	 * Recebe uma posição de memória e busca na memória o valor dela.
	 * 
	 * @param int $posicao Posição na memória RAM.
	 * @return Valor cadastrado na posição da memória informado.
	 */
	public function pegaPosicaoMemoria($posicao)
	{
		return $this->memoria[$posicao];
	}

	/**
	 * Define o valor de determinada posição da memória.
	 * 
	 * @param int $posicao Posição que será inserido o valor na memória.
	 * @param int $valor Valor que será colocado na posição da memória.
	 */
	public function definePosicaoMemoria($posicao, $valor)
	{
		$this->memoria[$posicao] = $valor;
	}

	/**
	 * Processa quando comando for ADD.
	 * 
	 * @param Array $comando Comando vindo direto do Buffer.
	 */
	public function processaComandoAdd($comando)
	{
		$valor2 = $comando[2];
		if($valor2 < -1){
			switch ($valor2) {
				case '-2':
					$valor2 = self::pegaRegistradorA();
					break;
				case '-3':
					$valor2 = self::pegaRegistradorB();
					break;
				case '-4':
					$valor2 = self::pegaRegistradorC();
					break;
				case '-5':
					$valor2 = self::pegaRegistradorD();
					break;
				default:
					$valor2 = self::pegaPosicaoMemoria((($valor2 * -1) - 5));
					break;
			}
		}

		$valor1 = $comando[1];
		if($valor1 < -1){
			switch ($valor1) {
				case '-2':
					$valor1 = self::pegaRegistradorA();
					$valor = $valor1 + $valor2;
					self::defineRegistradorA($valor);
					break;

				case '-3':
					$valor1 = self::pegaRegistradorB();
					$valor = $valor1 + $valor2;
					self::defineRegistradorB($valor);
					break;

				case '-4':
					$valor1 = self::pegaRegistradorC();
					$valor = $valor1 + $valor2;
					self::defineRegistradorC($valor);
					break;

				case '-5':
					$valor1 = self::pegaRegistradorD();
					$valor = $valor1 + $valor2;
					self::defineRegistradorD($valor);
					break;
				default:
					$pos = ($valor2 * -1) - 5;
					$valor1 = self::pegaPosicaoMemoria($pos);
					$valor = $valor1 + $valor2;
					self::definePosicaoMemoria($pos, $valor);
					break;
			}
		}

		$this->processouComando = true;
		// Quando ele somar 2 numero, retorna???
		// return $valor1 + $valor2;

	}

	/**
	 * Processa quando comando for MOV
	 * 
	 * @param Array $comando Comando vindo direto do Buffer
	 */
	public function processaComandoMov($comando)
	{
		$valor2 = $comando[2];
		if($valor2 < -1){
			switch ($valor2) {
				case '-2':
					$valor2 = self::pegaRegistradorA();
					break;
				case '-3':
					$valor2 = self::pegaRegistradorB();
					break;
				case '-4':
					$valor2 = self::pegaRegistradorC();
					break;
				case '-5':
					$valor2 = self::pegaRegistradorD();
					break;
				default:
					$valor2 = self::pegaPosicaoMemoria((($valor2 * -1) - 5));
					break;
			}
		}

		$valor1 = $comando[1];
		switch ($valor1) {
			case '-2':
				self::defineRegistradorA($valor2);
				break;

			case '-3':
				self::defineRegistradorB($valor2);
				break;

			case '-4':
				self::defineRegistradorC($valor2);
				break;
			case '-5':
				self::defineRegistradorD($valor2);
				break;
			default:
				self::definePosicaoMemoria($pos, $valor2);
				break;
		}

		$this->processouComando = true;
	}

	/**
	 * Processa quando comando for IMUL
	 * 
	 * @param Array $comando Comando vindo direto do Buffer
	 */
	public function processaComandoImul($comando)
	{
		
	}

	/**
	 * Processa quando comando for INC
	 * 
	 * @param Array $comando Comando vindo direto do Buffer
	 */
	public function processaComandoInc($comando)
	{
		
	}

	/**
	 * Recebe um comando para ser processado, verifica qual o tipo de comando
	 * e chama o método para esse tipo verificado.
	 * 
	 * @param Array $comando Comando vindo direto do buffer
	 * @return type
	 */
	public function processaComando($comando)
	{
		switch ($comando[0]) {
			case 1:
				self::processaComandoMov($comando);
				break;
			case 2:
				self::processaComandoAdd($comando);
				break;
			case 3:
				self::processaComandoImul($comando);
				break;
			case 4:
				self::processaComandoInc($comando);
				break;
		}
	}
}
 ?>