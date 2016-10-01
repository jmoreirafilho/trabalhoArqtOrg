<?php 

class CPU
{

	public $registradorA = -1;
	public $registradorB = -1;
	public $registradorC = -1;
	public $registradorD = -1;
	
	function __construct()
	{
		// não faz nada
	}

	/**
	 * Função padrão para pegar valor do Registrador A
	 * 
	 * @return Retorna o valor do registrador A
	*/
	public function pegaRegistradorA()
	{
		return $this->registradorA;
	}

	/**
	 * Função padrão para atribuir um valor ao registrador A
	 * 
	 * @param int $valor Valor para atribuir ao registrador A
	*/
	public function defineRegistradorA($valor)
	{
		$this->registradorA = $valor;
	}

	/**
	 * Função padrão para pegar valor do Registrador B
	 * 
	 * @return Retorna o valor do registrador B
	*/
	public function pegaRegistradorB()
	{
		return $this->registradorB;
	}

	/**
	 * Função padrão para atribuir um valor ao registrador B
	 * 
	 * @param int $valor Valor para atribuir ao registrador B
	*/
	public function defineRegistradorB($valor)
	{
		$this->registradorB = $valor;
	}

	/**
	 * Função padrão para pegar valor do Registrador C
	 * 
	 * @return Retorna o valor do registrador C
	*/
	public function pegaRegistradorC()
	{
		return $this->registradorC;
	}

	/**
	 * Função padrão para atribuir um valor ao registrador C
	 * 
	 * @param int $valor Valor para atribuir ao registrador C
	*/
	public function defineRegistradorC($valor)
	{
		$this->registradorC = $valor;
	}

	/**
	 * Função padrão para pegar valor do Registrador D
	 * 
	 * @return Retorna o valor do registrador D
	*/
	public function pegaRegistradorD()
	{
		return $this->registradorD;
	}

	/**
	 * Função padrão para atribuir um valor ao registrador D
	 * 
	 * @param int $valor Valor para atribuir ao registrador D
	*/
	public function defineRegistradorD($valor)
	{
		$this->registradorD = $valor;
	}

	/**
	 * Processa quando comando for ADD
	 * 
	 * @param Array $comando Comando vindo direto do Buffer
	*/
	public function processaComandoAdd($comando)
	{
		// PROBLEMA:
		// E QUANDO FOR UM 0X00F
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
			}
		}

		switch ($comando[1]) {
			case '-2':
				$valor = self::pegaRegistradorA() + $valor2;
				self::defineRegistradorA($valor);
				return $valor;
				break;

			case '-2':
				$valor = self::pegaRegistradorB() + $valor2;
				self::defineRegistradorB($valor);
				return $valor;
				break;

			case '-4':
				$valor = self::pegaRegistradorC() + $valor2;
				self::defineRegistradorC($valor);
				return $valor;
				break;

			case '-5':
				$valor = self::pegaRegistradorD() + $valor2;
				self::defineRegistradorD($valor);
				return $valor;
				break;
		}
	}

	/**
	 * Processa quando comando for MOV
	 * 
	 * @param Array $comando Comando vindo direto do Buffer
	*/
	public function processaComandoMov($comando)
	{
		
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
	 * @param type $comando 
	 * @return type
	 */
	public function processaComando($comando)
	{
		# code...
	}
}
 ?>